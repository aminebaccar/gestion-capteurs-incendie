<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Capteur;

class CapteurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $capteurs = Capteur::all();

      return view('capteurs.index', compact('capteurs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('capteurs.create');
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
      'code_capteur'=>'required|integer',
      'etab' => 'required'
    ]);

    $capteur = new Capteur([
      'code_capteur' => $request->get('code_capteur'),
      'etab' => $request->get('etab')
    ]);

    $capteur->save();
    return redirect('/capteurs');
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
      $capteur = Capteur::find($id);
      $capteur->delete();
      return redirect('/capteurs');
    }
    public function __construct()
    {
    $this->middleware('auth');
    $this->middleware('capteur');}
}
