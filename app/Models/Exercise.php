<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'trace_path',
        'execution_path',
    ];

    public function course(): BelongsTo
    {                                      // foreign_key     owner_key
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
