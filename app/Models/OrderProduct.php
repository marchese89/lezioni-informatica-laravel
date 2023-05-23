<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
    use HasFactory;

    public function order(): BelongsTo
    {                                      // foreign_key owner_key
        return $this->belongsTo(Order::class,'order_id', 'id');
    }
}
