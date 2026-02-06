<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAiChatMessage
 */
class AiChatMessage extends Model
{
    protected $table = "ai_chat_messages";
    protected $fillable = ['user_id', 'message', 'reply'];

}
