<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TypeInterv;

class TypeIntervController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $type_intervs = TypeInterv::all();

      return view('type_intervs.index', compact('type_intervs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('type_intervs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
      'type'=>'required|string'
    ]);

    $type_interv = new TypeInterv([
      'type' => $request->get('type'),
      'etab' => $request->get('etab')
    ]);

    $type_interv->save();
    return redirect('/type_intervs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $type_interv = TypeInterv::find($id);
      $type_interv->delete();
      return redirect('/type_intervs');
    }
    public function __construct()
    {
    $this->middleware('auth');
    $this->middleware('type_interv');}
}
