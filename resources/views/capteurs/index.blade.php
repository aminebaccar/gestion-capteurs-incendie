@extends('layouts.app')
<?php use App\Capteur;
use App\Etablissement;
$current_user = Auth::user();
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
          ],
             "language": {
                         "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/French.json"
                     }
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
             ],
                "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/French.json"
                        }
  } );
} );
</script>
@endif

<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
<div class="card" style="width:90%; margin: auto;">
  <div class="card-header">
    <p style="font-size:20px">Capteurs
    <span class="float-right" >@handheld<a href="capteurs/create" style="font-size:14px;" class="btn btn-outline-secondary btn-sm" >+</a>
    @elsehandheld<a href="capteurs/create" style="font-size:14px;" class="btn btn-outline-secondary btn-sm" >Ajouter Capteur +</a>@endhandheld</span></p>
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
                        //$c = le groupe de $capteur
                        $c = Capteur::find($capteur['parent']);
                        $etab = Etablissement::find($c['etab']);
                          ?>
                        @if(($current_user['etab']==$c['etab'] || Auth::user()->usertype=="super") && $capteur['type']=="capteur")
                        <tr>
                        @if(Auth::user()->usertype == "super")   <td><span class="text-muted">{{$capteur->id}}</span></td> @endif
                          <td>{{$capteur->code_capteur}}</td>
                          <td>{{$capteur->etat}}</td>
                        @if (Auth::user()->usertype == "super")  <td> {{$etab['nom']}}</td>@endif

                    @if ($c['code_capteur']!="")

                      @if (Auth::user()->usertype == "super") <td>Groupe {{$c['code_capteur']}} ({{$etab['nom']}})</td>
                      @else <td>Groupe {{$c['code_capteur']}}</td> @endif

                    @else
                    <td></td>
                    @endif

                          <td>
                            <form action="{{ route('capteurs.destroy', $capteur->id) }}" method="POST">
{{ method_field('DELETE') }}
{{ csrf_field() }}
<button type='submit' name="s"  class="btn btn-danger" data-balloon="Supprimer" data-balloon-pos="up" style=" 	background: none;
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

              <script type="text/javascript">
              let aTags = document.getElementsByName("s");
          for (let i=0;i<aTags.length;i++){
          aTags[i].addEventListener('click', function(e){
          e.preventDefault();
          bootbox.confirm({
          message: "Êtes-vous sûr de vouloir supprimer ce capteur?",
          closeButton: false,
          buttons: {
          confirm: {
            label: 'Oui',
            className: 'btn-success'
          },
          cancel: {
            label: 'Non',
            className: 'btn-danger'
          }
          },
          callback: function (result) {
          if(result){
          aTags[i].form.submit();
          }
          }
          });
          });
            }
              </script>
@endsection
