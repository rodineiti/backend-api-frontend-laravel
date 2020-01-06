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
        $dateStart = date('Y-m-d', mktime(0, 0, 0, date('m') , 1 , date('Y')));
        $dateEnd = date('Y-m-d', mktime(23, 59, 59, date('m'), date("t"), date('Y')));

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

        $categories = auth()->user()->categories()->selectRaw('categories.name, sum(value) as value')
            ->leftJoin('bill_pays', 'bill_pays.category_id', '=', 'categories.id')
            ->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->whereNotNull('bill_pays.category_id')
            ->groupBy('categories.name')
            ->get();

        return view('home', compact('statements','total_pays','total_receives','categories','dateStart','dateEnd'));
    }
}
