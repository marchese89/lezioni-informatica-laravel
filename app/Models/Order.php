<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\OrderProduct;
use App\Models\Student;

class Order extends Model
{
    use HasFactory;

    public function order_products(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function student(): BelongsTo
    {                                      // foreign_key owner_key
        return $this->belongsTo(Student::class,'student_id', 'id');
    }

}
