<?php

namespace App\Models\Api\v1\CommentModal;

use Illuminate\Database\Eloquent\Model;

class CommentModal extends Model
{
    protected  $table = 'comments';

    protected $fillable = [
    'customerId',
    'productId',
    'sellerId',
    'orderId',
    'comment',
    'is_active'
    ];
}
