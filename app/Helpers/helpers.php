<?php


use App\Models\Api\v1\CategoryModal\CategoryModal;
use App\Models\Api\v1\SubCategoryModal\SubCategoryModal;
use App\Models\Api\v1\UserModal\UserModal;
use App\Models\Api\v1\SellerModal\SellerModal;
use App\Models\Api\v1\OrderModal\OrderModal;
use App\Models\Api\v1\ProductModal\ProductModal;
use App\Models\Api\v1\CommentModal\CommentModal;

if(!function_exists('get_page_data')){
    function  get_page_data($page,$param1 = null,$param2 = null){
        $requestPagesRequiredData  = [
            'home' => ['categories','top_products','latest_fashions','newly_products'],
            'products' => ['categories','all_products'],
            'add-product' => ['categories'],
            'edit-product' => ['categories','product_details'],
            'profile' => ['userDetail'],
            'orders' => ['user_orders'],
            'cart' => ['user_cart'],
            'whislist' => ['user_whislist'],
            'edit-profile' => ['userDetail'],
            'all-products' => ['seller_product_list'],
            'live-products' => ['seller_live_product_list'],
            'product-details' => ['product_details'],
            'order-details' => ['order_details'],
            'manage-orders' => ['seller_product_orders'],
            'product_detail' => ['main_page_product_details','top_products','newly_products'],
        ];
      
        $helperFunctionsNaming  = [
            'categories' => 'get_Categories_and_Sub_Categories',
            'userDetail' => 'get_user_details',
            'top_products' => 'get_top_products',
            'latest_fashions' => 'get_latest_fashions',
            'newly_products' => 'get_newly_products',
            'all_products' => 'get_all_products',
            'user_orders' => 'get_user_all_orders',
            'user_cart' => 'get_user_all_cart_products',
            'user_whislist' => 'get_user_all_whislist_products',
            'product_details' => 'get_product_details',
            'order_details' => 'get_user_order_details',
            'main_page_product_details' => 'get_main_page_product_detail',
            'seller_product_list' => 'get_seller_all_products',
            'seller_live_product_list' => 'seller_all_live_products_list',
            'seller_product_orders' => 'get_seller_products_all_orders',
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
            
            if(session()->has('userType')   &&  session()->has('email')  && session('userType') == 'user'){
                $user  =  UserModal::where('email',session('email'))->where("is_active",'1')->first();

                if($user){
                    $cartList  = ($user->cartId) ? explode(',',$user->cartId)   : [];
                    $whislist  = ($user->whislistId) ?  explode(",",$user->whislistId) : [];
                }

            }

            foreach($products as $value){

                $in_cart  = false;
                $in_whislist  = false;

                if(isset($cartList)){
                    $in_cart =  in_array($value->id,$cartList) ? true: false;
                }
                
                if(isset($whislist)){
                    $in_whislist =  in_array($value->id,$whislist) ? true: false;
                }

                $requiredData[]  =  [
                    'id'  =>  $value->id,
                    'name'  =>  $value->name,
                    'description'  =>  $value->description,
                    'images'  =>  explode(',',$value->images),
                    'price'  =>  $value->price,
                    'discount'  =>  $value->discount,
                    'number_of_customer_rate'  =>  $value->number_of_customer_rate,
                    'rating'  =>  $value->rating,
                    'in_cart'  =>  $in_cart,
                    'in_whislist'  =>  $in_whislist,
                ];
            }
            return $requiredData;
        }
        return [];
    }
}

