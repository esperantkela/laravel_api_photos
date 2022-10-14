<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthentificationController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150|min:3',
            'email' => 'required|email|string|max:250|unique:users',
            'password' => 'required|confirmed|min:6'
        ], [
            'name.required' => 'Vous devez spécifier votre nom',
            'email.required' => 'Vous devez spécifier votre email',
            'email.unique' => 'cet email est déjà utilisé',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors(),
            ],401);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'api_token' => Str::random(70)
        ]);

        return response()->json($user);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string|max:250',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors(),
            ], 401);
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = User::where('email', $request->email)->firstOrFail();

            return response()->json( $user);
        }else{
            return response()->json([
                'error' => 'Mauvais identifiant de connexon'
            ], 401);
        }
    }
}
