<?php

namespace App\Http\Controllers\Api\v1\UserAdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public  function  pageRouter($page  = '/'){
        $pagePath = $this->adminPagePath;
        return  (array_key_exists($page,$pagePath)) ?  view($pagePath[$page]) : view($pagePath['/']);
    }
}
