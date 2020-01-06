<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class CategoryController extends Controller
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

    public function index(Request $request)
    {
        $user = $this->model->where('id', $request->user()->id)->first();

		if (!$user) {
			return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
		}

		$categories = $user->categories()->get();

		return response()->json(['status' => 'success', 'data' => $categories]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3|max:255'
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
           return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
        
        $user->categories()->create($request->all());

        return response()->json(['status' => 'success', 'message' => 'Categoria criada com sucesso']);
    }

    public function show(Request $request, $id)
    {
        if (!$id) {
           return response()->json(['status' => 'error', 'message' => 'Categoria não informada']);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
        
        $category = $user->categories()->find($id);

        if (!$category) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Categoria não encontrada pra este usuário.']);
        }

        return response()->json(['status' => 'success', 'data' => $category]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:3|max:255'
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
           return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
        
        if (!$id) {
           return response()->json(['status' => 'error', 'message' => 'Categoria não informada']);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
        
        $category = $user->categories()->find($id);

        if (!$category) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Categoria não encontrada pra este usuário.']);
        }

        $category->update($request->all());

        return response()->json(['status' => 'success', 'message' => 'Categoria atualizada com sucesso.']);
    }

    public function destroy(Request $request, $id)
    {
        if (!$id) {
           return response()->json(['status' => 'error', 'message' => 'Categoria não informada']);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
        
        $category = $user->categories()->find($id);

        if (!$category) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Categoria não encontrada pra este usuário.']);
        }

        $category->delete();

        return response()->json(['status' => 'success', 'message' => 'Categoria deletada com sucesso.'], 204);
    }
}