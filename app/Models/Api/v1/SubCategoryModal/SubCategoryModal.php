<?php

namespace App\Models\Api\v1\SubCategoryModal;

use Illuminate\Database\Eloquent\Model;

class SubCategoryModal extends Model
{
    protected  $table = 'sub_categories';

    protected $fillable = [
    'name',
    'category_id',
    'is_active'
    ];
}
