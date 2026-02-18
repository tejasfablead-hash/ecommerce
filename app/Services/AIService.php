<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class AIService
{
    public function askAI($message)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an ecommerce assistant.'],
                ['role' => 'user', 'content' => $message],
            ],
        ]);

        return $response['choices'][0]['message']['content'] ?? 'No response';
    }
}
