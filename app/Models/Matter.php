<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ThemeArea;
use App\Models\Course;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Matter extends Model
{
    use HasFactory;

    public function theme_area(): BelongsTo
    {                                      // foreign_key     owner_key
        return $this->belongsTo(ThemeArea::class,'theme_area_id', 'id');
    }
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
