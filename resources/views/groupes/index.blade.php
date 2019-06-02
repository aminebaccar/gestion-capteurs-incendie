@extends('layouts.app')
<?php use App\Capteur;
use App\Etablissement;
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
<script type="text/javascript">

$(document).ready(function() {
  $('#example').DataTable( {
    "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/French.json"
            }
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
    <p style="font-size:20px">Groupes
    <span class="float-right" >@handheld <a href="groupes/create" style="font-size:14px;" class="btn btn-outline-secondary btn-sm" >+</a>
    @elsehandheld <a href="groupes/create" style="font-size:14px;" class="btn btn-outline-secondary btn-sm" >Ajouter Groupe +</a>@endhandheld</span></p>
  </div>
                  <div class="table-responsive">
                    <div class="container">
                    <table id="example" class="table card-table table-vcenter text-nowrap" style="margin: auto;
  width: 100%;
  padding: 10px;" >
                      <thead>
                        <tr>
                        @if(Auth::user()->usertype == "super")  <th class="w-1">ID.</th> @endif
                          <th>Groupe</th>
                          <th>Quantité</th>
                        @if (Auth::user()->usertype == "super") <th> Établissement</th> @endif
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($groupes as $groupe)
                          @php
                            $eggg = Etablissement::find($groupe->etab);
                          @endphp
                          @if($groupe->type=="groupe")
                            @if($groupe->etab==Auth::user()->etab || Auth::user()->usertype=="super")
                          <tr>
                            @if(Auth::user()->usertype=="super")<td><span class="text-muted">{{$groupe->id}}</span></td>@endif
                              <td>{{$groupe->code_capteur}}</td>
                              <td>{{DB::table('capteurs')->where('parent', $groupe->id)->count('id')}}</td>
                            @if(Auth::user()->usertype=="super")<td>{{$eggg['nom']}}</td>@endif
                          <td>
                            <form action="{{ route('groupes.destroy', $groupe->id) }}" method="POST">
{{ method_field('DELETE') }}
{{ csrf_field() }}
<button type='submit' class="btn btn-danger" data-balloon="Supprimer" name="s" data-balloon-pos="up"  style="	background: none;
	color: #9aa0ac;
	border: none;
	padding: 0;
	font: inherit;
	cursor: pointer;
	outline: inherit;" ><i class="fe fe-trash-2"  style="color: inherit;" ></i></button>
</form>
                          </td>
                        </tr>
                      @endif
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
    message: "Êtes-vous sûr de vouloir supprimer ce groupe?",
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
