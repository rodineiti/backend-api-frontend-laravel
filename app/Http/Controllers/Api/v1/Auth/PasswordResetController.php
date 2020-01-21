<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\User;
use App\PasswordResetApi;
use App\Http\Controllers\Controller;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
	/**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function forget(Request $request)
    {
    	$rules = [
        	'email' => 'required|string|email',
    	];

    	$validator = \Validator::make($request->all(), $rules);

	    if ($validator->fails()) {
	       return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
	    }

		$user = User::where('email', $request->email)->first();

        if (!$user) {
        	return response()->json(['status' => 'error', 'message' => 'Não encontramos nenhum usuário com esse endereço de e-mail.']);
        }

        $passwordReset = PasswordResetApi::updateOrCreate([
        	'email' => $user->email
        ],[
        	'email' => $user->email,
        	'token' => str_random(60)
        ]);

        if ($user && $passwordReset) {
        	$user->notify(new PasswordResetRequest($passwordReset->token));
        }

        return response()->json(['status' => 'success', 'message' => 'O link para redefinição de senha foi enviado para o seu e-mail!']);
    }

    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function showReset($token)
    {
    	$passwordReset = PasswordResetApi::where('token', $token)->first();

        if (!$passwordReset) {
        	return response()->json(['status' => 'error', 'message' => 'O token para recuperação de senha é inválido.']);
        }

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            
            $passwordReset->delete();

            return response()->json(['status' => 'error', 'message' => 'O token para recuperação de senha é inválido.']);
        }

        return response()->json(['status' => 'success', 'data' => $passwordReset]);
    }

    /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
    	$rules = [
        	'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
    	];

    	$validator = \Validator::make($request->all(), $rules);

	    if ($validator->fails()) {
	       return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
	    }

        $passwordReset = PasswordResetApi::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset) {
        	return response()->json(['status' => 'error', 'message' => 'O token para recuperação de senha é inválido.']);
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
        	return response()->json(['status' => 'error', 'message' => 'Não podemos encontrar um usuário com esse endereço de e-mail.']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        $passwordReset->delete();

        $user->notify(new PasswordResetSuccess($passwordReset));

        return response()->json(['status' => 'success', 'message' => 'Sua senha foi redefinida com sucesso. Agora você já pode realizar o login com a nova senha!']);
    }
}
