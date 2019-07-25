<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Session;

class BillPayController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bill_pays = auth()->user()->bill_pays()->orderBy('name', 'asc')->paginate(10);
        return view('bill_pays.index', compact('bill_pays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = auth()->user()->categories()->get();
        return view('bill_pays.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'date_launch' => 'required|date',
            'name' => 'required|min:3|max:255',
            'value' => 'required|numeric'
        ]);
        
        auth()->user()->bill_pays()->create($request->all());

        Session::flash('success', 'Conta a pagar criada com sucesso');

        return redirect()->route('bill_pays.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = auth()->user()->categories()->get();
        $bill_pay = auth()->user()->bill_pays()->findOrFail($id);
        return view('bill_pays.edit', compact('bill_pay','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'date_launch' => 'required|date',
            'name' => 'required|min:3|max:255',
            'value' => 'required|numeric'
        ]);

        $bill_pay = auth()->user()->bill_pays()->findOrFail($id);
        $bill_pay->update($request->all());
                
        Session::flash('success', 'Conta a pagar atualizada com sucesso');

        return redirect()->route('bill_pays.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bill_pay = auth()->user()->bill_pays()->findOrFail($id);        
        $bill_pay->delete();

        Session::flash('success', 'Conta a pagar deletada com sucesso');

        return redirect()->back();
    }
}
