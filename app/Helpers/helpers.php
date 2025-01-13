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
            'edit-product' => ['categories','product_details'],
            'profile' => ['userDetail'],
            'orders' => ['user_orders'],
            'cart' => ['user_cart'],
            'whislist' => ['user_whislist'],
            'edit-profile' => ['userDetail'],
            'all-products' => ['seller_product_list'],
            'live-products' => ['seller_live_product_list'],
            'product-details' => ['product_details'],
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
            'main_page_product_details' => 'get_main_page_product_detail',
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
                $subcategory =  SubCategoryModal::find($value->subCategoryId)->name ?? $value->subCategoryId;

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
                $seller = SellerModal::find($product->sellerId);

                $brandDetails =  [
                    'brandName' => $seller->brandName,
                    'brandLogo' => $seller->brandLogo,
                ];

                $category =  CategoryModal::find($product->categoryId)->name ?? $product->categoryId;
                $subcategory =  SubCategoryModal::find($product->subCategoryId)->name ?? $product->subCategoryId;

                $commentsRawData = CommentModal::whereIn('id',explode(',',$product->commentId))->get();
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


                

                $requiredData  =  [
                    'id'  =>  $product->id,
                    'name'  =>  $product->name,
                    'description'  =>  $product->description,
                    'category'  =>  $category,
                    'subcategory'  =>  $subcategory,
                    'brandDetails'  =>  $brandDetails,
                    'images'  =>  explode(',',$product->images),
                    'price'  =>  $product->price,
                    'discount'  =>  $product->discount,
                    'platformFee'  =>  $product->platformFee,
                    'views'  =>  $product->views,
                    'number_of_customer_rate'  =>  $product->number_of_customer_rate,
                    'rating'  =>  $product->rating,
                    'comments'  =>  $comments,
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
            $requiredData = [];
            
            foreach($rawProductsData as  $value){
                $seller = SellerModal::find($value->sellerId);

                $brandDetails =  [
                    'brandName' => $seller->brandName,
                    'brandLogo' => $seller->brandLogo,
                ];

                $category =  CategoryModal::find($value->categoryId)->name ?? $value->categoryId;
                $subcategory =  SubCategoryModal::find($value->subCategoryId)->name ?? $value->subCategoryId;

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
            $requiredData = [];
            
            foreach($rawProductsData as  $value){
                $seller = SellerModal::find($value->sellerId);

                $brandDetails =  [
                    'brandName' => $seller->brandName,
                    'brandLogo' => $seller->brandLogo,
                ];
                $subcategory =  SubCategoryModal::find($value->subCategoryId)->name ?? $value->subCategoryId;

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
                    'category'  =>  $category->name  ?? $category->id,
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

            return  $requiredData;
        }

        return [];
    }
}

if(!function_exists("get_newly_products")){
    function  get_newly_products($limit =  null){
        
        $productsRawData  = ($limit && is_integer($limit)) ? ProductModal::where('is_active','1')->orderBy('id','DESC')->limit($limit)->get() :  ProductModal::where('is_active','1')->orderBy('id','DESC')->get();

        if($productsRawData->count() > 0){
            $requiredData  = [];

            foreach($productsRawData as  $value){
                $seller = SellerModal::find($value->sellerId);

                $brandDetails =  [
                    'brandName' => $seller->brandName,
                    'brandLogo' => $seller->brandLogo,
                ];

                $category =  CategoryModal::find($value->categoryId)->name ?? $value->categoryId;
                $subcategory =  SubCategoryModal::find($value->subCategoryId)->name ?? $value->subCategoryId;

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
                'cartId' => $user->cartId,
                'whislistId' => $user->whislistId,
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

if(!function_exists('getFilteredProductsData')){
    function getFilteredProductsData($queryArray) {
        $query = ProductModal::query();
    
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
    
        $responseData  = $query->get();

        if($responseData->count()   >  0){

            $requiredData  =  [];
            
            foreach($responseData as $value){

                $seller = SellerModal::find($value->sellerId);

                $brandDetails =  [
                    'brandName' => $seller->brandName,
                    'brandLogo' => $seller->brandLogo,
                ];

                $category =  CategoryModal::find($value->categoryId)->name ?? $value->categoryId;
                $subcategory =  SubCategoryModal::find($value->subCategoryId)->name ?? $value->subCategoryId;

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

            $orders = OrderModal::where('customerId',$user->id)->where('is_active','1')->get();

            if($orders->count() > 0){
                $requiredData = [];

                foreach($orders as $value){
                    $product = ProductModal::where('id',$value->productId)->where('is_active','1')->first();
                    if($product){

                        $sellerModal  =  SellerModal::where('id',$value->sellerId)->where('is_active','1')->first();

                        $commentData = CommentModal::where('id',$value->commentId)->where('is_active','1')->first();
                        $category = CategoryModal::where('id',$product->categoryId)->where("is_active",'1')->first();
                        $subCategory = SubCategoryModal::where('id',$product->subCategoryId)->where("is_active",'1')->first();

                        $requiredData[] = [
                            'productData'  => [
                                'id' =>  $product->id,
                                'name' =>  $product->name,
                                'description' =>  $product->description,
                                'category' =>  $category->name,
                                'subcategory' =>  $subCategory->name,
                                'images' =>  implode(',',$product->images),
                                'current_price' =>  $product->price,
                                'current_discount' =>  $product->discount,
                                'platformFee' =>  $product->platformFee,
                                'rating' =>  $product->rating,
                            ],
                            'commentData' =>  [
                                'comment' => $commentData->comment,
                                'date_of_comment' => $commentData->created_at,
                            ],
                            'orderId'  =>  $value->id,
                            'purchase_amount'  =>  $value->amount,
                            'rating'  =>  $value->rating_by_user,
                            'quantity'  =>  $value->quantity,
                            'status'  =>  $value->status,
                            'order_date'  =>  $value->created_at,
                            'update_date'  =>  $value->updated_at,
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
                    
                    $sellerModal  =  SellerModal::where('id',$value->sellerId)->where('is_active','1')->first();

                    $category = CategoryModal::where('id',$value->categoryId)->where("is_active",'1')->first();
                    $subCategory = SubCategoryModal::where('id',$value->subCategoryId)->where("is_active",'1')->first();

                    $requiredData[] = [
                        'id' =>  $value->id,
                        'name' =>  $value->name,
                        'description' =>  $value->description,
                        'category' =>  $category->name,
                        'subcategory' =>  $subCategory->name,
                        'images' =>  implode(',',$value->images),
                        'current_price' =>  $value->price,
                        'current_discount' =>  $value->discount,
                        'platformFee' =>  $value->platformFee,
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
                    
                    $sellerModal  =  SellerModal::where('id',$value->sellerId)->where('is_active','1')->first();

                    $category = CategoryModal::where('id',$value->categoryId)->where("is_active",'1')->first();
                    $subCategory = SubCategoryModal::where('id',$value->subCategoryId)->where("is_active",'1')->first();

                    $requiredData[] = [
                        'id' =>  $value->id,
                        'name' =>  $value->name,
                        'description' =>  $value->description,
                        'category' =>  $category->name,
                        'subcategory' =>  $subCategory->name,
                        'images' =>  implode(',',$value->images),
                        'current_price' =>  $value->price,
                        'current_discount' =>  $value->discount,
                        'platformFee' =>  $value->platformFee,
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