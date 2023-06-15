<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        if(Auth()->user() == NULL){
            return redirect('login');
        }else{
            $user = User::find(auth()->user()->id);
            if($user->hasRole('logistica')){
                return redirect()->route('logistic.products');
            }elseif($user->hasRole('almacenero')){
                return redirect()->route('storekeeper.warehouse');
            }else{
                return view('dashboard');
            }
        }
    }
}
