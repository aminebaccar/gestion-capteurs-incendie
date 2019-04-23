@extends('layouts.app')
<?php
use \App\Intervention; ?>

@section('content')
<div class="container">
          <div class="col-md-12">
          <div class="page-header">
              <h1 class="page-title">
                Dashboard
              </h1>
            </div>


                  <div class="row row-cards row-deck" style="margin: auto; align:center;">
                    <div class="col-md-6"><a href="/interventions" style="color: #495057; text-decoration: none;">
                        <div class="card">
                          <div class="card-body text-center">
                                    <div class="h5">Dernière Intervention</div>
                                    <div style="font-size:25px; font-weight:bold;">{{ $results = Intervention::latest('created_at')->first()->created_at }} </div>
                                  </div></a>
                        </div>
                    </div>
    <div class="col-md-6"><a href="/factures" style="color: #495057; text-decoration: none;">
      <div class="card">
      <div class="card-body text-center">
                <div class="h5">Montant à payer</div>
                @if (Auth::user()->usertype=="admin")
                <div class="display-4 font-weight-bold mb-4">{{ $price = DB::table('factures')->where('etab', 'like', Auth::user()->etab)->sum('montant') }} DT </div>
                @elseif (Auth::user()->usertype=="super")
                <div class="display-4 font-weight-bold mb-4">{{ $price = DB::table('factures')->sum('montant') }} DT </div>
                @endif
              </div></a>
            </div>
    </div>
</div>


        </div>

</div>

@endsection
