<?php

namespace App\Http\Controllers;

use App\Models\User;

class HomeController extends Controller
{
    public function index(){
        if(Auth()->user() == NULL){
            return redirect('login');
        }else{
            $user = User::find(auth()->user()->id);
            if($user->hasRole('LOGISTICA')){
                return redirect()->route('logistic.requirements');
            }elseif($user->hasRole('ALMACEN')){
                return redirect()->route('storekeeper.warehouse');
            }elseif($user->hasRole('SOLICITANTE')){
                return redirect()->route('requester.requirements');
            }elseif($user->hasRole('TESORERO')){
                return redirect()->route('treasurer.purchase-orders');
            }else{
                return view('dashboard');
            }
        }
    }
}
