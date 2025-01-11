<?php

namespace App\Http\Controllers\Api\v1\MainController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function  pageRouter($page  = '/'){
        $pagePath = $this->pagePath;
        return array_key_exists($page,$pagePath)  ? view($pagePath[$page]) : view('pages.home');
    }

}
