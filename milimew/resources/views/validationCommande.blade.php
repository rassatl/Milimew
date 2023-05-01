@extends('layouts.app')

@section('title', 'Commande')

@section('content')
    <div id="etapeTroisConfirmation">
        <h1 class="titreLivraison">Confirmation Commande</h1>
        <p class="titreLivraison">Étapes 3/3</p>

        <div id="containerEtapeTrois">
            <div id="resumeCommande">
                @php $total = 0 @endphp
                <div class="resumePanier">
                    @foreach ($data as $panier)
                        @php $total += $panier['prix'] * $panier['nbproduit'] @endphp
                            <div class="productCart">
                                <div class="productinfo">
                                    <div id="gauche">
                                        <img class="photopanier" src="/{{explode(",",  substr(str_replace('"',"", $panier->listeurlphoto), 1, -1))[0]}}" alt="panier product image">
                                    </div>
                                    <div id="droit">
                                        <p>Titre : {{ $panier['nom_produit'] }}</p>
                                        <p>Couleur : {{ $panier['libellecoloris'] }}</p>
                                    </div>
                                </div>
                                <div id="div{{$panier['idproduitfini']}}">
                                    <p id="labelquantite">x{{ $panier['nbproduit'] }}</p>
                                    
                                    <p>{{ $panier['prix'] }} €</p>
                                </div>
                            </div>
                            <hr>
                    @endforeach
                    <div id="prixCommande">
                        <h4>Total des articles (Prix initial) : {{ $total }} €</h4>
                        <h4>Frais de livraisons : 0.00 €</h4>
                        <h3>Total : {{ $total }} €</h3>
                    </div>
                </div>
            </div>
            <div class="resumePanier">
                <div id="choixPaiement">
                    <h3>Types de Paiements :</h3>
                    <?php use App\Models\Moyen_paiement;
                    $lesmoyenspaiements=Moyen_paiement::all(); ?>
                    <form action="/creationCommande" method="post">
                    @csrf
                        @foreach($lesmoyenspaiements as $lemode)
                            <div>
                                <input type="radio" id="typePaiement" required name="typePaiements" value="{{$lemode->idmoyen}}">
                                    {{$lemode->nommoyen}} <br>
                                    <p id="libelleMoyen">{!! $lemode->descriptionmoyen !!}</p>
                                </input>
                            </div>
                        @endforeach
                        <input type="hidden" name="path" value='{"idcodepostal" : "{{$datalivraison->codepostal}}","idpays" : "{{$datalivraison->pays}}","idpanier" : {{$data[0]->idpanier}},"idclient" : {{$data[0]->idclient}},"idmoyen" : null,"idmoyenlivraison" : null,"idville" : "{{$datalivraison->ville}}","datecommande" : "<?php echo date('Y-m-d'); ?>","montantcommande" : {{$total}},"etatcommande" : null,"adresselivraison" : "{{$datalivraison->adresse}}"}'>
                        <button><a href="/informationCommande/{{$data[0]->idpanier}}">Retour</a></button>
                        <input type="submit" value="Confirmer ma commande">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        //Pour le téléphone : 
        //https://www.twilio.com/blog/international-phone-number-input-html-javascript
    </script>
@endsection


