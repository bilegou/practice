<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function create(){
        return view('users.create');
    }

    public function show(User $user){

        return view('users.show',compact('user'));
    }

    public function store(Request $request,User $user){

        $this->validate($request,[
            'name' =>'required|unique:users',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed|min:6'
        ]);

        $data = [
            'name' =>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ];

        $users = $user->create($data);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show',$users->id);

    }
}
