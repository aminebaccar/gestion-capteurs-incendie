<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php use App\Capteur;?>
    <?php use App\User;?>
    <?php use App\Historique;?>
     <?php use App\Etablissement;?>
     <?php
     $us = Auth::user();
     $et = Etablissement::where('nom', $us['etab'])->first();

     ?>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GCI - Gestion Capteurs Incendie</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/balloon-css/0.5.0/balloon.min.css">

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
      var OneSignal = window.OneSignal || [];
      OneSignal.push(function() {
        OneSignal.init({
          appId: "0d7c813b-31f6-47a0-a80e-f1793086c5af",
          notifyButton: {
            enable: true,
          },
        });
      });
      OneSignal.push(function() {OneSignal.sendTag("etab", <?php echo $et['id']; ?>);});
    </script>
   <script>
    $(document).ready( function () {

      $('#id').DataTable({
        "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/French.json"
                }
              });
              } );
    </script>



</head>
<body>
    <div id="app">

        <div class="header py-4">
                <div class="container">
                    <div class="d-flex">
                        <a class="header-brand" href="{{ route('home')}}">
                            <img
                                src="https://i.imgur.com/KjMX2jp.png"
                                class="header-brand-img"
                                alt="gci logo">
                        </a>


                        <div class="d-flex order-lg-2 ml-auto">
                            @guest
                                <div class="nav-item d-none d-md-flex">
                                    <a class="btn btn-link" href="{{ route('login') }}">@lang('Authentification')</a>
                                </div>

                            @else




                            <div class="dropdown d-none d-md-flex show">
                  <a class="nav-link icon" data-toggle="dropdown" aria-expanded="false">
                    <i class="fe fe-bell"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" x-placement="bottom-end" style="position: absolute; transform: translate3d(-444px, 32px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <?php $historiques = Historique::where('consulte',null)
                    ->orderBy('created_at','desc')
                    ->take(3)
                    ->get();?>

                    @foreach($historiques as $historique)
                    <?php $capt = Capteur::find($historique['capteur']);?>
                    @if($historique->consulte==null)

                    <a href="#" class="dropdown-item d-flex">
                      <div>
                        <strong>Capteur {{$capt['code_capteur']}}</strong> a comme état: {{$historique->evenement}}
                        <div class="small text-muted">{{$historique->created_at}}</div>
                      </div>
                    </a>

                    @endif
                    @endforeach
                    <div class="dropdown-divider"></div>
                    <a href="/alertes" class="dropdown-item text-center text-muted-dark">Tous les alertes</a>
                  </div>
                </div>






                            <div class="dropdown">
                                <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                                    <span class="avatar" style="background-image: url(https://cdn2.iconfinder.com/data/icons/rcons-user/32/male-shadow-circle-512.png)">
                                      <span class="avatar-status bg-green"></span>
                                    </span>
                                    <span class="ml-2 d-none d-lg-block">
                                    <span class="text-default">{{ auth()->user()->email }}</span>
                                        <small class="text-muted d-block mt-1">
                                          <?php
                                          if (auth()->user()->usertype=="normal")
                                          echo "Utilisateur";
                                          elseif (auth()->user()->usertype=="admin")
                                            echo "Administrateur";
                                          else
                                            echo "Super Utilisateur";
                                          ?>
                                        </small>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        <i class="dropdown-icon fe fe-log-out"></i> @lang('Déconnecter')
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            @endguest
                        </div>

                        <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                            <span class="header-toggler-icon"></span>
                        </a>
                    </div>
                </div>
            </div>

        @auth
            <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3 ml-auto">
                        </div>
                        <div class="col-lg order-lg-first">
                            <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                                <li class="nav-item">
                                    <a href="{{ route('home')}}" class="nav-link {{ request()->is('home') ? 'active' : ''}}">
                                        <i class="fe fe-home"></i> Accueil
                                    </a>
                                </li>
                                @if(Auth::user()->usertype=="super" || Auth::user()->usertype=="admin")
                                <li class="nav-item">
                                    <a href="/capteurs" class="nav-link"><i class="fe fe-thermometer"></i> Capteurs</a>
                                </li>@endif
                                <li class="nav-item dropdown">
                                    <a href="/historiques" class="nav-link"><i class="fe fe-file-text"></i> Historiques</a>
                                </li>
                                @if(Auth::user()->usertype=="super" || Auth::user()->usertype=="admin")
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fe fe-file"></i> Interventions</a>
                                    <div class="dropdown-menu dropdown-menu-arrow">
                                    <a href="/interventions" class="dropdown-item ">Interventions</a>
                                    <a href="/type_intervs" class="dropdown-item ">Types Intervention</a>
                                    </div>
                                </li>
                                @else
                                <li class="nav-item dropdown">
                                     <a href="/interventions/create" class="nav-link"><i class="fe fe-file"></i> Interventions</a>
                                </li>
                                @endif
                              @if(Auth::user()->usertype=="super" || Auth::user()->usertype=="admin")
                                <li class="nav-item dropdown">
                                    <a href="/factures" class="nav-link"><i class="fe fe-dollar-sign"></i> Factures</a>
                                </li>@endif
                                @if(Auth::user()->usertype=="super" || Auth::user()->usertype=="admin")<li class="nav-item">
                                    <a href="/users" class="nav-link"><i class="fe fe-user"></i> Utilisateurs</a>
                                </li>@endif
                              @if(Auth::user()->usertype=="super")  <li class="nav-item">
                                    <a href="/etablissements" class="nav-link"><i class="fe fe-briefcase"></i> Établissements</a>
                                </li>@endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endauth

        <main class="py-4">
          <div class="container">
            @yield('content')
          </div>
        </main>
    </div>
    <footer class="footer" style=" background-color: #F3F3F3;
    padding-top: 10px;
    padding-bottom: 10px;
    bottom:0;
    width:100%;">
        <div class="container">
          <div class="row align-items-center flex-row-reverse">
            <div class="col-auto ml-lg-auto">
              <div class="row align-items-center">
                <div class="col-auto">
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
              Copyright © 2019 <a href=".">GCI</a>. All rights reserved.
			  <input id="etb" name="etb" type="hidden" value="{{$et['id']}}">

            </div>
          </div>
        </div>
      </footer>
</body>
</html>
