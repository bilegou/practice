<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
class SessionsController extends Controller
{

    public function __construct()
    {
//        $this->authorize('auth');
    }

    public function create(){
        return view('sessions.create');
   }

    public function store(Request $request,User $user){

        $this->validate($request,[
            'name' =>'required|unique:users',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed|min:6'
        ]);


    }

    public function destroy(){


    }
}
