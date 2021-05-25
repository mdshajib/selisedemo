<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
	public function create(Request $request)
    {
    	return 'Login Form';
    }

    public function login(Request $request)
    {
    	$request->validate([
	        'email' => 'required|email',
	        'password' => 'required'
    	]);

    	$user = User::where('email', $request->email)->first();

    	if (! $user || ! Hash::check($request->password, $user->password)) {
        	throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        	]);
    	}
    	$token = $user->createToken('my-app-token')->plainTextToken;
    	$response = [
    		'user' => $user,
    		'access_token' => $token
    	];

    	return response($response,200);
    }

    public function logout(Request $request)
    {
    	return ' logout';
    }
}
