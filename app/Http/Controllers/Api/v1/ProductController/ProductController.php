<?php

namespace App\Http\Controllers\Api\v1\ProductController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use  App\Models\Api\v1\SellerModal\SellerModal;
use  App\Models\Api\v1\ProductModal\ProductModal;
use App\Models\Api\v1\CategoryModal\CategoryModal;
use App\Models\Api\v1\SubCategoryModal\SubCategoryModal;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function  createProduct(Request $request){
        $validation  = $request->validate([
            'name'   =>   'required|string|min:1|max:255',
            'category'   =>   'required|string|exists:categories,name',
            'subcategory'   =>   'required|string|exists:sub_categories,name',
            'price'   =>   'required|integer|min:100',
            'discount'   =>   'required|integer',
            'description'   =>   'required|string',
            'product_images' => 'required|array',
            'product_images.*' => 'file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $sellerEmail  =  Session::get('email');
        $userType  =  Session::get('userType');


        if($userType ==   'seller'  && $sellerEmail){

            $seller  = SellerModal::where('email',$sellerEmail)->where('is_active','1')->first();

            if($seller){
                            
                $storedFilesName = $this->uploadImages($request->file('product_images'));

                if(count($storedFilesName) > 0){
                    $category   =   CategoryModal::where('name',$request->category)->where('is_active','1')->first();
                    $subCategory   =   SubCategoryModal::where('category_id',$category->id)->where('name',$request->subcategory)->where('is_active','1')->first();
                    
                    if($category && $subCategory){
                        DB::beginTransaction();
                        try{   
                            $filesNameString = implode(',',$storedFilesName);
                            $product =   ProductModal::create([
                                'name'  => $request->name,  
                                'sellerId'  => $seller->id,  
                                'description'  => $request->description,  
                                'categoryId'  => $category->id,  
                                'subCategoryId'  => $subCategory->id,  
                                'images'  => $filesNameString,  
                                'price'  => $request->price,  
                                'discount'  => $request->discount,  
                            ]);
    
                            DB::commit();

                            $sellerProducts = $seller->productId ? explode(',', $seller->productId) : [];
                            $sellerProducts[] = $product->id;
                            $seller->productId = implode(',',$sellerProducts);
                            $seller->save();

                            return back()->with('success','Product Created  Successfully');
                        }catch(\Exception $e){
                            DB::rollback();
                            return  back()->with('error',$e->getMessage());
                        }   
    
                    }else{
                        return  back()->with('error','Something Went  Wrong');
                    }
                }else{
                    return  back()->with('error','Please  Upload  Atleast One Image');
                }
            }else{
                return  back()->with('error','Something Went  Wrong');
            }
        }else{
            return  back()->with('error','Something Went  Wrong');
        }
    }

    public  function updateProductStatus($productId){

        $currentUser  = session('userType');
    
        if($currentUser  == 'seller'){
            $seller = SellerModal::where('email',session('email'))->where('is_active','1')->first();

            if(!$seller){
                return back()->with('error','Something  Went  Wrong');        
            }else{

                $product  =   ProductModal::where('id',$productId)->where('sellerId',$seller->id)->first();

                if(!$product){
                    return back()->with('error','Something  Went  Wrong');            
                }else{
                    $currentStatus  = $product->is_active;

                    $product->is_active  = ($currentStatus  == '1') ? '0' : '1';
                    $product->save();
                    return back()->with('success','Successfully  Changed The Product  Status');
                }

            }
        }

        return back()->with('error','Something  Went  Wrong');
    }

    public function  updateProduct(Request  $request,$productId){
        $validate  = $request->validate([
            'oldImagesSrc'  => 'required|string',
            'name'  =>  'required|string|min:1|max:255',
            'category'  => 'required|string|exists:categories,name',
            'subcategory'  => 'required|string|exists:sub_categories,name',
            'price'  => 'required|integer|min:100',
            'discount'  => 'required|integer',
            'description'  => 'required|string',
            'product_images' => 'nullable|array',
            'product_images.*' => 'file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = ProductModal::find($productId);

        if($product){
            try{   
                $oldImageSrcArr  = explode(',',$request->oldImagesSrc);
                if($request->file('product_images')){
                    //removinng old images and adding new images
                    foreach($request->file('product_images') as  $key => $value){
                        if(array_key_exists($key,$oldImageSrcArr)){
                            $newImageUploadPath  =  $this->uploadImage($value);
                            $previousImagePath = storage_path('app/public/' . $oldImageSrcArr[$key]);
                            if($previousImagePath){
                                if (file_exists($previousImagePath)) {
                                    unlink($previousImagePath);
                                }
                            }
                            $oldImageSrcArr[$key] =  $newImageUploadPath;   
                        }
                    }
                }
                $newImageSrc = implode(',',$oldImageSrcArr);

                $category =  CategoryModal::where('name',$request->cateogry)->first()->name  ??  $request->category;
                $subCategory =  SubCategoryModal::where('name',$request->subcategory)->first()->name  ??  $request->subcategory;

                $product->update($request->only(['name','price','discount','description']));
                
                $product->categoryId = $category;
                $product->subCategoryId =  $subCategory;
                $product->images =  $newImageSrc;
                $product->save();
                
                return back()->with('success','Successfully  updated the  product data');

            }catch(\Exception $e){
                return  back()->with('error',$e->getMessage());
            }
        }
        return back()->with('error','Something Went  Wrong');
    }

    private function uploadImages($images){
        
        $storedFilePaths = [];
        // Loop through each file and store it
        foreach ($images as $image) {
            $filePath = $image->store('uploads', 'public');
            $storedFilePaths[] = $filePath;
        }
        return $storedFilePaths;
    }

    private function uploadImage($image){
        $filePath = $image->store('uploads', 'public');
        return $filePath;
    }


}