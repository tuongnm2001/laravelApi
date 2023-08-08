<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:191',
            'email'=>'required|email|max:191|unique:users,email',
            'password'=>'required',
        ]);

        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
        ]);

        $token = $user->createToken('token')->plainTextToken;
        $user->update([
            'remember_token' => $token
        ]);

        return $response =[
            'user'=>$user,
            'token'=>$token,
            'errorCode'=>200,
        ];
    }
}
