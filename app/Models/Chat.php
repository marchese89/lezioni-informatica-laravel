<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ChatMessage;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';

    protected $fillable = [
        'tipo_prodotto',
        'id_prodotto',
        'id_studente',
    ];

    public function chat_messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }
}
