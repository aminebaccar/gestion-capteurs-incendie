@extends('layouts.app')

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
    <span class="float-right" ><a href="type_intervs/create" style="font-size:14px;" class="btn btn-outline-secondary btn-sm" >Ajouter Type Intervention +</a>
    </span></p>
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
                        @if ($type_interv->etab==Auth::user()->etab || Auth::user()->usertype=="super" )
                        <tr>
                          <td><span class="text-muted">{{$type_interv->id}}</span></td>
                          <td>{{$type_interv->type}}</td>
                          @if (Auth::user()->usertype=="super")<td>{{$type_interv->etab}}</td>@endif
                          <td>
                            <form action="{{ route('type_intervs.destroy', $type_interv->id) }}" method="POST">
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
                        </tr>
                        @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
@endsection
