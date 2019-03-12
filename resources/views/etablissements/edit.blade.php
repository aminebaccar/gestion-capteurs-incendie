@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 20px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Modifier Établissement
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
      <form method="post" action="{{ route('etablissements.update', $etablissement->id) }}">
        @method('PATCH')
        @csrf
        <div class="col-5">
        <div class="form-group">
          <label for="nom">Nom Etablissement :</label>
          <input type="text" class="form-control" name="nom" value="{{ $etablissement->nom }}" />
        </div>
        <div class="form-group">
          <label for="price">E-Mail :</label>
             <input type="text" class="form-control" name="email" value="{{ $etablissement->email }}" />
        </div>
        <div class="form-group">
          <label for="quantity">Telephone:</label>
          <input type="text" class="form-control" name="telephone" value="{{ $etablissement->telephone }}" />
        </div>
      </div>
          <button type="submit" class="btn btn-primary">Confirmer</button>
      </form>
  </div>
</div>
@endsection
