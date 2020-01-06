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
    
    //$user->image = asset($user->image);

		return response()->json(['status' => 'success', 'data' => $user]);
	}
  
  public function profileUpdate(Request $request)
	{
		$user = User::where('id', $request->user()->id)->first();

		if (!$user) {
			return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
		}
    
    $rules = [
        'name' => 'required',
    		'email' => 'required|email|unique:users,email,' . $request->user()->id,
    		'password' => 'required|string|min:6|confirmed',
    ];

		$validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
       return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
    }
    
    /*
		if (!Hash::check($request->input('password_current'), $user->password)) { 
			return response()->json(['status' => 'error', 'message' => 'Opss. A senha atual informada está incorreta, favor verificar.']);	
		}
    */

		$data = [
			'name' => $request->input('name'),
      'email' => $request->input('email'),
      'password' => bcrypt($request->input('password')),
		];
    
    if ($request->image) {
      $time = time();
      $directoryPai = 'profiles';
      $directoryImage = $directoryPai . DIRECTORY_SEPARATOR . 'profile_id_' . $user->id;
      $ext = substr($request->image, 11, strpos($request->image, ';') - 11);
      $urlImage = $directoryImage . DIRECTORY_SEPARATOR . $time . '.' . $ext;
      $file = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
      $file = base64_decode($file);
      
      if (!file_exists($directoryPai)) {
        mkdir($directoryPai, 0777);
      }
      if ($user->image) {
        $imgUser = str_replace(asset('/'), '', $user->image);
        if (file_exists($imgUser)) {
          unlink($imgUser);
        }
      }
      if (!file_exists($directoryImage)) {
        mkdir($directoryImage, 0777);
      }
      
      file_put_contents($urlImage, $file);
      $data['image'] = $urlImage;
    }
    
		$user->update($data);
    //$user->image = asset($user->image);

		return response()->json(['status' => 'success', 'data' => $user]);
	}
}