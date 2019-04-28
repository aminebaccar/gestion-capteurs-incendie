@extends('layouts.app')
@section('content')

@php
  use App\Etablissement;
  use App\Capteur;
@endphp

<style>
  .uper {
    margin-top: 20px;
  }
</style>
<div class="card uper" id="wrapper">
  <div class="card-header">
    Ajouter Intervention
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
      <form method="post" action="{{ route('interventions.store') }}">
        @handheld <div> @elsehandheld <div class="col-6"> @endhandheld
          <div class="form-group">
              @csrf
              <label for="name">Type Intervention:</label>
              <select class="form-control" name="type">
                  <?php
                  $pdo = new PDO('mysql:host=api.tangorythm.com;dbname=sdi', 'sdiuser', 'Sdi2019user');
                  if (\Auth::user()->usertype!="super") {
                      $sql = "SELECT * FROM type_intervs where etab like ".\Auth::user()->etab;
                  } else {
                      $sql = "SELECT * FROM type_intervs";
                  }
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $types = $stmt->fetchAll();
                   foreach ($types as $type): ?>
                  <option value="<?= $type['type']; ?>" name="type">
                  <?= $type['type']; ?></option>
                  <?php endforeach; ?>
              </select><br/>
              <label for="name">Capteur:</label>
              <select class="form-control" name="capteur">
                <?php
                  $pdo = new PDO('mysql:host=api.tangorythm.com;dbname=sdi', 'sdiuser', 'Sdi2019user');
                  if (\Auth::user()->usertype!="super") {
                      $sql = "SELECT * FROM capteurs where etab like ".\Auth::user()->etab." and type like 'capteur'";
                  } else {
                      $sql = "SELECT * FROM capteurs where type like 'capteur'";
                  }
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $cpts = $stmt->fetchAll();
                  foreach ($cpts as $cpt):
                    $grp = Capteur::find($cpt['parent']);
                    $etb = Etablissement::find($grp['etab']);
                     ?>
                 <option value="<?= $cpt['id']; ?>" name="capteur">
                 <?= $cpt['code_capteur']; ?> (Groupe: {{$grp['code_capteur']}} Etablissement: {{$etb['nom']}})</option>
                 <?php endforeach; ?>

                ?>
              </select><br/>
              @if (Auth::user()->usertype=="admin" )
              <label for="name">Intervenant:</label>
              <select class="form-control" name="email">
                <option value="{{ auth()->user()->id }}" name="email">Utilisateur Actuel</option>
                  <?php
                  $pdo = new PDO('mysql:host=api.tangorythm.com;dbname=sdi;charset=utf8', 'sdiuser', 'Sdi2019user');
                  $id = \Auth::user()->id;
                  $etab = \Auth::user()->etab;

                  $sql = "SELECT * FROM users where etab like '$etab'";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $users = $stmt->fetchAll();
                  foreach ($users as $user):
                     if ($user['id']!=$id) {
                         ?>
                  <option value="<?= $user['id']; ?>" name="email">
                  <?= $user['email']; ?> </option>

                  <?php
                     } endforeach; ?>
              </select>
              <br/>
              @elseif (Auth::user()->usertype=="super")
              <label for="name">Intervenant:</label>
              <select class="form-control" name="email">
                <option value="{{ auth()->user()->id }}" name="email">Utilisateur Actuel</option>
                  <?php
                  $pdo = new PDO('mysql:host=api.tangorythm.com;dbname=sdi;charset=utf8', 'sdiuser', 'Sdi2019user');
                  $id = \Auth::user()->id;
                  $etab = \Auth::user()->etab;

                  $sql = "SELECT * FROM users order by etab";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $users = $stmt->fetchAll();
                  foreach ($users as $user):
                    $etabli = Etablissement::find($user['etab']);
                     if ($user['id']!=$id) {
                         ?>
                  <option value="<?= $user['id']; ?>" name="email">
                  <?= $user['email'] ." "."(".$etabli['nom'].")"; ?> </option>

                  <?php
                     } endforeach; ?>
              </select>
              <br/>
              @else
              <input id="email" name="email" type="hidden" value="{{Auth::user()->email}}">
              @endif
              <label for="com">Commentaire:</label>
              <textarea type="text" class="form-control" name="commentaire"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Confirmer</button>
        </div>
      </form>
  </div>
</div>
@endsection
