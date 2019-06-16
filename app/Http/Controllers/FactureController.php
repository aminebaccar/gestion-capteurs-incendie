<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facture;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $factures = Facture::orderBy('created_at','DESC')
	  ->orderBy('paie','ASC')
	  ->get();

      return view('factures.index', compact('factures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          return view('factures.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $qt = $request->get('quantite');
      $request->validate([
      'quantite'=>'required|integer',
      'etab' => 'required',
    ]);

    $facture = new Facture([
      'quantite' => $qt,
      'etab' => $request->get('etab'),
      'montant' => $qt*0.75
    ]);

    $facture->save();
    return redirect('/factures')->with('success',"Facture ajoutée avec succès");
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
        //
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
        //
    }
    public function __construct()
    {
    $this->middleware('auth');
    $this->middleware('facture');
    $this->middleware('blocage');
}
}
