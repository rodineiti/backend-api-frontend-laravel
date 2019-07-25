<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class BillReceiveController extends Controller
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
        $bill_receives = auth()->user()->bill_receives()->orderBy('name', 'asc')->paginate(10);
        return view('bill_receives.index', compact('bill_receives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bill_receives.create');
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
            'date_launch' => 'required|date',
            'name' => 'required|min:3|max:255',
            'value' => 'required|numeric'
        ]);
        
        auth()->user()->bill_receives()->create($request->all());

        Session::flash('success', 'Conta a receber criada com sucesso');

        return redirect()->route('bill_receives.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bill_receive = auth()->user()->bill_receives()->findOrFail($id);
        return view('bill_receives.edit')->with('bill_receive', $bill_receive);
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
            'date_launch' => 'required|date',
            'name' => 'required|min:3|max:255',
            'value' => 'required|numeric'
        ]);

        $bill_receive = auth()->user()->bill_receives()->findOrFail($id);
        $bill_receive->update($request->all());
                
        Session::flash('success', 'Conta a receber atualizada com sucesso');

        return redirect()->route('bill_receives.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bill_receive = auth()->user()->bill_receives()->findOrFail($id);        
        $bill_receive->delete();

        Session::flash('success', 'Conta a receber deletada com sucesso');

        return redirect()->back();
    }
}
