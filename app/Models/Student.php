<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\LessonOnRequest;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function lesson_on_request(): HasMany
    {
        return $this->hasMany(LessonOnRequest::class);
    }
}
