@extends('layouts.app')
@php use App\Etablissement;@endphp
@section('content')
<style>
  .uper {
    margin-top: 20px;
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
    <p style="font-size:20px">Utilisateurs
    <span class="float-right" ><a href="users/create" style="font-size:14px;" class="btn btn-outline-secondary btn-sm" >Ajouter Utilisateur +</a>
    </span></p>
  </div>
                  <div class="table-responsive" width="100%">
                    <div class="container" >
                    <table id="id" class="table card-table table-vcenter text-nowrap" style="margin: auto;
  width: 100%;
  padding: 10px;">
                      <thead>
                        <tr>
                          @if (Auth::user()->usertype=="super")<th class="w-1">ID.</th>@endif
                          <th>Pseudo Utilisateur</th>
                          <th>Telephone</th>
                          <th>Type Utilisateur</th>
                          <th>État</th>
                          @if (Auth::user()->usertype=="super")<th>Établissement</th>@endif
                          <th></th>
                          <th>
                        </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($users as $user)
                          @php
                          $etab = Etablissement::find($user->etab);
                          @endphp
                        @if ($user->etab==Auth::user()->etab || Auth::user()->etab==null )
                        <tr>
                          @if (Auth::user()->usertype=="super")<td><span class="text-muted">{{$user->id}}</span></td>@endif
                          <td>{{$user->email}}</td>
                          <td>
                            {{$user->telephone}}
                          </td>
                          <?php if ($user->usertype=="normal"): ?>
                          <td>
                            Utilisateur Normal
                          </td>
                        <?php elseif ($user->usertype=="admin"): ?>
                          <td>
                            Administrateur
                          </td>
                        <?php else: ?>
                          <td>Super Utilisateur</td>
                        <?php endif; ?>
                          <?php if ($user->bloque==1): ?>
                          <td><span class="status-icon bg-danger"></span>Bloqué</td>
                        <?php else: ?>
                          <td><span class="status-icon bg-success"></span>Actif</td>
                          <?php endif; ?>
                          @if(Auth::user()->usertype=="super")<td>
                            {{$etab['nom']}}
                          </td>@endif
                          <td class="text-right">
                            <a class="icon" href="{{ route('users.edit',$user->id)}}" data-balloon="Modifier" data-balloon-pos="up">
                              <i class="fe fe-edit"></i>
                            </a>
                          </td>
                          <td>

                                <a class="icon" href="{{ route('users.block',$user->id)}}" <?php if ($user->bloque==1): ?> data-balloon="Débloquer" <?php else: ?> data-balloon="Bloquer" <?php endif;?> data-balloon-pos="up">
                                  <i <?php if ($user->bloque==1): ?> class="fe fe-unlock" <?php else: ?> class="fe fe-lock"  <?php endif;?> ></i>
                                </a>

                          </td>

                        </tr>
                        @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>



@endsection