if(!function_exists('get_main_page_product_detail')){
    function get_main_page_product_detail($productName,$productId =  null){
        if($productName || $productId){
            if($productName && $productId){
                $product =  ProductModal::where('is_active','1')->where('name',urldecode($productName))->where('id',$productId)->first();
            }else if($productName  && !$productId){
                $product =  ProductModal::where('is_active','1')->where('name',$productName)->first();
            }

            if(!$product) return  [];
            else{

                if(session()->has('userType')   &&  session()->has('email') && session("userType") == 'user'){
                    $user  =  UserModal::where('email',session('email'))->where("is_active",'1')->first();
    
                    if($user){
                        $cartList  = ($user->cartId) ? explode(',',$user->cartId)   : [];
                        $whislist  = ($user->whislistId) ?  explode(",",$user->whislistId) : [];
                    }
    
                }

                $seller = SellerModal::find($product->sellerId);

                $brandDetails =  [
                    'brandName' => $seller->brandName,
                    'brandLogo' => $seller->brandLogo,
                ];

                $commentsRawData = CommentModal::whereIn('id',explode(',',$product->commentId))->get();
                $comments  = [];

                if($commentsRawData->count()   > 0){
                    foreach($commentsRawData as $rawData){

                        if($rawData->customerId){
                            $customer =  UserModal::find($rawData->customerId);
                        }

                        $comments[] = [
                            'picture' => $customer->picture,
                            'name' => $customer->name,
                            'comment' => $rawData->comment,
                            'dateOfComment' => $rawData->created_at,
                        ];
                    }
                }


                $in_cart  = false;
                $in_whislist  = false;

                if(isset($cartList)){
                    $in_cart =  in_array($product->id,$cartList) ? true: false;
                }
                
                if(isset($whislist)){
                    $in_whislist =  in_array($product->id,$whislist) ? true: false;
                }


                $requiredData  =  [
                    'id'  =>  $product->id,
                    'name'  =>  $product->name,
                    'description'  =>  $product->description,
                    'brandDetails'  =>  $brandDetails,
                    'images'  =>  explode(',',$product->images),
                    'price'  =>  $product->price,
                    'discount'  =>  $product->discount,
                    'platformFee'  =>  $product->platformFee,
                    'number_of_customer_rate'  =>  $product->number_of_customer_rate,
                    'rating'  =>  $product->rating,
                    'comments'  =>  $comments,
                    'in_cart'  =>  $in_cart,
                    'in_whislist'  =>  $in_whislist,
                ];
                return $requiredData;
            }
        }
        return [];
    }
}

if(!function_exists('get_top_products'))
{
    function  get_top_products($limit = 5){

        $limit  = (is_integer($limit)) ? $limit: 5;

        $rawProductsData = ProductModal::where('is_active','1')->orderBy('views','DESC')->limit($limit)->get();

        if($rawProductsData->count() >   0){

            if(session()->has('userType')   &&  session()->has('email') && session("userType") == 'user'){
                $user  =  UserModal::where('email',session('email'))->where("is_active",'1')->first();

                if($user){
                    $cartList  = ($user->cartId) ? explode(',',$user->cartId)   : [];
                    $whislist  = ($user->whislistId) ?  explode(",",$user->whislistId) : [];
                }

            }

            $requiredData = [];
            
            foreach($rawProductsData as  $value){
                $in_cart  = false;
                $in_whislist  = false;

                if(isset($cartList)){
                    $in_cart =  in_array($value->id,$cartList) ? true: false;
                }
                
                if(isset($whislist)){
                    
                    $in_whislist =  in_array($value->id,$whislist) ? true: false;
                }
                

                $requiredData[]  =  [
                    'id'  =>  $value->id,
                    'name'  =>  $value->name,
                    'description'  =>  $value->description,
                    'images'  =>  explode(',',$value->images),
                    'price'  =>  $value->price,
                    'discount'  =>  $value->discount,
                    'number_of_customer_rate'  =>  $value->number_of_customer_rate,
                    'rating'  =>  $value->rating,
                    'in_cart'  =>  $in_cart,
                    'in_whislist'  =>  $in_whislist,
                ];
            }

            return  $requiredData;
        }

        return [];

    }   
}

if(!function_exists('get_latest_fashions')){
    function  get_latest_fashions($limit =  5){

        $limit  = (is_integer($limit)) ? $limit: 5;

        $category =  CategoryModal::where('name','clothing')->where('is_active','1')->first();

        if(!$category) return  [];

        $rawProductsData = ProductModal::where('is_active','1')->where('categoryId',$category->id)->orderBy('views','DESC')->limit($limit)->get();

        if($rawProductsData->count() >   0){
            if(session()->has('userType')   &&  session()->has('email') && session("userType") == 'user'){
                $user  =  UserModal::where('email',session('email'))->where("is_active",'1')->first();

                if($user){
                    $cartList  = ($user->cartId) ? explode(',',$user->cartId)   : [];
                    $whislist  = ($user->whislistId) ?  explode(",",$user->whislistId) : [];
                }

            }
            $requiredData = [];
            
            foreach($rawProductsData as  $value){
                $in_cart  = false;
                $in_whislist  = false;

                if(isset($cartList)){
                    $in_cart =  in_array($value->id,$cartList) ? true: false;
                }
                
                if(isset($whislist)){
                    $in_whislist =  in_array($value->id,$whislist) ? true: false;
                }

                $requiredData[]  =  [
                    'id'  =>  $value->id,
                    'name'  =>  $value->name,
                    'description'  =>  $value->description,
                    'images'  =>  explode(',',$value->images),
                    'price'  =>  $value->price,
                    'discount'  =>  $value->discount,
                    'number_of_customer_rate'  =>  $value->number_of_customer_rate,
                    'rating'  =>  $value->rating,
                    'in_cart'  =>  $in_cart,
                    'in_whislist'  =>  $in_whislist,
                ];
            }

            return  $requiredData;
        }

        return [];
    }
}

