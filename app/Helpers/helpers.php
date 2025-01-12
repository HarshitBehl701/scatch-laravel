<?php


use App\Models\Api\v1\CategoryModal\CategoryModal;
use App\Models\Api\v1\SubCategoryModal\SubCategoryModal;
use App\Models\Api\v1\UserModal\UserModal;
use App\Models\Api\v1\SellerModal\SellerModal;
use App\Models\Api\v1\ProductModal\ProductModal;
use App\Models\Api\v1\CommentModal\CommentModal;


if(!function_exists('get_Categories')){
    function get_Categories_and_Sub_Categories(){
        $categoriesRawData   =  CategoryModal::where('is_active','1')->get();
        if($categoriesRawData){
            $categoriesFormatedData =  [];
            $cateogriesRawDataToArray  = $categoriesRawData->toArray();

            foreach($cateogriesRawDataToArray  as $rawdata){
                $subCategoriesNames  =  [];
                $idArray = explode(',',$rawdata['subCategory_id']);
                if(is_array($idArray)){
                    foreach($idArray  as  $subCategoryId){
                        $subCategoryRawData  = SubCategoryModal::where('id',$subCategoryId)->where('is_active','1')->first();
                        if($subCategoryRawData){
                            array_push($subCategoriesNames,$subCategoryRawData->name);
                        }
                    }
                }

                $newArr =  [
                    'name' => $rawdata['name'],
                    'image' => $rawdata['image'],
                    'subCategories' => $subCategoriesNames,
                ];
                array_push($categoriesFormatedData,$newArr);
            }
            return  $categoriesFormatedData;
        }
        else  return  [];
    }
}

if(!function_exists('get_page_data')){
    function  get_page_data($page,$param1 = null,$param2 = null){
        $requestPagesRequiredData  = [
            'home' => ['categories','products'],
            'products' => ['categories'],
            'add-product' => ['categories'],
            'edit-product' => ['categories','product_details'],
            'profile' => ['userDetail'],
            'edit-profile' => ['userDetail'],
            'all-products' => ['seller_product_list'],
            'live-products' => ['seller_live_product_list'],
            'product-details' => ['product_details'],
        ];
      
        $helperFunctionsNaming  = [
            'categories' => 'get_Categories_and_Sub_Categories',
            'userDetail' => 'get_user_details',
            'products' => 'get_all_products',
            'product_details' => 'get_product_details',
            'seller_product_list' => 'seller_all_products_list',
            'seller_live_product_list' => 'seller_all_live_products_list',
        ];


        if($page ==  '/') $page  = 'home';
        if(array_key_exists($page,$requestPagesRequiredData)){
            $requiredFunctions = $requestPagesRequiredData[$page];
            $requiredData =  [];
            foreach($requiredFunctions as $functionName){
                $function  = $helperFunctionsNaming[$functionName];
                $data = $function($param1,$param2);
                $requiredData += [$functionName  => $data];
            }
            return   $requiredData;
        }else return  [];
    }
}

if(!function_exists('get_all_products')){
    function   get_all_products(){
        $products  =   ProductModal::where('is_active','1')->get();

        if($products->count()  > 0){
            $requiredData  =  [];
            
            foreach($products as $value){

                $seller = SellerModal::find($value->sellerId);

                $brandDetails =  [
                    'brandName' => $seller->brandName,
                    'brandLogo' => $seller->brandLogo,
                ];

                $category =  CategoryModal::find($value->categoryId)->name ?? $value->categoryId;
                $subcategory =  CategoryModal::find($value->subCategoryId)->name ?? $value->subCategoryId;

                $commentsRawData = CommentModal::whereIn('id',explode(',',$value->commentId))->get();
                $comments  = [];

                if($commentsRawData->count()   > 0){
                    foreach($commentRawData as $rawData){

                        if($rawData->customerId){
                            $customer =  UserModal::find($rawData->customerId);
                        }

                        $comments[] = [
                            'user' => $customer->name,
                            'comment' => $rawData->comment,
                            'commentDate' => $rawData->created_at,
                        ];
                    }
                }


                

                $requiredData[]  =  [
                    'id'  =>  $value->id,
                    'name'  =>  $value->name,
                    'description'  =>  $value->description,
                    'category'  =>  $category,
                    'subcategory'  =>  $subcategory,
                    'brandDetails'  =>  $brandDetails,
                    'images'  =>  explode(',',$value->images),
                    'price'  =>  $value->price,
                    'discount'  =>  $value->discount,
                    'platformFee'  =>  $value->platformFee,
                    'views'  =>  $value->views,
                    'number_of_customer_rate'  =>  $value->number_of_customer_rate,
                    'rating'  =>  $value->rating,
                    'comments'  =>  $comments,
                ];
            }

        }
        return [];
    }
}

if(!function_exists('get_user_details')){
    function get_user_details(){
        $currentUser  = session('userType');

        if($currentUser ==  'user'){
            $user  = UserModal::where('email',session('email'))->where('is_active','1')->first();            

            $responseData =  [
                'name' => $user->name,
                'picture' => $user->picture,
                'email' => $user->email,
                'contact' => $user->contact,
                'address' => $user->address,
                'cartId' => $user->cartId,
                'whislitId' => $user->whislitId,
                'orderId' => $user->orderId,
            ];

            return  $responseData;

        }else if($currentUser == 'seller'){
            $user  = SellerModal::where('email',session('email'))->where('is_active','1')->first();
            
            $responseData =  [
                'name' => $user->name,
                'brandName' => $user->brandName,
                'brandLogo' => $user->brandLogo,
                'email' => $user->email,
                'contact' => $user->contact,
                'address' => $user->address,
                'productId' => $user->productId,
                'gstin' => $user->gstin,
            ];
            return $responseData;

        }else{
            return [];
        }
    }
}

