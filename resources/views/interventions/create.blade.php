@extends('layouts.app')

@section('content')
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
                  $sql = "SELECT * FROM type_intervs";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $types = $stmt->fetchAll();
                   foreach($types as $type): ?>
                  <option value="<?= $type['type']; ?>" name="type">
                  <?= $type['type']; ?></option>
                  <?php endforeach; ?>
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
                  foreach($users as $user):
                     if($user['id']!=$id) { ?>
                  <option value="<?= $user['id']; ?>" name="email">
                  <?= $user['email']; ?> </option>

                  <?php   } endforeach; ?>
              </select>
              <br/>
              @elseif (Auth::user()->usertype=="super")
              <label for="name">Intervenant:</label>
              <select class="form-control" name="email">
                <option value="{{ auth()->user()->id }}" name="email">Utilisateur Actuel</option>
                  <?php
                  $pdo = new PDO('mysql:host=localhost;dbname=gestionpreventionincendie;charset=utf8', 'root', '');
                  $id = \Auth::user()->id;
                  $etab = \Auth::user()->etab;

                  $sql = "SELECT * FROM users";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $users = $stmt->fetchAll();
                  foreach($users as $user):
                     if($user['id']!=$id) { ?>
                  <option value="<?= $user['id']; ?>" name="email">
                  <?= $user['email'] ." "."(".$user['etab'].")"; ?> </option>

                  <?php   } endforeach; ?>
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
