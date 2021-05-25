<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController as BaseController;
use Exception;


class LoginController extends BaseController
{
	public function create(Request $request)
    {
    	return 'Login Form';
    }

    public function login(Request $request)
    {
    	try
    	{
	    	$request->validate([
		        'email'    => 'required|email',
		        'password' => 'required'
	    	]);

	    	$user = User::where('email', $request->email)->first();

	    	if (! $user || ! Hash::check($request->password, $user->password)) {
	        	throw new Exception('The provided credentials are incorrect.');
	    	}
	    	$token = $user->createToken('my-app-token')->plainTextToken;
	    	$response = [
	    		'user'         => $user,
	    		'access_token' => $token
	    	];

	    	return $this->sendResponse($response,'login Success');
    	}
    	catch(Exception $e){
    		return $this->sendError($e->getMessage());
    	}
    }

    public function logout(Request $request)
    {
    	return ' logout';
    }
}
