<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
	private $model;

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

	public function profile(Request $request)
	{
		$user = $this->model->where('id', $request->user()->id)->first();

		if (!$user) {
			return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
		}

		return response()->json(['status' => 'success', 'data' => $user]);
	}
}