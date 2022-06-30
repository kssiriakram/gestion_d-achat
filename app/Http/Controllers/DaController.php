<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DaController extends Controller
{
    function da(Request $request){
        if($request->session()->get_browser()){
        $user = DB::statement("select name from users where type='acheteur'");
        return view('/da',['acheteurs'=>$user]);
        }
    }
    
}
