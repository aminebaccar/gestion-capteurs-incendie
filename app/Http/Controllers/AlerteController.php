<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Historique;
use Auth;

class AlerteController extends Controller
{
  public function index()
  {
    $historiques = Historique::where('consulte',null)->get();

    return view('alertes.index', compact('historiques'));
  }

  public function consulte($id){
    $historique = Historique::find($id);
    $historique->consulte = Auth::user()->id;
    $historique->save();
    return redirect('/alertes')->with('success','Alerte consulté avec succès');
  }

  public function __construct()
  {
  $this->middleware('auth');
  }

}
