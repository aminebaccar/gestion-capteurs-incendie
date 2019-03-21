<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $users = User::all();

      return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
              'email'=>'required|unique:users',
              'password'=> 'required',
              'telephone' => 'required|numeric|unique:users',
              'usertype' =>'required',
              'etab' => 'required'
            ]);
            $user = new User([
              'email' => $request->get('email'),
              'password'=> Hash::make($request['password']),
              'telephone'=> $request->get('telephone'),
              'usertype'=> $request->get('usertype'),
              'etab' => $request->get('etab')
            ]);
            $user->save();
            return redirect('/users');
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
      $user = User::find($id);

      return view('users.edit', compact('user'));
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
        'email'=>'required',
        'telephone' => 'required|numeric',
        'usertype' =>'required'
    ]);

    $user = User::find($id);
    $user->email = $request->get('email');
    $user->password =  Hash::make($request['password']);
    $user->telephone = $request->get('telephone');
    $user->usertype = $request->get('usertype');
    $user->save();

    return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
      $user = User::find($id);
   $user->delete();

   return redirect('/users')->with('success', 'Stock has been deleted Successfully');
    }

    public function block($id){
      $user = User::find($id);
      if ($user->bloque == 0){
      $user->bloque = 1 ;
      $user->save();
      return redirect('/users');}
      else{
        $user->bloque = 0;
        $user->save();
        return redirect('/users');
      }


    }

    public function __construct()
{
    $this->middleware('auth');
    $this->middleware('usertype');
}
}
