<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;

class LoginController extends Controller
{
	public function logout()
	{
		if (\Auth::check()) {
			\Auth::user()->oauthAccessToken()->delete();
		}

		return response()->json(['status' => 'success', 'message' => 'Logout realizado com sucesso']);
	}
}