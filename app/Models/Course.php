<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Matter;
use App\Models\Lesson;
use App\Models\Execise;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    public function matter(): BelongsTo
    {                                      // foreign_key owner_key
        return $this->belongsTo(Matter::class,'matter_id', 'id');
    }
    public function lessons(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(Course::class);
    }

}
