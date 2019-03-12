@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 20px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Modifier Utilisateur
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
      <form method="post" action="{{ route('users.update', $user->id) }}">
        @method('PATCH')
        @csrf
        <div class="col-5">
        <div class="form-group">
          <label for="username">Pseudo Utilisateur:</label>
          <input type="text" class="form-control" name="email" value={{ $user->email }} />
        </div>
        <div class="form-group">
          <label for="price">Mot de Passe:</label>
          <input type="password" class="form-control" name="password" placeholder="Insérer un nouveau mot de passe..." />
        </div>
        <div class="form-group">
          <label for="quantity">Telephone:</label>
          <input type="text" class="form-control" name="telephone" value={{ $user->telephone }} />
        </div>
      </div>
      <div class="col-10">
        <div class="form-group">
          <label for="usertype">Type Utilisateur:</label><br/>
           <input id="normal" type="radio" name="usertype" value="normal"<?php if ($user->usertype=="normal"): ?> checked<?php endif;?> > Normal    </input>
          <input id="admin" type="radio" name="usertype" value="admin" <?php if ($user->usertype=="admin"): ?> checked <?php endif;?>> Administrateur      </input>
          @if (Auth::user()->usertype=="super")<input id="super" type="radio" name="usertype" value="super"> Super Utilisateur    </input>@endif
           @if ($errors->has('usertype'))
           <span class="help-block">
           <strong>{{ $errors->first('usertype') }}</strong>
           </span>
           @endif
           </div>

          <br/>
        </div>
          <button type="submit" class="btn btn-primary">Confirmer</button>
      </form>
  </div>
</div>
@endsection
