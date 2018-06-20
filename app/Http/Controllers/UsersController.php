<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => ['show', 'create', 'store']
        ]);

        $this->middleware('guest',[
            'only'=>['create']
        ]);
    }

    public function index(User $users){
        return view('users',compact('users'));
    }

    public function create(){
        return view('users.create');
    }

    public function show(User $user){

        return view('users.show',compact('user'));
    }

    public function edit(User $user){

        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
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

        Auth::login($users);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show',$users->id);
    }

    public function update(Request $request,User $user){

        $this->validate($request,[
            'name' =>'required|unique:users',
            'password'=>'nullable|confirmed|min:6'
        ]);
        $data = [
            'name' =>$request->name,
            'password'=>bcrypt($request->password),
        ];

        $user->update($data);
        session()->flash('success','修改成功！');
        return redirect()->route('users.show',$user->id);
    }

    public function destroy(){

    }

}