if(!function_exists("get_newly_products")){
    function  get_newly_products($limit =  null){
        
        $productsRawData  = ($limit && is_integer($limit)) ? ProductModal::where('is_active','1')->orderBy('id','DESC')->limit($limit)->get() :  ProductModal::where('is_active','1')->orderBy('id','DESC')->get();

        if($productsRawData->count() > 0){

            if(session()->has('userType')   &&  session()->has('email') && session("userType") == 'user'){
                $user  =  UserModal::where('email',session('email'))->where("is_active",'1')->first();

                if($user){
                    $cartList  = ($user->cartId) ? explode(',',$user->cartId)   : [];
                    $whislist  = ($user->whislistId) ?  explode(",",$user->whislistId) : [];
                }

            }

            $requiredData  = [];

            foreach($productsRawData as  $value){
                $in_cart  = false;
                $in_whislist  = false;

                if(isset($cartList)){
                    $in_cart =  in_array($value->id,$cartList) ? true: false;
                }
                
                if(isset($whislist)){
                    $in_whislist =  in_array($value->id,$whislist) ? true: false;
                }
                

                $requiredData[]  =  [
                    'id'  =>  $value->id,
                    'name'  =>  $value->name,
                    'description'  =>  $value->description,
                    'images'  =>  explode(',',$value->images),
                    'price'  =>  $value->price,
                    'discount'  =>  $value->discount,
                    'number_of_customer_rate'  =>  $value->number_of_customer_rate,
                    'rating'  =>  $value->rating,
                    'in_cart'  =>  $in_cart,
                    'in_whislist'  =>  $in_whislist,
                ];
            }

            return $requiredData;


        }

        return  [];

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
                $commentsRawData  =  CommentModal::whereIn('id',explode(',',$product->commentId))->get();
                $comments  = [];

                if($commentsRawData->count() > 0){
                    foreach($commentsRawData  as $comment){
                        $customer =  UserModal::find($comment->customerId);
                        $comments[] = [
                            'name' => $customer->name,
                            'picture' => $customer->picture,
                            'comment' => $comment->comment,
                            'dateOfComment' => $comment->created_at,
                        ];
                    }
                }

                $requiredData =  [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'images' => explode(',',$product->images),
                    'price' => $product->price,
                    'discount' => $product->discount,
                    'platformFee' => $product->platformFee,
                    'views' => $product->views,
                    'number_of_customer_rate' => $product->number_of_customer_rate,
                    'rating' => $product->rating,
                    'comments' => $comments,
                    'status' => $product->is_active,
                ];


                return $requiredData;

            }else if($currentUser  == 'user'){

                if(session()->has('userType')   &&  session()->has('email')){
                    $user  =  UserModal::where('email',session('email'))->where("is_active",'1')->first();
    
                    if($user){
                        $cartList  = ($user->cartId) ? explode(',',$user->cartId)   : [];
                        $whislist  = ($user->whislistId) ?  explode(",",$user->whislistId) : [];
                    }
    
                }
                $commentsRawData  =  CommentModal::whereIn('id',explode(',',$product->commentId))->get();
                $comments  = [];

                if($commentsRawData->count() > 0){
                    foreach($commentsRawData  as $comment){
                        $customer =  UserModal::find($comment->customerId);
                        $comments[] = [
                            'picture' => $customer->picture,
                            'name' => $customer->name,
                            'comment' => $comment->comment,
                            'dateOfComment' => $comment->created_at,
                        ];
                    }
                }

                $in_cart  = false;
                $in_whislist  = false;

                if(isset($cartList)){
                    $in_cart =  in_array($product->id,$cartList) ? true: false;
                }
                
                if(isset($whislist)){
                    $in_whislist =  in_array($product->id,$whislist) ? true: false;
                }
                

                $requiredData =  [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'images' => explode(',',$product->images),
                    'price' => $product->price,
                    'discount' => $product->discount,
                    'platformFee' => $product->platformFee,
                    'number_of_customer_rate' => $product->number_of_customer_rate,
                    'rating' => $product->rating,
                    'comments' => $comments,
                    'in_cart' => $in_cart,
                    'in_whislist' => $in_whislist,
                ];

                return $requiredData;

            }else return  [];
            
        }

        return [];
    }
}

