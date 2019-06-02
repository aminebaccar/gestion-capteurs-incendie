@extends('layouts.app')
<?php use App\User;
use App\Etablissement;
use App\Capteur;
use App\Intervention;
use App\TypeInterv;?>
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
    <p style="font-size:20px">Interventions<span class="float-right" >@handheld<a href="interventions/create" style="font-size:14px;" class="btn btn-outline-secondary btn-sm" >+</a>
    @elsehandheld <a href="interventions/create" style="font-size:14px;" class="btn btn-outline-secondary btn-sm" >Ajouter Intervention +</a>@endhandheld</span>
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
                        @if(Auth::user()->usertype!="normal")  <th>Utilisateur</th>@endif
                          <th>Capteur</th>
                          @if(Auth::user()->usertype=="super")<th>Établissement</th>@endif
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($interventions as $intervention)
                        <?php $user = User::find($intervention->user);
                        $etb = Etablissement::find($intervention['etab']);?>
                        @if(Auth::user()->etab == $user['etab'] || Auth::user()->usertype=="super" )
                        @if((Auth::user()==$user && Auth::user()->usertype=="normal")|| Auth::user()->usertype!="normal")
                        <tr>
                        @if(Auth::user()->usertype=="super")  <td><span class="text-muted">{{$intervention->id}}</span></td>@endif
                          <td>
                            @php
                             $t = TypeInterv::find($intervention->type);
                            @endphp
                            {{$t['type']}}
                          </td>
                          <td>{{$intervention->commentaire}}</td>
                          <td>
                            {{$intervention->created_at}}
                          </td>
                          @if(Auth::user()->usertype=="admin"||Auth::user()->usertype=="super")<td>
                            {{$user['email']}}
                          </td>

                          @endif
                          <td>
                          @php
                            $cp = Capteur::find($intervention['capteur']);
                            $gr = Capteur::find($cp['parent']);
                            $eb = Etablissement::find($gr['etab']);
                          @endphp
                          {{$cp['code_capteur']}} (Groupe: {{$gr['code_capteur']}})
                          </td>
                          @if(Auth::user()->usertype=="super")
                          <td>
                            {{$eb['nom']}}
                          </td>
                          @endif
                        </tr>
                        @endif
                        @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
@endsection
