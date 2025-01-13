<?php

namespace App\Http\Controllers\Api\v1\MainController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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


}
