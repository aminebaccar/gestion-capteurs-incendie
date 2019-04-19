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
                    <table id="id" class="table card-table table-vcenter text-nowrap" style="margin: auto;
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
                          <td>
                            {{$capteur->etat}}
                          </td>
                    @if (Auth::user()->usertype == "super")  <td> {{$etab}}</td>@endif
                    <td>{{$c['code_capteur']}}</td>

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

              <!-- *******************-TESTIING*******************- -->


              <div class="table-responsive">
                <div class="container">
                <table id="id" class="table card-table table-vcenter text-nowrap" style="margin: auto;
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
                      <td>
                        {{$capteur->etat}}
                      </td>
                @if (Auth::user()->usertype == "super")  <td> {{$etab}}</td>@endif
                <td>{{$c['code_capteur']}}</td>

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


                    <tr data-toggle="collapse" data-target=".order1" style="cursor:pointer;">
     <td>+</td>
     <td>1001</td>
     <td>9/29/2016</td>
     <td>$126.27</td>
   </tr>
   <tr class="collapse order1">
     <th></th>
     <th>1</th>
     <th>2</th>
     <th>3</th>
   <tr class="collapse order1">
     <td></td>
     <td>1</td>
     <td>Shirt</td>
     <td>$12.27</td>
   </tr>
   <tr class="collapse order1">
     <td></td>
     <td>1</td>
     <td>Shoes</td>
     <td>$62.27</td>
   </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
@endsection
