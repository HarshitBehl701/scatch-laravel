<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public  $pagePath  = [
        '/' =>  'pages.commonPages.home',
        'home' =>  'pages.commonPages.home',
        'about' =>  'pages.commonPages.about',
        'faq' =>  'pages.commonPages.faq',
        'products' =>  'pages.commonPages.products',
        'product_detail' =>  'pages.commonPages.mainProductDetail',
        'login' =>  'pages.userPages.login',
        'seller-login' =>  'pages.sellerPages.login',
        'register' =>  'pages.userPages.register',
        'seller-register' =>  'pages.sellerPages.register',
      ];

    public   $adminPagePath = [
      '/' =>  'pages.adminPages.commonPages.profile',
      'profile' =>  'pages.adminPages.commonPages.profile',
      'edit-profile' =>  'pages.adminPages.commonPages.editProfile',
      'orders' =>  'pages.adminPages.commonPages.productList',
      'cart' =>  'pages.adminPages.commonPages.productList',
      'whislist' =>  'pages.adminPages.commonPages.productList',
      'product-details' =>  'pages.adminPages.commonPages.productDetails',
      'all-products' =>  'pages.adminPages.commonPages.productList',
      'live-products' =>  'pages.adminPages.commonPages.productList',
      'manage-orders' =>  'pages.adminPages.commonPages.productList',
      'add-product' =>  'pages.adminPages.sellerAdminPages.addOrEditProduct',
      'edit-product' =>  'pages.adminPages.sellerAdminPages.addOrEditProduct',
    ];
}
