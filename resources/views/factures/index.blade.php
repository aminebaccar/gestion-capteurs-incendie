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

  @isset($_GET['success'])
   @if($_GET['success']!="")
    <div class="alert alert-success">
      {{ $_GET['success']}}
    </div><br />
   @endif
  @endisset

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

                            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <!-- Identify your business so that you can collect the payments. -->
        <input type="hidden" name="business" value="besrour_2010@live.com"> <!-- Add your PayPal Seller/Business email address Required-->
        <!-- Specify a Buy Now button. -->
        <input type="hidden" name="cmd" value="_xclick">
        <!-- Specify details about the item that buyers will purchase. -->
        <input type="hidden" name="item_name" value="Pack SMS"> <!-- Add Description e.g your room type Required-->
        <input type="hidden" name="amount" value="{{$facture->montant}}"> <!-- Dynamically add Total Amount Required-->
        <input type="hidden" name="currency_code" value="EUR"> <!-- Update to your currency -->
        <input id="invoice" type="hidden" value="" name="invoice"> <!-- Add Unique invoice for each transaction -->
        <input type="hidden" name="notify_url" value="https://gestioncapteursincendie.herokuapp.com/ipn/ipn.php'"> <!-- Please add IPN URL You can use this service to automate back-office and administrative functions, including fulfilling orders, tracking customers, and providing status and other information related to transactions. -->
        <input type="hidden" name="idFacture" value="{{$facture->id}}">
		<input type='hidden' name='cancel_return' value='' /> <!-- Take customers to this URL when they cancel their checkout -->
        <input type='hidden' name='return' value='' /> <!-- Take customers to this URL when they finish their checkout  -->
        <!-- Display the payment button. -->
        <button type="submit" name="submit" class="btn btn-pill btn-warning"><i class="fa fa-facebook" data-toggle="tooltip" title="payment payment-paypal-dark"></i>Payer</button>
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
