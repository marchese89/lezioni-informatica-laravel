<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Chat;

class ChatMessage extends Model
{
    use HasFactory;

    public function chat(): BelongsTo
    {                                      // foreign_key owner_key
        return $this->belongsTo(Chat::class,'chat_id', 'id');
    }
}
