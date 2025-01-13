<?php

namespace App\Http\Controllers\Api\v1\UserAdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Api\v1\UserModal\UserModal;
use  App\Models\Api\v1\ProductModal\ProductModal;
use  App\Models\Api\v1\OrderModal\OrderModal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public  function  pageRouter($page  = '/',$param1  =  null  , $param2  =  null){
        require_once app_path('Helpers/helpers.php');
        $pagePath = $this->adminPagePath;
        $pageData  =  get_page_data($page,$param1,$param2);
        
        return  (array_key_exists($page,$pagePath)) ?  view($pagePath[$page],['pageData' => $pageData]) : view($pagePath['/'],['pageData' => $pageData]);
    }


    public function register(Request $request){
        //form   Validation
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:16|confirmed',
        ]);
    
        $name = $request->name;
        $email = $request->email;
        $password =  Hash::make($request->password);

        DB::beginTransaction();
        try{
            $user = UserModal::create([
                'name' => $name,
                'email' => $email,
                'password' => $password
            ]);
            DB::commit();
            return redirect('/login')->with('success','You  are  now  registered successfully. Now you  can login  to your  account');
        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public  function  login(Request $request){
        $validation = $request->validate([
            'email' => 'required|email|max:255|exists:users,email',
            'password' => 'required|string|min:8|max:16',
        ]);
    
        $email = $request->email;
        $password =  $request->password;

        try{
            $user = UserModal::where('email',$email)->where('is_active','1')->first();
        
            if($user){
                $userPassword = $user->password;            

                if(Hash::check($password, $userPassword)){
                    Session::put('email',$user->email);
                    Session::put('userType','user');
                    return redirect('/user/profile')->with('success','Login  Successfully');
                }else{
                    return back()->with('error',"Incorrect  Password");
                }

            }else{
                return back()->with('error','User  Not Found Or Account Not Activated Yet');
            }


        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function uploadProfileImage(Request $request){
        $validation = $request->validate([
            'file' => 'file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user   = UserModal::where('email',session('email'))->where('is_active','1')->first();

        $previousImagePath = storage_path('app/public/' . $user->picture);

        if($user->picture && $previousImagePath){
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }

        try{
            $filePath   =  $request->file('file')->store('profilePic','public');

            $user->picture  =  $filePath;
            $user->save();
    
            return  back()->with('success','Successfully Updated Brand  Logo');
        }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
        }

    }

    public function updateProfile(Request  $request){
        $validation = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        if($request->filled('contact')){
            $validation = $request->validate([
                'contact' => 'required|digits:10|regex:/^[0-9]{10}$/',
            ]);            
        }

        if($request->filled('address')){
            $validation   =  $request->validate([
                'address' => 'required|string|min:10',
            ]);
        }


        $user  = UserModal::where('email',session('email'))->where('is_active','1')->first();

        if($user){
            try{
                $user->update($request->only(['name', 'contact', 'address']));

                return back()->with('success','Successfully Updated your Profile');

            }catch(\Exception  $e){
                return  back()->with('error',$e->getMessage());
            }

        }else{
            return  back()->with('error','Something Went  Wrong');
        }

    }

    public function manageUserWhislist($action,$productname,$productId){
        $product  = ProductModal::where('id',$productId)->where('name','like','%'.$productname.'%')->where('is_active','1')->first();

        if(!$product)  return back()->with('error','Invalid Product');
        else{
            $user  = UserModal::where('email',Session::get("email"))->first();
            if(!$user)  return back()->with('error','Some  Error  Occured');
            else{
                $previousWhislist  = ($user->whislistId) ? explode(',',$user->whislistId) :  [];

                if($action == 'add'){
                    
                    if(in_array($productId,$previousWhislist)) return  back()->with('error','Product is  already in   your whislist');

                    array_push($previousWhislist,$productId);

                    $user->whislistId =  implode(',',$previousWhislist);
                    $user->save();
                    return  back()->with('success','Successfully Added the Product In  Your  Whislist');
                }elseif($action   == 'remove'){
    
                    if(!in_array($productId,$previousWhislist)) return  back()->with('error','Product is  not in  your whislist');
                    
                    $indexOfRequestedProduct  = array_search($productId,$previousWhislist);
                    unset($previousWhislist[$indexOfRequestedProduct]);
                    $user->whislistId =  implode(',',$previousWhislist);
                    $user->save();
                    return  back()->with('success','Successfully Removed the Product From  Your  Whislist');
                }
            }
        }
        return back()->with('error','Some  Error  Occured');
    }

    public function manageUserCart($action,$productname,$productId){
        $product  = ProductModal::where('id',$productId)->where('name',urldecode($productname))->where('is_active','1')->first();

        if(!$product)  return back()->with('error','Invalid Product');
        else{
            $user  = UserModal::where('email',Session::get("email"))->first();
            if(!$user)  return back()->with('error','Some  Error  Occured');
            else{
                $previousCart  = ($user->cartId)  ?  explode(',',$user->cartId) :  [];

                if($action == 'add'){

                    if(in_array($productId,$previousCart)) return  back()->with('error','Product is  already in   your cart');

                    array_push($previousCart,$productId);

                    $user->cartId =  implode(',',$previousCart);
                    $user->save();
                    return  back()->with('success','Successfully Added the Product In  Your  Cart');
                }elseif($action   == 'remove'){
    
                    if(!in_array($productId,$previousCart)) return  back()->with('error','Product is  not in  your cart');
                    
                    $indexOfRequestedProduct  = array_search($productId,$previousCart);
                    unset($previousCart[$indexOfRequestedProduct]);
                    $user->cartId =  implode(',',$previousCart);
                    $user->save();
                    return  back()->with('success','Successfully Removed the Product From  Your  Cart');
                }
            }
        }
        return back()->with('error','Some  Error  Occured');
    }

    public function manageUserOrders($action,$productname,$productId,$orderId  = null){
        $product  = ProductModal::where('id',$productId)->where('name','like','%'.$productname.'%')->where('is_active','1')->first();

        if(!$product)  return back()->with('error','Invalid Product');
        else{
            $user  = UserModal::where('email',Session::get("email"))->first();
            if(!$user)  return back()->with('error','Some  Error  Occured');
            else{

                if($action == 'add'){
                    $previousOrders =   ($user->orderId)  ? explode(',',$user->orderId)  :  [];
                    try{
                        $order  = OrderModal::create([
                            'productId' => $product->id,
                            'customerId' => $user->id,
                            'sellerId' => $product->sellerId,
                            'amount' => $product->price -  ($product->price * ($product['discount']/100)),
                        ]);
                    }catch(\Exception $e){
                        return  back()->with('error',$e->getMessage);
                    }

                    array_push($previousOrders,$order->id);

                    $user->orderId =  implode(',',$previousOrders);
                    $user->save();
                    return  back()->with('success','Successfully Place  The  Order');
                }elseif($action   == 'cancel'){
                    if(!in_array($orderId,$previousOrders)) return  back()->with('error','Product is  not in  your order  list');
                    $order = OrderModal::where('id',$orderId)->where("is_active",'1')->first();
                    if($order){
                        if($order->status  ==  'delivered') return  back()->with('error','Order is already delivered  cannot cancel it');
                        else if($order->status  ==  'cancel') return  back()->with('error','Order is already cancelled');
                        else{    
                            $order->status   =  'cancel';
                            $order->save();
                            return  back()->with('success','Successfully Cancelled The  Order');
                        }

                    }

                }
            }
        }
        return back()->with('error','Some  Error  Occured');
    }

}