if(!function_exists('seller_all_live_products_list')){
    function seller_all_live_products_list(){
        $currentUser =  session("userType");
        $sellerEmail =  session('email');

        $seller  =  SellerModal::where('email',$sellerEmail)->where("is_active",'1')->first();

        if(!$seller){
            return [];
        }else{
            $products  = ProductModal::where("sellerId",$seller->id)->where('is_active','1')->get();
            
            if(!$products){
                return  [];
            }else{
                $requiredData = [];

                foreach($products as $product){
                    $requiredData[] =  [
                        'id' =>  $product->id,
                        'name' =>  $product->name,
                        'description' =>  $product->description,
                        'images' =>  explode(',',$product->images),
                        'price' =>  $product->price,
                        'views' =>  $product->views,
                        'rating' =>  $product->rating,
                    ];
                }

                return  $requiredData;
            }

        }
    }
}

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
                    $requiredData[] =  [
                        'id' =>  $product->id,
                        'name' =>  $product->name,
                        'description' =>  $product->description,
                        'images' =>  explode(',',$product->images),
                        'price' =>  $product->price,
                        'views' =>  $product->views,
                        'rating' =>  $product->rating,
                    ];
                }

                return  $requiredData;
            }

        }
    }
}

if(!function_exists('getFilteredProductsData')){
    function getFilteredProductsData($queryArray,$singleQuery) {
        $query = ProductModal::query();

        if(is_array($queryArray) && count($queryArray)  > 0){

            if (!empty($queryArray['category'])) {
                $category =  CategoryModal::where('name','like','%'.$queryArray['category'].'%')->first();
                
                if($category){
                    $query->where('categoryId', $category->id);
                }
    
            }
        
            if (!empty($queryArray['sub_category'])) {
                $subCategory =  SubCategoryModal::where('name','like','%'.$queryArray['sub_category'].'%')->first();
                
                if($subCategory){
                    $query->where('subCategoryId', $subCategory->id);
                }
            }
        
            if (!empty($queryArray['sort'])) {
                if ($queryArray['sort'] == 'price_asc') {
                    $query->orderByRaw('price - (price * discount / 100) asc');
                } elseif ($queryArray['sort'] == 'price_desc') {
                    $query->orderByRaw('price - (price * discount / 100) desc');
                } elseif ($queryArray['sort'] == 'rating') {
                    $query->orderBy('rating', 'desc');
                } elseif ($queryArray['sort'] == 'top_products') {
                    $query->orderBy('views', 'desc');
                }
            }
    
            if (!empty($queryArray['min_price']) && !empty($queryArray['max_price'])) {
                $query->whereRaw('price - (price * discount / 100) between ? and ?', [$queryArray['min_price'], $queryArray['max_price']]);
            } elseif (!empty($queryArray['min_price'])) {
                $query->whereRaw('price - (price * discount / 100) >= ?', [$queryArray['min_price']]);
            } elseif (!empty($queryArray['max_price'])) {
                $query->whereRaw('price - (price * discount / 100) <= ?', [$queryArray['max_price']]);
            }
        
            if (!empty($queryArray['product'])) {
                $query->where('name', 'like', '%' . $queryArray['product'] . '%');
            }
        
            if (!empty($queryArray['product_id'])) {
                $query->where('id', $queryArray['product_id']);
            }
        
            if (!empty($queryArray['brand'])) {
                $seller = SellerModal::where('brandName','like','%'.$queryArray['brand'].'%')->where('is_active','1')->first();
                if($seller){
                    $query->where('sellerId', $seller->id);
                }
            }

        }else{
            $category =  CategoryModal::where("name",$singleQuery)->where("is_active",'1')->first();
            if($category){
                $query->where('categoryId', $category->id);
            }else{
                $query->where('name','like','%'.$singleQuery.'%');
            }
        }
    
        $responseData  = $query->get();

        if($responseData->count()   >  0){

            if(session()->has('userType')   &&  session()->has('email')  && session("userType") == 'user'){
                $user  =  UserModal::where('email',session('email'))->where("is_active",'1')->first();

                if($user){
                    $cartList  = ($user->cartId) ? explode(',',$user->cartId)   : [];
                    $whislist  = ($user->whislistId) ?  explode(",",$user->whislistId) : [];
                }

            }

            $requiredData  =  [];
            
            foreach($responseData as $value){
                $in_cart  = false;
                $in_whislist  = false;

                if(isset($cartList)){
                    $in_cart =  in_array($value->id,$cartList) ? true: false;
                }
                
                if(isset($whislist)){
                    $in_whislist =  in_array($value->id,$whislist) ? true: false;
                }
                

                $requiredData[]  =  [
                    'id'  =>  $value->id,
                    'name'  =>  $value->name,
                    'images'  =>  explode(',',$value->images),
                    'price'  =>  $value->price,
                    'discount'  =>  $value->discount,
                    'platformFee'  =>  $value->platformFee,
                    'number_of_customer_rate'  =>  $value->number_of_customer_rate,
                    'rating'  =>  $value->rating,
                    'in_cart'  =>  $in_cart,
                    'in_whislist'  =>  $in_whislist,
                ];
            }
            return $requiredData;            

        }


        return [];
    }    
}

