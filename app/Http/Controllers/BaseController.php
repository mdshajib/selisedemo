<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    public function sendResponse($response,$message)
    {
    	return response()->json(array(
    		'status'         => true,
    		'status_message' => $message,
    		'data'           => $response
    	),200);
    }

    public function sendError($error)
    {
    	return response()->json(array(
    		'status'         => false,
    		'status_message' => $error,
    		'data'           => ''
    	));
    }
}
