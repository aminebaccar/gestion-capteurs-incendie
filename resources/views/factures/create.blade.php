@extends('layouts.app')

@php
  use App\Etablissement;
@endphp

@section('content')
<style>
  .uper {
    margin-top: 20px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Ajouter Facture
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('factures.store') }}">
      @handheld <div> @elsehandheld   <div class="col-4"> @endhandheld
          <div class="form-group">
              @csrf
              <label for="quantite">Quantité:</label>
              <input type="text" class="form-control" name="quantite"/>
            </div>
          <div class="form-group">
              <label for="Etablissement">Etablissement:</label>
              <select class="form-control" name="etab">
                @php
                  $etbs = Etablissement::all();
                @endphp
                @foreach ($etbs as $etb)
                  <option name="etab" value="{{$etb['id']}}">{{$etb['nom']}}</option>
                @endforeach
              </select>
          </div>
          <button type="submit" class="btn btn-primary">Confirmer</button>
        </div>
      </form>
  </div>
</div>
@endsection
