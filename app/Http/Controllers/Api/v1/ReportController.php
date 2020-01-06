<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\User;

class ReportController extends Controller
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

    public function getStatementByPeriod(Request $request)
    {
        $rules = [
            'dateStart' => 'required|date',
            'dateEnd' => 'required|date',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
           return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }

        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;

        $billPays = $user->bill_pays()->selectRaw('bill_pays.*, categories.name as category_name')
            ->leftJoin('categories', 'categories.id', '=', 'bill_pays.category_id')
            ->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->orderBy('date_launch', 'DESC')
            ->get();

        $billReceives = $user->bill_receives()->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->orderBy('date_launch', 'DESC')
            ->get();

        $collection = new Collection(array_merge_recursive($billPays->toArray(), $billReceives->toArray()));
        $statements = $collection->sortByDesc('date_launch');

        $total_pays = $billPays->sum('value');
        $total_receives = $billReceives->sum('value');

        $data['billPays'] = $billPays;
        $data['billReceives'] = $billReceives;
        $data['total_pays'] = $total_pays;
        $data['total_receives'] = $total_receives;

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function sumChartsByPeriod(Request $request)
    {
        $rules = [
            'dateStart' => 'required|date',
            'dateEnd' => 'required|date',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
           return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }

        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;

        $categories = $user->categories()->selectRaw('categories.name, sum(value) as value')
            ->leftJoin('bill_pays', 'bill_pays.category_id', '=', 'categories.id')
            ->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->whereNotNull('bill_pays.category_id')
            ->groupBy('categories.name')
            ->get();

        foreach ($categories as $key => $value) {
            $categories[$key]['name'] = $value->name;
            $categories[$key]['y'] = (float)$value->value;
        }

        return response()->json(['status' => 'success', 'data' => $categories]);
    }
  
    public function sumChartsByPeriodFull(Request $request)
    {
        $user = $this->model->where('id', $request->user()->id)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Opss. Usuário não foi encontrado, favor verifique se esta logado.']);
        }

        $dateStart = date('Y') . '-01-01';
        $dateEnd = date('Y-m-d');

        $categories = $user->categories()->selectRaw('categories.name, sum(value) as value')
            ->leftJoin('bill_pays', 'bill_pays.category_id', '=', 'categories.id')
            ->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->whereNotNull('bill_pays.category_id')
            ->groupBy('categories.name')
            ->get();

        foreach ($categories as $key => $value) {
            $categories[$key]['name'] = $value->name;
            $categories[$key]['y'] = (float)$value->value;
        }

        return response()->json(['status' => 'success', 'data' => $categories]);
    }
}