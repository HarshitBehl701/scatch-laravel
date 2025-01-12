<?php

namespace App\Models\Api\v1\SellerModal;

use Illuminate\Database\Eloquent\Model;

class SellerModal extends Model
{
    protected  $table = 'sellers';

    protected $fillable = [
    'brandLogo',
    'name',
    'brandName',
    'email',
    'password',
    'contact',
    'address',
    'productId',
    'gstin',
    'is_active'
    ];
}
