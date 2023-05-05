<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Matter;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThemeArea extends Model
{
    use HasFactory;

    protected $table = 'theme_areas';

    public function matter(): HasMany
    {
        return $this->hasMany(Matter::class);
    }
}
