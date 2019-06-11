<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Etablissement;

class EtablissementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $etablissements = Etablissement::all();

      return view('etablissements.index', compact('etablissements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('etablissements.create');
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
      'nom'=>'required',
      'email'=>'required|email',
      'telephone'=>'required|integer'
    ]);

    $etablissement = new Etablissement([
      'nom' => $request->get('nom'),
      'email' => $request->get('email'),
      'telephone' => $request->get('telephone')
    ]);

    $etablissement->save();
    return redirect('/etablissements')->with('success','Etablissement ajoutée avec succès');
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
      $etablissement = Etablissement::find($id);

      return view('etablissements.edit', compact('etablissement'));
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
      $request->validate([
        'nom'=>'required',
        'email'=> 'required',
        'telephone' => 'required|numeric'
    ]);

    $etablissement = Etablissement::find($id);
    $etablissement->nom = $request->get('nom');
    $etablissement->email = $request->get('email');
    $etablissement->telephone = $request->get('telephone');
    $etablissement->save();

    return redirect('/etablissements')->with('success','Etablissement modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $etablissement = Etablissement::find($id);
      $etablissement->delete();
      return redirect('/etablissements');
    }
    public function __construct()
    {
    $this->middleware('auth');
    $this->middleware('etablissement');
    $this->middleware('blocage');
}
}
