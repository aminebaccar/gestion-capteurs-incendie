@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 20px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Ajouter Utilisateur
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
      <form method="post" action="{{ route('users.store') }}">
        <div class="col-4">
          <div class="form-group">
              @csrf
              <label for="email">Pseudo Utilisateur:</label>

              <input type="text" class="form-control" name="email"/>
            </div>


          <div class="form-group">
              <label for="password">Mot de passe:</label>
              <input type="password" class="form-control" name="password" />
          </div>
          <div class="form-group">
              <label for="telephone">Telephone:</label>
              <input type="text" class="form-control" name="telephone" />
          </div>
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
          </div>
          @else
            <input id="etab" name="etab" type="hidden" value="{{Auth::user()->etab}}">
          @endif
        </div>
        <div class="col-10">
          <div class="form-group">
            <label for="usertype">Type Utilisateur:</label>
            <input id="normal" type="radio" name="usertype" value="normal" checked> Normal     </input>
           <input id="admin" type="radio" name="usertype" value="admin"> Administrateur      </input>
           @if (Auth::user()->usertype=="super")<input id="super" type="radio" name="usertype" value="super"> Super Utilisateur    </input>@endif
            @if ($errors->has('usertype'))
            <span class="help-block">
            <strong>{{ $errors->first('usertype') }}</strong>
            </span>
            @endif
           </div>
</div>
          <button type="submit" class="btn btn-primary">Confirmer</button>
      </form>
  </div>
</div>
@endsection
