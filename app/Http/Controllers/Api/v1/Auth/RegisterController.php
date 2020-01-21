<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Notifications\RegisterNotification;
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

		$token = str_random(50);
		
		$user = new User;
		$user->name = $data['name'];
		$user->email = $data['email'];
		$user->password = bcrypt($data['password']);
    	$user->image = '/profiles/default.png';
    	$user->token = $token;
		$user->save();

		$url = config('app.url_frontend_react') . "/confirmation/{$token}";

		$user->notify(new RegisterNotification($user, $token, $url));

		return response()->json(['status' => 'success', 'message' => 'Conta criada com sucesso, verifique seu e-mail para ativar seu cadastro.']);
	}

	public function confirmation($token)
    {
        $user = User::where('token', $token)->first();

        if (!is_null($user)) {
            $user->status = 1;
            $user->token = '';
            $user->save();

            return response()->json(['status' => 'success', 'message' => 'Seu cadastro foi confirmado com sucesso, agora você já pode acessar o sistema com seu e-mail e senha.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Opss. Link para validação de cadastro inexistente.']);
    }
}