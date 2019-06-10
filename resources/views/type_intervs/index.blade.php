@extends('layouts.app')
@php
  use App\Etablissement;
@endphp
@section('content')
<style>
  .uper {
    margin-top: 40px;
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
    <p style="font-size:20px">Types Intervention
    <span class="float-right" >@handheld<a href="type_intervs/create" style="font-size:14px;" class="btn btn-outline-secondary btn-sm" >+</a>
    @elsehandheld <a href="type_intervs/create" style="font-size:14px;" class="btn btn-outline-secondary btn-sm" >Ajouter Type Intervention +</a>
  @endhandheld</span></p>
  </div>
                  <div class="table-responsive">
                    <div class="container">
                    <table id="id" class="table card-table table-vcenter text-nowrap" style="margin: auto;
  width: 100%;
  padding: 10px;" >
                      <thead>
                        <tr>
                          <th class="w-1">ID.</th>
                          <th>Libellé</th>
                          @if (Auth::user()->usertype=="super")<th>Établissement</th>@endif
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($type_intervs as $type_interv)
                          @if ($type_interv->deleted!=1)
                          @php $et = Etablissement::find($type_interv['etab']); @endphp
                        @if ($type_interv->etab==Auth::user()->etab || Auth::user()->usertype=="super" )
                        <tr>
                          <td><span class="text-muted">{{$type_interv->id}}</span></td>
                          <td>{{$type_interv->type}}</td>
                          @if (Auth::user()->usertype=="super")<td>{{$et['nom']}}</td>@endif
                          <td>
                            <a class="icon" href="{{ route('type_intervs.deleted',$type_interv->id)}}" data-balloon="Supprimer" data-balloon-pos="up">
                              <i class="fe fe-trash-2"></i>
                            </a>
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
    message: "Êtes-vous sûr de vouloir supprimer ce type d'intervention?",
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
