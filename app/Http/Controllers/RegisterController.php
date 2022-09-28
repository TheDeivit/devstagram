<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        //dd('Post..');

        //dd($request->get('name'));
        //dd($request->get('username'));
        //dd($request->get('email'));


        // Validacion

        $this->validate($request, [
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:30',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:8'
        ]);


        User::create([
            'name' => $request->name,
            'username' => Str::slug($request->username),
            'email' => $request->email,
            'password' => Hash::make($request->password) 
        ]);

        // Autenticar usuario

        /*auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);*/

        //Otra forma de autenticar
        auth()->attempt($request->only('email', 'password'));


        //Redirección
        
        return redirect()->route('posts.index');
    }
}
