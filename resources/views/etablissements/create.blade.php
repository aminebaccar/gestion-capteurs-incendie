@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 20px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Ajouter Établissement
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
      <form method="post" action="{{ route('etablissements.store') }}">
      @handheld <div> @elsehandheld   <div class="col-4"> @endhandheld
          <div class="form-group">
              @csrf
              <label for="email">Nom Établissement:</label>

              <input type="text" class="form-control" name="nom"/>
            </div>
          </div>
            <div class="col-4">
          <div class="form-group">
              <label for="password">E-Mail:</label>
              <input type="email" class="form-control" name="email"/>
          </div>
          <div class="form-group">
              <label for="telephone">Téléphone:</label>
              <input type="text" class="form-control" name="telephone"/>
          </div>
        </div>
          <button type="submit" class="btn btn-primary">Confirmer</button>
      </form>
  </div>
</div>
@endsection
