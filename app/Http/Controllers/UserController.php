<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //

    public function login(Request $req)
    {
        $user= User::where(['email'=>$req->email])->first();
        if(!$user ||  !Hash::check($req->password,$user->password))
        {
            return "username or password is not correct";
        }
        else
        {
            $req->session()->put('user',$user);
            return redirect('/');
        }
    }

    public function register(Request $req)
    {
     
    //    $user = new User;
    //    $user->name = $req->name
        $validatedData = $req->validate([
        'name' => 'required',
        'password' => 'required|min:5',
        'email' => 'required|email|unique:users'
        ], [
        'name.required' => 'Name is required',
        'password.required' => 'Password is required'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        return redirect('/login');
    }
}
