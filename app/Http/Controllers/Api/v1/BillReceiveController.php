<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class BillReceiveController extends Controller
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

		$bill_receives = $user->bill_receives()->with('category')->get();

		return response()->json(['status' => 'success', 'data' => $bill_receives]);
    }

    public function store(Request $request)
    {
        $rules = [
            'category_id' => 'required',
            'date_launch' => 'required|date',
            'name' => 'required|min:3|max:255',
            'value' => 'required|numeric',
            'status' => 'required'
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
           return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
        
        $user->bill_receives()->create($request->all());

        return response()->json(['status' => 'success', 'message' => 'Conta a receber criada com sucesso']);
    }

    public function show(Request $request, $id)
    {
        if (!$id) {
           return response()->json(['status' => 'error', 'message' => 'Conta a receber não informada']);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
        
        $bill_receive = $user->bill_receives()->find($id);

        if (!$bill_receive) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Conta a receber não encontrada pra este usuário.']);
        }

        return response()->json(['status' => 'success', 'data' => $bill_receive]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'category_id' => 'required',
            'date_launch' => 'required|date',
            'name' => 'required|min:3|max:255',
            'value' => 'required|numeric',
            'status' => 'required'
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
           return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
        
        if (!$id) {
           return response()->json(['status' => 'error', 'message' => 'Conta a receber não informada']);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
        
        $bill_receive = $user->bill_receives()->find($id);

        if (!$bill_receive) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Conta a receber não encontrada pra este usuário.']);
        }

        $bill_receive->update($request->all());

        return response()->json(['status' => 'success', 'message' => 'Conta a receber atualizada com sucesso.']);
    }

    public function toggle(Request $request, $id)
    {
        $rules = [
            'status' => 'required'
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
           return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
        
        if (!$id) {
           return response()->json(['status' => 'error', 'message' => 'Conta a receber não informada']);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
        
        $bill_receive = $user->bill_receives()->find($id);

        if (!$bill_receive) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Conta a receber não encontrada pra este usuário.']);
        }

        $bill_receive->update($request->all());

        return response()->json(['status' => 'success', 'message' => 'Conta a receber atualizada com sucesso.']);
    }

    public function destroy(Request $request, $id)
    {
        if (!$id) {
           return response()->json(['status' => 'error', 'message' => 'Conta a receber não informada']);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }
        
        $bill_receive = $user->bill_receives()->find($id);

        if (!$bill_receive) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Conta a receber não encontrada pra este usuário.']);
        }

        $bill_receive->delete();

        return response()->json(['status' => 'success', 'message' => 'Conta a receber deletada com sucesso.']);
    }
}