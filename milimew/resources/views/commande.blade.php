@extends('layouts.app')

@section('title', 'Commande')

@section('content')
    <div id="etapeDeuxLivraison">
        <h1 class="titreLivraison">Livraison</h1>
        <p class="titreLivraison">Étapes 2/3</p>
        
        <div class="containerAdresse">
            <div id="adresse">
                <h4>1 - Mon adresse de livraison actuelle :</h4>
                <p>Nom et Prenom : {{$datalivraison->nom}} {{$datalivraison->prenom}}</p>
                <p>Adresse : {{$datalivraison->adresse}}</p>
                <p>Ville : {{$datalivraison->ville}}</p>
                <p>Code Postal : {{$datalivraison->codepostal}}</p>
                <p>Pays : {{$datalivraison->pays}}</p>
                <p>Numéro de téléphone : {{$datalivraison->numportable}}</p>
            </div>
            <div id="choixLivr">
                <div>
                <h3>Types de Livraisons :</h3>
                <?php use App\Models\Typelivraison;
                    $lestypeslivraisons=Typelivraison::all(); ?>                            
                <form action="" method="post">
                @csrf
                    @foreach($lestypeslivraisons as $lalivraison)
                        <div>
                            <input type="radio" id="typeLivraison" name="livraison" value="{{$lalivraison->idtype}}">
                                {{$lalivraison->libelletypelivraison}} <br>
                                <p id="libelleCommandes">Délai de livraison : {{$lalivraison->delailivraison}} jours</p>
                            </input>
                            <input type="hidden" name="pathliv" value='{"idtype" : idtype,"idtransporteur" : idtransporteur,"idcommande" : idcommande,"instructionlivraison" : instructionlivraison,"momentlivraison" : momentlivraison}'>
                            <input type="submit" value="Submit">
                        </div>
                    @endforeach
                </form>
                <button><a href="/panier">Annuler</a></button>
                <button onClick="changeEtapes()">Validé cette étape</button>
            </div>
        </div>

    </div>

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
                        <h4>Frais de livraisons : {{ $total }} €</h4>
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
                                <input type="radio" id="typePaiement" name="typePaiements" value="{{$lemode->idmoyen}}">
                                    {{$lemode->nommoyen}} <br>
                                    <p id="libelleMoyen">{!! $lemode->descriptionmoyen !!}</p>
                                </input>
                            </div>
                        @endforeach
                        <input type="hidden" name="path" value='{"idcodepostal" : {{$datalivraison->codepostal}},"idpays" : {{$datalivraison->pays}},"idpanier" : {{$data[0]->idpanier}},"idclient" : {{$data[0]->idclient}},"idmoyen" : null,"idmoyenlivraison" : null,"idville" : {{$datalivraison->ville}},"datecommande" : "<?php echo date('Y-m-d'); ?>","montantcommande" : {{$total}},"etatcommande" : null,"adresselivraison" : "{{$datalivraison->adresse}}"}'>
                        <input type="submit" value="Submit">
                    </form>
                    <button onClick="retourEtapePreced()">Retour</button>
                    <button onClick="finalisationCommande()"><a href="/creationCommande">Validé cette étape</a></button>
                </div>
            </div>
        </div>
        <p>idcodepostal : {{$datalivraison->codepostal}} idpays : {{$datalivraison->pays}} idpanier : {{$data[0]->idpanier}} idclient : {{$data[0]->idclient}} idmoyen : <d id="typeMoyen"></d> idmoyenlivraison : <d id="typeLivr"></d> idville : {{$datalivraison->ville}} datecommande : <d id="date"></d> montantcommande : {{$total}} etatcommande : null adresselivraison : {{$datalivraison->adresse}}</p>
    </div>
    <script>
        var maintenant=new Date();
        var jour=maintenant.getDate();
        var mois=maintenant.getMonth()+1;
        var an=maintenant.getFullYear();
        document.getElementById("date").innerHTML =  an + "-" + mois + "-" + jour;

        function changeEtapes() {
            etapeDeux = document.getElementById("etapeDeuxLivraison");
            etapeTrois = document.getElementById("etapeTroisConfirmation");
            etapeDeux.style.visibility = "hidden";
            etapeTrois.style.visibility = "visible";    

            var valeur = document.querySelector('input[name=livraison]:checked').value;
            document.getElementById("typeLivr").innerHTML = valeur;
        }

        function finalisationCommande(){
            var valeur = document.querySelector('input[name=typePaiements]:checked').value;
            document.getElementById("typeMoyen").innerHTML = valeur;
        }

        function retourEtapePreced(){
            etapeDeux = document.getElementById("etapeDeuxLivraison");
            etapeTrois = document.getElementById("etapeTroisConfirmation");
            etapeDeux.style.visibility = "visible";
            etapeTrois.style.visibility = "hidden";
        }
        //Pour le téléphone : 
        //https://www.twilio.com/blog/international-phone-number-input-html-javascript
    </script>
@endsection


