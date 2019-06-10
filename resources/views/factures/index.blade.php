@extends('layouts.app')
@php use App\Etablissement; @endphp
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

<div class="card"style="width:90%; margin: auto;">
  <div class="card-header">
    <p style="font-size:20px">Factures
      @if(Auth::user()->usertype=="super")<span class="float-right" >@handheld<a href="factures/create" style="font-size:14px;" class="btn btn-outline-secondary btn-sm" >+</a>
    @elsehandheld <a href="factures/create" style="font-size:14px;" class="btn btn-outline-secondary btn-sm" >Ajouter Facture +</a>@endhandheld</span>
  @endif
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
                          @php $etab= Etablissement::find($facture['etab']); @endphp
                        @if ($facture['etab']==Auth::user()->etab || Auth::user()->usertype=="super")
                        <tr>
                          <td><span class="text-muted">{{$facture->id}}</span></td>
                          <td>{{$facture->quantite}}</td>
                          <td>
                            {{$facture->montant}} DT
                          </td>
                          @if(Auth::user()->usertype=="super")
                          <td>
                            {{$etab['nom']}}
                          </td>
                          @endif
                          <td>

                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="JCKJ8DH6XQC2S">
                            <input type="image" src="https://www.paypalobjects.com/fr_XC/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                            <img alt="" border="0" src="https://www.paypalobjects.com/fr_XC/i/scr/pixel.gif" width="1" height="1">
                            </form>
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