if(!function_exists('get_user_all_orders')){
    function  get_user_all_orders(){
        $userType  = session('userType');
        if($userType !==  'user') return  [];

        $user = UserModal::where('email',session('email'))->where('is_active','1')->first();

        if($user){

            $orders = OrderModal::where('customerId',$user->id)->where('is_active','1')->where('status','!=','cancel')->get();

            if($orders->count() > 0){
                $requiredData = [];

                foreach($orders as $value){
                    $product = ProductModal::where('id',$value->productId)->where('is_active','1')->first();
                    if($product){

                        $requiredData[] = [
                            'id' =>  $product->id,
                            'name' =>  $product->name,
                            'description' =>  $product->description,
                            'images' =>  explode(',',$product->images),
                            'price' =>  $value->amount,
                            'discount' =>  $value->discount,
                            'rating' =>  $product->rating,
                            'number_of_customer_rate' =>  $product->number_of_customer_rate,
                            'orderDetails' => [
                                'orderId'  =>  $value->id,
                            ]
                        ];


                    }
                }
                
                return  $requiredData;
            }
        }  
        return [];
    }
}

if(!function_exists('get_user_all_cart_products')){
    function get_user_all_cart_products(){
        $userType  = session('userType');
        if($userType !==  'user') return  [];

        $user = UserModal::where('email',session('email'))->where('is_active','1')->first();

        if($user){

            $cartProducts = ProductModal::whereIn('id',explode(',',$user->cartId))->where('is_active','1')->get();

            if($cartProducts->count() > 0){
                
                $requiredData = [];
                
                foreach($cartProducts as $value){
                    $requiredData[] = [
                        'id' =>  $value->id,
                        'name' =>  $value->name,
                        'description' =>  $value->description,
                        'images' =>  explode(',',$value->images),
                        'price' =>  $value->price,
                        'discount' =>  $value->discount,
                        'rating' =>  $value->rating,
                        'number_of_customer_rate' =>  $value->number_of_customer_rate,
                    ];

                }
                
                return  $requiredData;
            }
        }  
        return [];
    }
}

if(!function_exists('get_user_all_whislist_products')){
    function get_user_all_whislist_products(){
        $userType  = session('userType');
        if($userType !==  'user') return  [];

        $user = UserModal::where('email',session('email'))->where('is_active','1')->first();

        if($user){

            $cartProducts = ProductModal::whereIn('id',explode(',',$user->whislistId))->where('is_active','1')->get();

            if($cartProducts->count() > 0){
                
                $requiredData = [];
                
                foreach($cartProducts as $value){
                    $requiredData[] = [
                        'id' =>  $value->id,
                        'name' =>  $value->name,
                        'description' =>  $value->description,
                        'images' =>  explode(',',$value->images),
                        'price' =>  $value->price,
                        'discount' =>  $value->discount,
                        'rating' =>  $value->rating,
                        'number_of_customer_rate' =>  $value->number_of_customer_rate,
                    ];

                }
                
                return  $requiredData;
            }
        }  
        return [];
    }
}

