<?php

namespace App\Models\Api\v1\OrderModal;

use Illuminate\Database\Eloquent\Model;

class OrderModal extends Model
{
    protected  $table = 'orders';

    protected $fillable = [
    'productId',
    'customerId',
    'sellerId',
    'commentId',
    'amount',
    'rating_by_user',
    'quantity',
    'status',
    'is_active'
    ];
}
