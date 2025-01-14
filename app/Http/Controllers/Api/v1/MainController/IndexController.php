<?php

namespace App\Http\Controllers\Api\v1\MainController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Api\v1\ProductModal\ProductModal;
use  App\Models\Api\v1\SellerModal\SellerModal;
use  App\Models\Api\v1\CategoryModal\CategoryModal;
use  App\Models\Api\v1\SubCategoryModal\SubCategoryModal;

class IndexController extends Controller
{
    public function  pageRouter($page  = '/',$param1  = null   , $param2   =  null){
        require_once app_path('Helpers/helpers.php');
        $pagePath = $this->pagePath;
        $pageData =  get_page_data($page,$param1,$param2);
        return array_key_exists($page,$pagePath)  ? view($pagePath[$page],['pageData'=>$pageData]) : view($pagePath['home'],['pageData' =>$pageData ]);
    }

    public function loginRegisterPageRouter($loginRegisterPage){
        $pagePath = $this->pagePath;
        return array_key_exists($loginRegisterPage,$pagePath)  ? view($pagePath[$loginRegisterPage]) : view($pagePath['login']);
    }

    public function getSearchData(){
        $searchData = [];

        // Fetch product names
        $products = ProductModal::where('is_active', '1')->pluck('name')->toArray();
        $searchData = array_merge($searchData, $products);

        // Fetch brand names
        $brands = SellerModal::where('is_active', '1')->pluck('brandName')->toArray();
        $searchData = array_merge($searchData, $brands);

        // Fetch category names
        $categories = CategoryModal::where('is_active', '1')->pluck('name')->toArray();
        $searchData = array_merge($searchData, $categories);

        // Return flattened array in JSON response
        return response()->json([
            'status' => 'success',
            'data' => $searchData,
        ]);
    }

}
