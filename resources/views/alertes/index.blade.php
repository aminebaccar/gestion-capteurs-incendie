@extends('layouts.app')
<?php use App\Capteur;$s = Auth::user();?>
@section('content')
<style>
  .uper {
    margin-top: 20px;
  }

</style>
<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif

<div class="card" style="min-width:50%; width:70%; margin: auto;">
  <div class="card-header">
    <p style="font-size:20px">Alertes
    </p>
  </div>
                  <div class="table-responsive">
                    <div class="container">
                    <table id="id" class="table card-table table-vcenter text-nowrap" style="margin: auto;
  width: 70%;
  padding: 10px;" >
                      <thead>
                        <tr>
                        @if($s['usertype']=="super")  <th class="w-1">ID.</th> @endif
                          <th>Evenement</th>
                          <th>Date</th>
                          <th>Capteur</th>

                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($historiques as $historique)
                        <?php $capteur = Capteur::find($historique->capteur);?>
                        @if($s['etab']==$capteur->etab || $s['usertype']=="super" )
                        <tr>
                          @if($s['usertype']=="super")<td><span class="text-muted">{{$historique->id}}</span></td>@endif
                          <td>{{$historique->evenement}}</td>
                          <td>
                            {{$historique->created_at}}
                          </td>
                          <td>
                            {{$historique->capteur}}
                          </td>
                        <td>
                          <a class="icon" href="{{ route('alertes.consulte',$historique->id)}}"><button class="btn btn-danger"><i class="fe fe-check"></i></button></a>
                        </td>
                        </tr>
                        @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
@endsection