if(!function_exists('get_product_details')){
    function  get_product_details($productName,$productId){

        if($productName  || $productId){
            if($productName &&  $productId){
                $product = ProductModal::where('id',$productId)->where('name',$productName)->first();
                if(!$product){
                    $product  =  ProductModal::where('id',$productId)->first();
                    if(!$product){
                        $product  =  ProductModal::where('name',$productName)->first();
                        if(!$product)   return [];
                    }
                }
    
            }elseif($productName && !$productId){
                $product = ProductModal::where('name',$productId)->first();
                if(!$product) return [];
            }else  return  [];

            $currentUser  = session('userType');

            if($currentUser  == 'seller'){

                $category =  CategoryModal::find($product->categoryId)  ?? $product->categoryId;
                $subCategory  = SubCategoryModal::find($product->subCategoryId) ?? $product->subCategoryId;
                $commentsRawData  =  CommentModal::whereIn('id',explode(',',$product->commentId))->get();
                $comments  = [];

                if($commentsRawData->count() > 0){
                    foreach($commentRawData  as $comment){
                        $customer =  UserModal::find($comment->customerId);
                        $comments[] = [
                            'user' => $customer->name  ?? $comment->customerId,
                            'comment' => $comment->comment,
                            'commentDate' => $comment->created_at,
                        ];
                    }
                }

                $requiredData =  [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'category' => $category->name  ?? $product->categoryId,
                    'subcategory' => $subCategory->name ?? $product->subCategoryId,   
                    'images' => explode(',',$product->images),
                    'price' => $product->price,
                    'discount' => $product->discount,
                    'platformFee' => $product->platformFee,
                    'views' => $product->views,
                    'number_of_customer_rate' => $product->number_of_customer_rate,
                    'rating' => $product->rating,
                    'comments' => $comments ??  $product->commentId,
                    'status' => $product->is_active,
                ];


                return $requiredData;

            }else if($currentUser  == 'user'){

            }else return  [];
            
        }

        return [];
    }
}

if(!function_exists('seller_all_products_list')){
    function seller_all_products_list(){
        $productsRawData = get_seller_all_products();
        if(count($productsRawData)  >   0){
            $requiredData  = [];

            foreach($productsRawData  as $data){
                $requiredData[] = [
                    'id'  =>  $data['id'],
                    'name'  =>  $data['name'],
                    'description'  =>  $data['description'],
                    'price'  =>  $data['price'],
                    'images'  =>  $data['images'],
                ];
            }
            return  $requiredData;

        }else{
            return  [];
        }
    }
}

if(!function_exists('seller_all_live_products_list')){
    function seller_all_live_products_list(){
        $productsRawData = get_seller_all_products();
        if(count($productsRawData)  >   0){
            $requiredData  = [];

            foreach($productsRawData  as $data){
                if($data['status'] == '1'){
                    $requiredData[] = [
                        'id'  =>  $data['id'],
                        'name'  =>  $data['name'],
                        'description'  =>  $data['description'],
                        'price'  =>  $data['price'],
                        'images'  =>  $data['images'],
                    ];
                }
            }
            return  $requiredData;

        }else{
            return  [];
        }
    }
}

//Helpers  Helper  Function
if(!function_exists('get_seller_all_products')){
    function get_seller_all_products(){
        $currentUser =  session("userType");
        $sellerEmail =  session('email');

        $seller  =  SellerModal::where('email',$sellerEmail)->where("is_active",'1')->first();

        if(!$seller){
            return [];
        }else{
            $products  = ProductModal::where("sellerId",$seller->id)->get();
            
            if(!$products){
                return  [];
            }else{
                $requiredData = [];

                foreach($products as $product){

                    if($product->categoryId){
                        $category =   CategoryModal::find($product->categoryId);
                    }
                    
                    if($product->subCategoryId){
                        $subCategory =   CategoryModal::find($product->subCategoryId);
                    }

                    if($product->commentId){
                        $commentRawData  = CommentModal::whereIn('id',explode(',',$product->commentId))->get();

                        if($commentRawData->count()  >  0){
                            $comments = [];
                            foreach($commentRawData as $rawData){

                                if($rawData->customerId){
                                    $customer =  UserModal::find($rawData->customerId);
                                }

                                $comments[] = [
                                    'user' => $customer->name,
                                    'comment' => $rawData->comment,
                                    'commentDate' => $rawData->created_at,
                                ];
                            }
                        }

                    }

                    $requiredData[] =  [
                        'id' =>  $product->id,
                        'name' =>  $product->name,
                        'description' =>  $product->description,
                        'images' =>  explode(',',$product->images),
                        'price' =>  $product->price,
                        'discount' =>  $product->discount,
                        'platformFee' =>  $product->platformFee,
                        'views' =>  $product->views,
                        'number_of_customer_rate' =>  $product->number_of_customer_rate,
                        'rating' =>  $product->rating,
                        'comments' =>  $comments  ?? [],
                        'category' =>  $category->name ?? $product->categoryId,
                        'subCategory' =>  $subCategory->name ?? $product->subCategoryId,
                        'status' =>  $product->is_active,
                    ];
                }

                return  $requiredData;
            }

        }

    }
}