if(!function_exists('get_user_order_details')){
    function get_user_order_details($productName,$orderId){
        if(session()->has('userType') && session()->has('email')){
            $currentUser  =  session('userType');

            if($currentUser !==  'user') return [];

            $user =  UserModal::where('email',session('email'))->where('is_active','1')->first();

            if(!$user)   return  [];

            $userOrderList = explode(',',$user->orderId);

            if(!in_array($orderId,$userOrderList))   return [];

            $orderDetails  =  OrderModal::where('id',$orderId)->where('is_active','1')->first();

            if(!$orderDetails) return  [];

            $product  =  ProductModal::where('id',$orderDetails->productId)->where('is_active','1')->first();
            if(!$product) return [];

            $commentsRawData  = CommentModal::whereIn('id',explode(',',$orderDetails->commentId))->where('is_active','1')->get();
            $comments =  [];

            if($commentsRawData->count()  > 0 ){
                foreach($commentsRawData as $value){
                    $comments[]  =   [
                        'comment' => $value->comment,
                        'dateOfComment' => $value->created_at,
                        'name' => $user->name,
                        'picture' => $user->picture,
                    ];
                }
            }

            $requiredData =  [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'images' => explode(',',$product->images),
                'price' => $product->price,
                'discount' => $product->discount,
                'number_of_customer_rate' => $product->number_of_customer_rate,
                'rating' => $product->rating,
                'orderDetails' => [
                    'orderId'  =>  $orderDetails->id,
                    'purchase_amount'  =>  $orderDetails->amount,
                    'rating'  =>  $orderDetails->rating_by_user,
                    'status'  =>  $orderDetails->status,
                    'order_date'  =>  $orderDetails->created_at,
                    'update_date'  =>  $orderDetails->updated_at,
                    'comments' => $comments
                ]
            ];

            return $requiredData;

        }

        return [];
    }
}

if(!function_exists('get_seller_products_all_orders')){
    function get_seller_products_all_orders(){
        
        if(session()->has('userType')  && session()->has('email')){
            if(session('userType') !==  'seller')   return  [];

            $seller  =  SellerModal::where('email',session('email'))->where('is_active','1')->first();

            if(!$seller)  return   [];

            $products  = ProductModal::where('is_active','1')->whereIn('id',explode(',',$seller->productId))->get();

            if($products->count() > 0){
                $requiredData  = [];

                foreach($products  as  $product){

                    $orders = OrderModal::where('productId',$product->id)->where('is_active','1')->get();

                    if($orders->count()  >  0){
                        foreach($orders as  $order){
                            $requiredData[]  =  [
                                'orderId' => (string) $order->id,
                                'id' => (string) $product->id,
                                'name' => $product->name,
                                'description' => $product->description,
                                'price' => $order->amount,
                                'images' => explode(",",$product->images),
                            ];
                        }
                    }
                }
                return  $requiredData;
            }
        }
        return  [];
    }
}

if(!function_exists('get_order_details_seller')){
    function  get_order_details_seller($productName,$productId,$orderId){

        if(session()->has('userType') && session()->has('email')  && session('userType') ==  'seller'){
            
            $product = ProductModal::where('name','like','%'.urldecode($productName).'%')->where('id',$productId)->where('is_active','1')->first();

            $seller  = SellerModal::where('email',session('email'))->where('is_active','1')->first();

            $sellerProducts =  explode(',',$seller->productId);

            if(!in_array($productId,$sellerProducts)) return  [];

            $order = OrderModal::where('id',$orderId)->where('sellerId',$seller->id)->where('productId',$product->id)->where("is_active",'1')->first();

            if(!$order)  return  [];

            $user  = UserModal::where('id',$order->customerId)->where('is_active','1')->first();

            if(!$user) return  [];

            $comment = CommentModal::where('orderId',$order->id)->where('productId',$product->id)->where('customerId' ,  $user->id)->where('sellerId',$seller->id)->first();

            $category =  CategoryModal::where('id',$product->categoryId)->where('is_active','1')->first();
            $subCategory =  SubCategoryModal::where('id',$product->subCategoryId)->where('is_active','1')->first();

            $requiredData  =  [
                'orderId'  =>  $order->id,
                'name'  =>  $product->name,
                'description'  =>  $product->description,
                'images'  =>  explode(',',$product->images),
                'current_price'  =>  $product->price,
                'current_discount'  =>  $product->discount,
                'platformFee'  =>  $product->platformFee,
                'deliveryAddress' => $user->address,
                'comment' => $comment->comment  ? [
                    'comment' => $comment->comment,
                    'name' => $user->name,
                    'picture' => $user->picture,
                    'dateOfComment' => $comment->created_at,
                ] : [],
                'order_amount' => $order->amount,
                'rating' => $order->rating_by_user,
                'quantity' => $order->quantity,
                'status' => $order->status,
                'orderDate' => $order->created_at,
                'updateDate' => $order->updated_at,
            ];

            return  $requiredData;

        }

        return  [];
    }
}