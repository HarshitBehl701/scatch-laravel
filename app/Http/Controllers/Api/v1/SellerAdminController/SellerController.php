<?php

namespace App\Http\Controllers\Api\v1\SellerAdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Api\v1\SellerModal\SellerModal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class SellerController extends Controller
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
            'brandName' => 'required|string|max:255|unique:sellers,brandName',
            'email' => 'required|email|max:255|unique:sellers,email',
            'password' => 'required|string|min:8|max:16|confirmed',
        ]);
    
        $name = $request->name;
        $brandName = $request->brandName;
        $email = $request->email;
        $password =  Hash::make($request->password);

        DB::beginTransaction();
        try{
            $user = SellerModal::create([
                'name' => $name,
                'brandName' => $brandName,
                'email' => $email,
                'password' => $password
            ]);
            DB::commit();
            return redirect('/seller-login')->with('success','You  are  now  registered successfully. Now you  can login  to your  account');
        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    public  function  login(Request $request){
        $validation = $request->validate([
            'email' => 'required|email|max:255|exists:sellers,email',
            'password' => 'required|string|min:8|max:16',
        ]);
    
        $email = $request->email;
        $password =  $request->password;

        try{
            $user = SellerModal::where('email',$email)->where('is_active','1')->first();
        
            if($user){
                $userPassword = $user->password;            
                if(Hash::check($password, $userPassword)){
                    Session::put('email',$user->email);
                    Session::put('userType','seller');
                    return redirect('/seller/profile')->with('success','Login  Successfully');
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

        if($request->filled('gstin')){
            $validation = $request->validate([
                'gstin' => 'required|string|size:15',
            ]);                                    
        }

        $seller  = SellerModal::where('email',session('email'))->where('is_active','1')->first();

        if($seller){

            if($seller->brandName !==  $request->brandName){
                $validation   =  $request->validate([
                    'brandName' => 'required|string|max:255|unique:sellers,brandName',
                ]);
            }
            try{
                
                $seller->update($request->only(['name', 'contact', 'address', 'gstin', 'brandName']));

                return back()->with('success','Successfully Updated your  Profile');

            }catch(\Exception  $e){
                return  back()->with('error',$e->getMessage());
            }

        }else{
            return  back()->with('error','Something Went  Wrong');
        }

    }

    public function uploadProfileImage(Request $request){
        $validation = $request->validate([
            'file' => 'file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $seller   = SellerModal::where('email',session('email'))->where('is_active','1')->first();

        $previousImagePath = storage_path('app/public/' . $seller->brandLogo);

        if($seller->brandLogo && $previousImagePath){
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }

        try{
            $filePath   =  $request->file('file')->store('profilePic','public');

            $seller->brandLogo  =  $filePath;
            $seller->save();
    
            return  back()->with('success','Successfully Updated Brand  Logo');
        }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
        }

    }
}
