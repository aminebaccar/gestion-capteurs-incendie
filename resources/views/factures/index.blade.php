@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 20px;
  }
</style>
<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif

<div class="card"style="width:90%; margin: auto;">
  <div class="card-header">
    <p style="font-size:20px">Factures
    </p>
  </div>
                  <div class="table-responsive">
                    <div class="container">
                    <table id="id" class="table card-table table-vcenter text-nowrap" style="margin: auto;
  width: 100%;
  padding: 10px;" >
                      <thead>
                        <tr>
                          <th class="w-1">ID.</th>
                          <th>Quantité</th>
                          <th>Montant</th>
                          @if (Auth::user()->usertype=="super")  <th>Etablissement</th> @endif
                          <th>Paiement</th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach($factures as $facture)
                        @if ($facture['etab']==Auth::user()->etab || Auth::user()->usertype=="super")
                        <tr>
                          <td><span class="text-muted">{{$facture->id}}</span></td>
                          <td>{{$facture->quantite}}</td>
                          <td>
                            {{$facture->montant}}
                          </td>
                          @if(Auth::user()->usertype=="super")
                          <td>
                            {{$facture['etab']}}
                          </td>
                          @endif
                          <td>

                              <a href="https://www.google.com/" class="btn btn-outline-primary"> Payer</a>

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
