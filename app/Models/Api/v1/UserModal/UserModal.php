<?php

namespace App\Models\Api\v1\UserModal;

use Illuminate\Database\Eloquent\Model;

class UserModal extends Model
{
    protected  $table = 'users';

    protected $fillable = [
    'picture',
    'name',
    'email',
    'password',
    'contact',
    'address',
    'cartId',
    'whislistId',
    'orderId',
    'is_active'
    ];
}