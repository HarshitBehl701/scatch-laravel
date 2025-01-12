<?php

namespace App\Models\Api\v1\CategoryModal;

use Illuminate\Database\Eloquent\Model;

class CategoryModal extends Model
{
    protected  $table = 'categories';

    protected $fillable = [
    'name',
    'is_active'
    ];
}
