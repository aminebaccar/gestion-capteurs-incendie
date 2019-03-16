@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 20px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Ajouter Capteur
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
      <form method="post" action="{{ route('capteurs.store') }}">
        <div class="col-6">
          <div class="form-group">
              @csrf
              <label for="name">Code Capteur:</label>
              <input type="text" class="form-control" name="code_capteur"/>
              @if (Auth::user()->usertype=="super")
              <label for="etab">Établissement:</label>
              <select class="form-control" name="etab">
                  <?php
                  $pdo = new PDO('mysql:host=api.tangorythm.com;dbname=sdi;charset=utf8', 'sdiuser', 'Sdi2019user');
                  $sql = "SELECT * FROM etablissements";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $etabs = $stmt->fetchAll();
                   foreach($etabs as $etab): ?>
                  <option value="<?= $etab['nom']; ?>" name="etab">
                  <?= $etab['nom']; ?></option>
                  <?php endforeach; ?>
              </select>
              @else
              <input id="etab" name="etab" type="hidden" value="{{Auth::user()->etab}}">
              @endif
          </div>
          <button type="submit" class="btn btn-primary">Confirmer</button>
        </div>
      </form>
  </div>
</div>
@endsection
