<?php

namespace App\Models\Api\v1\ProductModal;

use Illuminate\Database\Eloquent\Model;

class ProductModal extends Model
{
    protected  $table = 'products';

    protected $fillable = [
    'name',
    'sellerId',
    'description',
    'categoryId',
    'subCategoryId',
    'images',
    'price',
    'discount',
    'platformFee',
    'views',
    'number_of_customer_rate',
    'sum_of_all_rating',
    'rating',
    'commentId',
    'is_active'
    ];
}
