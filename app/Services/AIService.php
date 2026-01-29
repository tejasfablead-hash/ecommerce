<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    public function ask(string $message, array $context = []): string
    {
        $messages = [];

        // System message
        $messages[] = [
            'role' => 'system',
            'content' => 'You are a helpful ecommerce assistant.'
        ];

        // Add previous conversation
        foreach ($context as $item) {
            $messages[] = [
                'role' => $item['role'],
                'content' => $item['content'],
            ];
        }

        // Add current user message
        $messages[] = [
            'role' => 'user',
            'content' => $message,
        ];

        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.openai.key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                   'model' => 'o3-mini',
                'messages' => $messages,
            ]);

            // 🔍 Log status & response
            Log::info('OpenAI Status', ['status' => $response->status()]);
            Log::info('OpenAI Response', $response->json());

            // Handle quota exceeded
            if ($response->failed()) {
                $json = $response->json();
                if(isset($json['error']['code']) && $json['error']['code'] === 'insufficient_quota'){
                    return 'AI service unavailable: quota exceeded. Please check your OpenAI plan.';
                }
                if(isset($json['error']['type']) && $json['error']['type'] === 'rate_limit'){
                    return 'AI service temporarily unavailable due to rate limiting. Try again later.';
                }
                return 'AI service failed.';
            }

            return $response->json('choices.0.message.content') ?? 'No response from AI.';
        } catch (\Throwable $e) {
            Log::error('OpenAI Exception', ['message' => $e->getMessage()]);
            return 'AI service failed due to server error.';
        }
    }
}
