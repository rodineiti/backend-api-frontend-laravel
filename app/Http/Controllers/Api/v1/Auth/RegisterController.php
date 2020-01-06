<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\User;

class RegisterController extends Controller
{
	public function register(Request $request)
	{
		$rules = [
        	'name' => 'required',
    		'email' => 'required|email|unique:users,email',
    		'password' => 'required|string|min:6|confirmed',
    	];

    	$validator = \Validator::make($request->all(), $rules);

	    if ($validator->fails()) {
	       return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
	    }

		$data = $request->all();
		
		$user = new User;
		$user->name = $data['name'];
		$user->email = $data['email'];
		$user->password = bcrypt($data['password']);
    $user->image = '/profiles/default.png';
		$user->save();

		return response()->json(['status' => 'success', 'message' => 'Conta criada com sucesso, faça o login.']);
	}
}