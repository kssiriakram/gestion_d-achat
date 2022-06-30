<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(){
           return view("login");
    }

    public function registration(){
        return view("registration");
    }

    public function register(Request $request){
         $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:12'
         ]);

         $user = new User();
         $user->type=$request->type;
         $user->name=$request->name;
         $user->email=$request->email;
         $user->password=Hash::make($request->password);
         $res = $user->save();

         if($res){
            return back()->with('success','You have register successfully');
         }else{
            return back()->with('fail','Something wrong during registring');
         }


    }

    public function signin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:12'
         ]);
         $user = DB::table('users')->where("email", $request->email)->first();

         if($user){
            if(Hash::check($request->password,$user->password)){
                $request->session()->put('loginId',$user->id);
                $request->session()->put('type',$user->type);
                return redirect('/da');
            }else{
                return back()->with('fail','passwords does not match');
            }

         }else{
            return back()->with('fail','acount does not exist');
         }


    }
}
