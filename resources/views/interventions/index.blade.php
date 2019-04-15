@extends('layouts.app')
<?php use App\User;?>
@section('content')
<style>
  .uper {
    margin-top: 20px;
  }
  .card-header {
   display: block;

}
</style>

<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif

<div class="card" style="width:90%; margin: auto;">
  <div class="card-header">
    <p style="font-size:20px">Interventions<span class="float-right" ><a href="interventions/create" style="font-size:14px;" class="btn btn-outline-secondary btn-sm" >Ajouter Intervention +</a>
    </span>
    </p>
  </div>
                  <div class="table-responsive">
                    <div class="container">
                    <table id="id" class="table card-table table-vcenter text-nowrap" style="margin: auto;
  width: 100%;
  padding: 10px;" >
                      <thead>
                        <tr>
                          @if(Auth::user()->usertype=="super")<th class="w-1">ID.</th>@endif
                          <th>Type Intervention</th>
                          <th>Commentaire</th>
                          <th>Date</th>
                          <th>Utilisateur</th>
                          @if(Auth::user()->usertype=="super")<th>Établissement</th>@endif
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($interventions as $intervention)
                        <?php $user = User::find($intervention->user); ?>
                        @if(Auth::user()->etab == $user['etab'] || Auth::user()->usertype=="super" )
                        <tr>
                        @if(Auth::user()->usertype=="super")  <td><span class="text-muted">{{$intervention->id}}</span></td>@endif
                          <td>{{$intervention->type}}</td>
                          <td>{{$intervention->commentaire}}</td>
                          <td>
                            {{$intervention->created_at}}
                          </td>
                          <td>
                            {{$user['email']}}
                          </td>
                          @if(Auth::user()->usertype=="super")
                          <td>
                            {{$user['etab']}}
                          </td>
                          @endif
                        </tr>
                        @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
@endsection
