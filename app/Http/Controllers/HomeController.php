<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dateStart = date('Y-m-d', mktime(0, 0, 0, date('m')-1 , 1 , date('Y')));
        $dateEnd = date('Y-m-d', mktime(23, 59, 59, date('m'), date("t"), date('Y')));

        $billPays = auth()->user()->bill_pays()->selectRaw('bill_pays.*, categories.name as category_name')
            ->join('categories', 'categories.id', '=', 'bill_pays.category_id')
            ->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->where('status', '1')
            ->get();

        $billReceives = auth()->user()->bill_receives()->selectRaw('bill_receives.*, categories.name as category_name')
            ->join('categories', 'categories.id', '=', 'bill_receives.category_id')
            ->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->where('status', '1')
            ->get();

        $collection = new Collection(array_merge_recursive($billPays->toArray(), $billReceives->toArray()));
        $statements = $collection->sortByDesc('date_launch');

        $total_pays = $billPays->sum('value');
        $total_receives = $billReceives->sum('value');

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

        return view('home', compact('billPays','billReceives','total_pays','total_receives','categoriesPay','categoriesReceive','dateStart','dateEnd','statements'));
    }
}
