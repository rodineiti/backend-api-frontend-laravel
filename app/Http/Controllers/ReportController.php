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
            ->leftJoin('categories', 'categories.id', '=', 'bill_pays.category_id')
            ->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->get();

        $billReceives = auth()->user()->bill_receives()->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->get();

        //Collection [0 => BillPay, 1 => BillPay..]
        //Collection [0 => BillReceive,1 => BillReceive..]

        $collection = new Collection(array_merge_recursive($billPays->toArray(), $billReceives->toArray()));
        $statements = $collection->sortByDesc('date_launch');

        $total_pays = $billPays->sum('value');
        $total_receives = $billReceives->sum('value');

        return view('report.statement', compact('statements','total_pays','total_receives'));
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

        $categories = auth()->user()->categories()->selectRaw('categories.name, sum(value) as value')
            ->leftJoin('bill_pays', 'bill_pays.category_id', '=', 'categories.id')
            ->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->whereNotNull('bill_pays.category_id')
            ->groupBy('categories.name')
            ->get();

        return view('report.charts', compact('categories'));
    }
}
