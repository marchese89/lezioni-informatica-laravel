<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonOnRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'student_id',
        'trace',
        'execution',
        'price',
        'escaped',
        'paid'
    ];


    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
