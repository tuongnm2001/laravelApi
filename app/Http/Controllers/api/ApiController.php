<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 3); // Số lượng phần tử trên một trang, ví dụ 2
        $page = $request->input('page', 1); // Trang hiện tại, mặc định là 1

        $users = User::paginate($perPage, ['*'], 'page', $page);

        return $users;

    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if(!$user || !Hash::check($credentials['password'], $user->password)) {
            return response([
                'message'=>'Invalid Credentials',
                'errorCode'=> 401
            ]);
        } else {
            $token = $user->createToken('access_token')->plainTextToken;
            $response = [
                'user'=>$user ,
                 'token'=>$token
            ];
            return response([
                'data'=>$response,
                'errorCode'=>200
            ]);
        }
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

    // public function user(Request $request)
    // {
    //     return response()->json($request->user());
    // }
}
