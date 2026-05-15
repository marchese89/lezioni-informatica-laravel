<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Course;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'number',
        'course_id',
        'presentation',
        'lesson',
        'price'
    ];

    public function course(): BelongsTo
    {                                      // foreign_key     owner_key
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
