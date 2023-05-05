<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Exercise extends Model
{
    use HasFactory;

    public function course(): BelongsTo
    {                                      // foreign_key     owner_key
        return $this->belongsTo(Course::class,'course_id', 'id');
    }
}
