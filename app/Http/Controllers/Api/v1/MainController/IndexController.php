<?php

namespace App\Http\Controllers\Api\v1\MainController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function  pageRouter($page  = '/'){
        require_once app_path('Helpers/helpers.php');
        $pagePath = $this->pagePath;
        $pageData =  get_page_data($page);
        return array_key_exists($page,$pagePath)  ? view($pagePath[$page],['pageData'=>$pageData]) : view($pagePath['home'],['pageData' =>$pageData ]);
    }

    public function loginRegisterPageRouter($loginRegisterPage){
        $pagePath = $this->pagePath;
        return array_key_exists($loginRegisterPage,$pagePath)  ? view($pagePath[$loginRegisterPage]) : view($pagePath['login']);
    }


}
