<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Course;

class Lesson extends Model
{
    use HasFactory;

    public function course(): BelongsTo
    {                                      // foreign_key     owner_key
        return $this->belongsTo(Course::class,'course_id', 'id');
    }
}
