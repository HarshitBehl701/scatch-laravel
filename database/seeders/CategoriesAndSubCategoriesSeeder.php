<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\Api\v1\SubCategoryModal\SubCategoryModal;
use  App\Models\Api\v1\CategoryModal\CategoryModal;

class CategoriesAndSubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories_with_sub_categories_in_array = [
            'clothing'   =>  [
                'image' => 'clothing.jpg',
                'subCategory' =>  ['men','women']
            ],
            'shoes'   =>  [
                'image'  =>  'shoes.jpg',
                'subCategory'   => ['men','women']
            ],
            'electronics'   =>  [
                'image' =>  'electronics.jpg',
                'subCategory'  =>  ['mobiles','laptops','tablets']
            ],
            'baby'   =>  [
                'image' =>  'baby.jpg',
                'subCategory' =>  ['accessories','toys','cloth']
            ],
            'home-decor'   => [
                'image' =>'decor.jpg',
                'subCategory' =>  ''
            ],
        ];

        foreach($categories_with_sub_categories_in_array as $key => $val){
            $category = CategoryModal::create([
                'name' =>  $key,
                'image' => $val['image'],
                'subCategory_id' => '0',
                'is_active' =>  "1"
            ]);

            if(is_array($val['subCategory'])){
                $subCategoryId = [];
                foreach($val['subCategory']  as $subCategoryName){
                    $subCategory = SubCategoryModal::create([
                        'name' =>  $subCategoryName,
                        'category_id'   =>  $category->id,
                        'is_active'  => '1'
                    ]);
                    array_push($subCategoryId,$subCategory->id);
                }

                $updateCategory  = CategoryModal::find($category->id)->update(['subCategory_id' => implode(',',$subCategoryId)]);
            }

        }

    }
}
