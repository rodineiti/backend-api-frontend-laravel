<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ReportController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function statement()
    {
    	$statements = [];
    	return view('report.statement', compact('statements'));
    }

    public function getStatementByPeriod(Request $request)
    {
    	$this->validate($request, [
            'dateStart' => 'required|date',
            'dateEnd' => 'required|date',
        ]);

        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;

        $billPays = auth()->user()->bill_pays()->selectRaw('bill_pays.*, categories.name as category_name')
            ->join('categories', 'categories.id', '=', 'bill_pays.category_id')
            ->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->get();

        $billReceives = auth()->user()->bill_receives()->selectRaw('bill_receives.*, categories.name as category_name')
            ->join('categories', 'categories.id', '=', 'bill_receives.category_id')
            ->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->get();

        $collection = new Collection(array_merge_recursive($billPays->toArray(), $billReceives->toArray()));
        $statements = $collection->sortByDesc('date_launch');

        $total_pays = $billPays->sum('value');
        $total_receives = $billReceives->sum('value');

        return view('report.statement', compact('billPays','billReceives','total_pays','total_receives','statements'));
    }

    public function charts()
    {
    	$categories = [];
    	return view('report.charts', compact('categories'));
    }

    public function sumChartsByPeriod(Request $request)
    {
        $this->validate($request, [
            'dateStart' => 'required|date',
            'dateEnd' => 'required|date',
        ]);

        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;

        $categoriesPay = auth()->user()->categories()->selectRaw('categories.name, sum(value) as value')
            ->join('bill_pays', 'bill_pays.category_id', '=', 'categories.id')
            ->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->whereNotNull('bill_pays.category_id')
            ->groupBy('categories.name')
            ->where('status', '1')
            ->get();

        $categoriesReceive = auth()->user()->categories()->selectRaw('categories.name, sum(value) as value')
            ->join('bill_receives', 'bill_receives.category_id', '=', 'categories.id')
            ->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->whereNotNull('bill_receives.category_id')
            ->groupBy('categories.name')
            ->where('status', '1')
            ->get();

        return view('report.charts', compact('categoriesPay','categoriesReceive'));
    }

}

