@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 20px;
  }
  .card-header {
   display: block;
}

</style>
<script type="text/javascript">
document.getElementById('s').addEventListener('click', function() {
  bootbox.confirm({
    message: "This is a confirm with custom button text and color! Do you like it?",
    buttons: {
        confirm: {
            label: 'Yes',
            className: 'btn-success'
        },
        cancel: {
            label: 'No',
            className: 'btn-danger'
        }
    },
    callback: function (result) {
        console.log('This was logged in the callback: ' + result);
    }
});
});
</script>

<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif

<div class="card" style="width:90%; margin: auto;">
  <div class="card-header">
    <p style="font-size:20px">Établissements
    <span class="float-right" ><a href="etablissements/create" style="font-size:14px;" class="btn btn-outline-secondary btn-sm" >Ajouter Établissement +</a>
    </span></p>
  </div>
                  <div class="table-responsive" width="100%">
                    <div class="container" >
                    <table id="id" class="table card-table table-vcenter text-nowrap" style="margin: auto;
  width: 100%;
  padding: 10px;">
                      <thead>
                        <tr>
                          <th class="w-1">ID.</th>
                          <th>Nom d'établissement</th>
                          <th>E-Mail</th>
                          <th>Telephone</th>
                          <th></th>
                          <th>
                        </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($etablissements as $etablissement)
                        <tr>
                          <td><span class="text-muted">{{$etablissement->id}}</span></td>
                          <td>{{$etablissement->nom}}</td>
                          <td>
                            {{$etablissement->email}}
                          </td>

                          <td>
                            {{$etablissement->telephone}}
                          </td>

                          <td class="text-right">
                            <a class="icon" href="{{ route('etablissements.edit',$etablissement->id)}}" data-balloon="Modifier" data-balloon-pos="right">
                              <i class="fe fe-edit"></i>
                            </a>
                          </td>
                          <td>

                            <form action="{{ route('etablissements.destroy', $etablissement->id) }}" method="POST">
{{ method_field('DELETE') }}
{{ csrf_field() }}
        <button id ="s" type='submit' style="	background: none;
  	           color: #9aa0ac;
              	border: none;
	               padding: 0;
	                font: inherit;
	                 cursor: pointer;
	                  outline: inherit;" ><i class="fe fe-trash-2" style="color: inherit;" ></i></button>
                              </form>

                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>



@endsection
