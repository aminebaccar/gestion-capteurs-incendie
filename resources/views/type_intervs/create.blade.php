@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Ajouter Type Intervention
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
      <form method="post" action="{{ route('type_intervs.store') }}">
        <div class="col-6">
          <div class="form-group">
              @csrf
              <label for="name">Libellé:</label>
              <input type="text" class="form-control" name="type"/>
              @if(Auth::user()->usertype=="super")<div class="form-group">
                <label for="etab">Établissement:</label>
                <select class="form-control" name="etab">
                    <?php
                    $pdo = new PDO('mysql:host=localhost;dbname=gestionpreventionincendie;charset=utf8', 'root', '');
                    $sql = "SELECT * FROM etablissements";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $etabs = $stmt->fetchAll();
                     foreach($etabs as $etab): ?>
                    <option value="<?= $etab['nom']; ?>" name="etab">
                    <?= $etab['nom']; ?></option>
                    <?php endforeach; ?>
                </select>
              </div>@endif
          </div>
          <button type="submit" class="btn btn-primary">Confirmer</button>
        </div>
      </form>
  </div>
</div>
@endsection
