@extends('layouts.app')
<?php use App\Capteur;

?>
@section('content')
<style>
  .uper {
    margin-top: 20px;
  }
  .card-header {
   display: block;

}
.form-button {
	background: none;
	color: inherit;
	border: none;
	padding: 0;
	font: inherit;
	cursor: pointer;
	outline: inherit;
}

</style>
  @if (Auth::user()->usertype=="super")
<script type="text/javascript">

$(document).ready(function() {
  $('#example').DataTable( {
      order: [[4, 'asc']],
      rowGroup: {
          dataSrc: 4
      },
      "columnDefs": [
            {
                "targets": [ 4 ],
                "visible": false,
                "searchable": false
            }
             ]
  } );
} );
</script>
@else
<script type="text/javascript">

$(document).ready(function() {
  $('#example').DataTable( {
      order: [[2, 'asc']],
      rowGroup: {
          dataSrc: 2
      },
      "columnDefs": [
            {
                "targets": [ 2 ],
                "visible": false,
                "searchable": false
            }
             ]
  } );
} );
</script>

<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
<input type="hidden" id="logged" name="loggedin" value="{{Auth::user()->email}}"/>
<div class="card" style="width:90%; margin: auto;">
  <div class="card-header">
    <p style="font-size:20px">Capteurs
    <span class="float-right" ><a href="capteurs/create" style="font-size:14px;" class="btn btn-outline-secondary btn-sm" >Ajouter Capteur +</a>
    </span></p>
  </div>
                  <div class="table-responsive">
                    <div class="container">
                    <table id="example" class="table card-table table-vcenter text-nowrap" style="margin: auto;
  width: 100%;
  padding: 10px;" >
                      <thead>
                        <tr>
                        @if(Auth::user()->usertype == "super")  <th class="w-1">ID.</th> @endif
                          <th>Code Capteur</th>
                          <th>État</th>
                        @if (Auth::user()->usertype == "super") <th> Établissement</th> @endif
                          <th>Groupe</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($capteurs as $capteur)
                        <?php
                        $c = Capteur::find($capteur['parent']);
                        if ($c['type']=="capteur") {
                            $etab = $c['etab'];
                        } else {
                            $etab = $capteur['etab'];
                        }

                          ?>
                        @if((Auth::user()->etab==$capteur->etab || Auth::user()->usertype=="super") && $capteur['type']=="capteur")
                        <tr>
                        @if(Auth::user()->usertype == "super")   <td><span class="text-muted">{{$capteur->id}}</span></td> @endif
                          <td>{{$capteur->code_capteur}}</td>
                          <td>{{$capteur->etat}}</td>
                        @if (Auth::user()->usertype == "super")  <td> {{$etab}}</td>@endif

                    @if ($c['code_capteur']!="")

                      @if (Auth::user()->usertype == "super") <td>Groupe {{$c['code_capteur']}} ({{$etab}})</td>
                      @else <td>Groupe {{$c['code_capteur']}}</td> @endif

                    @else
                    <td></td>
                    @endif

                          <td>
                            <form action="{{ route('capteurs.destroy', $capteur->id) }}" method="POST">
{{ method_field('DELETE') }}
{{ csrf_field() }}
<button type='submit' class="btn btn-danger" style="	background: none;
	color: #9aa0ac;
	border: none;
	padding: 0;
	font: inherit;
	cursor: pointer;
	outline: inherit;" ><i class="fe fe-trash-2" style="color: inherit;" ></i></button>
</form>
                          </td>
                        </tr>
                        @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <!-- *******************-TESTIING*******************-


              <div class="table-responsive">
                <div class="container">
                <table id="id" class="table card-table table-vcenter text-nowrap" style="margin: auto;
width: 100%;
padding: 10px;" >
                  <thead>
                    <tr>
                    @if(Auth::user()->usertype == "super")  <th class="w-1">ID.</th> @endif
                      <th>Groupe</th>
                    @if (Auth::user()->usertype == "super") <th> Établissement</th> @endif
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach($capteurs as $capteur)
                    <?php
                    $c = Capteur::find($capteur['parent']);
                    if ($c['type']=="capteur") {
                        $etab = $c['etab'];
                    } else {
                        $etab = $capteur['etab'];
                    }
                    $q = $capteur['id'];

                      ?>
                    @if((Auth::user()->etab==$capteur->etab || Auth::user()->usertype=="super") && $capteur['type']=="groupe")
                    @php $i++; @endphp
                    <tr data-toggle="collapse" data-target=".order{{$i}}" style="cursor:pointer;">
                    @if(Auth::user()->usertype == "super")   <td><span class="text-muted">{{$capteur->id}}</span></td> @endif
                      <td>{{$capteur->code_capteur}}</td>
                @if (Auth::user()->usertype == "super")  <td> {{$etab}}</td>@endif


                      <td>
                        <form action="{{ route('capteurs.destroy', $capteur->id) }}" method="POST">
{{ method_field('DELETE') }}
{{ csrf_field() }}
<button type='submit' class="btn btn-danger" style="	background: none;
color: #9aa0ac;
border: none;
padding: 0;
font: inherit;
cursor: pointer;
outline: inherit;" ><i class="fe fe-trash-2" style="color: inherit;" ></i></button>
</form>
                      </td>
                    </tr>


                    @foreach($capteurs as $cpt)
                    @if ($cpt['parent']==$q)
                    <tr class="collapse order{{$i}}">
                      <td></td>
                      <td class="w-1">{{$cpt->id}}</td>
                      <td>{{$cpt->code_capteur}}</td>
                      <td>{{$cpt->etat}}</td>
                      <td><form action="{{ route('capteurs.destroy', $cpt->id) }}" method="POST">
{{ method_field('DELETE') }}
{{ csrf_field() }}
<button type='submit' class="btn btn-danger" style="	background: none;
color: #9aa0ac;
border: none;
padding: 0;
font: inherit;
cursor: pointer;
outline: inherit;" ><i class="fe fe-trash-2" style="color: inherit;" ></i></button>
</form></td>
                    </tr>

                    @endif
                    @endforeach
                    @endif
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          -->
@endsection
