<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest',[
           'only'=>'create'
        ]);
    }

    public function create(){
        return view('sessions.create');
   }

    public function store(Request $request){

       $credentials = $this->validate($request,[
           'email' => 'required|email|max:255',
           'password' => 'required'
        ]);

        if(Auth::attempt($credentials,$request->has('remember'))){
            session()->flash('success','holer欢迎回来！');
            return redirect()->route('users.show',Auth::user()->id);

        }else{
            session()->flash('danger','对不起，账号或密码错误。');
            return redirect()->back();
        }
    }

    public function destroy(){
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect()->route('login');
    }
}
