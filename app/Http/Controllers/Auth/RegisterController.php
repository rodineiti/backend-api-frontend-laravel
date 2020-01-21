<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Notifications\RegisterNotification;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'token' => $data['token']
        ]);
    }

    protected function register(Request $request)
    {
        $input = $request->all();

        $validator = $this->validator($input);

        if ($validator->passes()) {

            $token = str_random(50);
            $input["token"] = $token;
            
            $user = $this->create($input);

            $url = route('confirmation', $token);

            $user->notify(new RegisterNotification($user, $token, $url));

            return redirect()->route('login')->with('status', 'Um e-mail de confirmação foi enviado, favor acesse seu e-mail para validar seu cadastro.');
        }

        return redirect()->route('register')->with('errors', $validator->errors());
    }

    public function confirmation($token)
    {
        $user = User::where('token', $token)->first();

        if (!is_null($user)) {
            $user->status = 1;
            $user->token = '';
            $user->save();
            return redirect()->route('login')->with('status', 'Seu cadastro foi confirmado com sucesso, agora você já pode acessar o sistema com seu e-mail e senha.');
        }

        return redirect()->route('login')->with('status', 'Opss. Link para validação de cadastro inexistente, favor tente novamente.');
    }
}
