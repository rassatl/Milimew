@extends('layouts.app')

@section('title', 'Commande')

@section('content')
    <script>
        function hide()
        {
            document.getElementById("blocNewAdresse").style.visibility = "hidden";
        }
        function show()
        {
            document.getElementById("blocNewAdresse").style.visibility = "visible";
        }
    </script>
    <div id="etapeDeuxLivraison">
        <h1 class="titreLivraison">Livraison</h1>
        <p class="titreLivraison">Étapes 2/3</p>
        
        <div class="containerAdresse">
            <div id="adresse">
                <div id="blocOldAdresse">
                    <h4>1 - Mon adresse de livraison actuelle :</h4>
                    <p>Nom et Prenom : {{$datalivraison->nom}} {{$datalivraison->prenom}}</p>
                    @if($adresse == null)
                        <p>Adresse : {{$datalivraison->adresse}}</p>
                        <p>Ville : {{$datalivraison->ville}}</p>
                        <p>Code Postal : {{$datalivraison->codepostal}}</p>
                        <p>Pays : {{$datalivraison->pays}}</p>
                    @else
                        <p>Adresse : {{$adresse}}</p>
                        <p>Ville : {{$ville}}</p>
                        <p>Code Postal : {{$codepostal}}</p>
                        <p>Pays : {{$pays}}</p>
                    @endif
                    <p>Numéro de téléphone : {{$datalivraison->numportable}}</p>

                    <button onclick="show()">Changer mon adresse de livraison</button>
                </div>
                <div id="blocNewAdresse">
                    <form action="/nouvelleAdresse/{{$data[0]['idpanier']}}" method="post">
                        @csrf
                        <div class="ml-4" id="fulladdr">
                            <!-- Adresse -->
                            <div>
                                <x-input-label for="address" :value="__('Nouvelle Adresse')" /> <br>
                                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" required autofocus value="{{ $datalivraison->adresse }}" />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                            <div id="containeraddr">
                                <ul class='addrul'>
                                </ul>
                            </div>
                        </div>

                        <p>Ville: 
                            <input type="text" id="ville" name="ville" required autofocus readonly value="{{ $datalivraison->ville }}">
                        </p>
                        
                        <p>Code postal: 
                            <input id="codepostal" type="text" name="codepostal" required autofocus readonly value="{{ $datalivraison->codepostal }}">
                        </p>

                        <p>Pays: 
                            <input type="text" id="pays" name="pays" autocomplete="country-name" required autofocus readonly value="{{ $datalivraison->pays }}">
                        </p>
                        
                        <input class="button" type="reset" value="Annuler" onclick="hide()">
                        <input class="button" type="submit" value="Enregister ma nouvelle adresse" onclick="hide()">
                    </form>
                </div>
            </div>
            <div id="choixLivr">
                <div>
                <h3>Types de Livraisons :</h3>
                <?php use App\Models\Typelivraison;
                    $lestypeslivraisons=Typelivraison::all(); ?>                            
                <form action="/creationLivraison/{{$data[0]['idpanier']}}" method="post">
                @csrf
                    @foreach($lestypeslivraisons as $lalivraison)
                        <div>
                            <input type="radio" id="typeLivraison" required name="livraison" value='{"idtype" : {{$lalivraison->idtype}}, "momentlivraison" : {{$lalivraison->delailivraison}}}'>
                                {{$lalivraison->libelletypelivraison}}<font color="red">*</font><br>
                                <p id="libelleCommandes">Délai de livraison avant : {{$lalivraison->delailivraison}} jours</p>
                            </input>
                        </div>
                    @endforeach
                    <p>Instructions de livraison : </p>
                    <input type="text" name="instructionLivr">
                    <input type="hidden" name="pathliv" value='{"idtype" : {{$lalivraison->idtype}},"idcommande" : null, "momentlivraison" : {{$lalivraison->delailivraison}}}'>
                    @if($adresse == null)
                        <input type="hidden" name="adresse" value='{"adresse" : "{{$datalivraison->adresse}}","ville" : "{{$datalivraison->ville}}", "codepostal" : {{$datalivraison->codepostal}}, "pays" : "{{$datalivraison->pays}}"}'>
                    @else
                        <input type="hidden" name="adresse" value='{"adresse" : "{{$adresse}}","ville" : "{{$ville}}", "codepostal" : {{$codepostal}}, "pays" : "{{$pays}}"}'>
                    @endif
                    <button><a href="/panier">Annuler</a></button>
                    <input type="submit" value="Valider cette étape">
                </form>
            </div>
        </div>
    </div>

    <div>
        <p><font color="red">*</font> Pour les <b>livraison à domicile</b> la société "France Express" s'occupera de votre commande prioritaires, celle-ci arrivera sous 2 jours.</p>
        <p><font color="red">*</font> Pour <b>toutes autres commandes</b>, ce sera les sociétés "Geodis", "Trusk", "Heppner" et "Chronopost" qui s'occuperont de vous livrer, cependant le délai de livraison peut varier de 2 à 5 jours.</p>
    </div>

    <script type="text/javascript">

    function removeAllChildNodes(parent) {
        while (parent.firstChild) {
            parent.removeChild(parent.firstChild);
        }
    }

    const fullAddr = document.querySelector("#fulladdr");
    const inputAddress = document.querySelector('#address');
    const listeaddr = document.querySelector('.addrul');
    const inputCountry = document.querySelector('#pays');
    const inputCodePostal = document.querySelector('#codepostal');
    const inputVille = document.querySelector('#ville');

    inputAddress.addEventListener("input", function(e){
        e.preventDefault();

        const recherche = $('#address').val();

        $.ajax({
        url:"https://api.geoapify.com/v1/geocode/autocomplete?text="+recherche+"&format=json&apiKey=83f879692763453987787c381bb1f6c5",
        success:function(data){
            removeAllChildNodes(listeaddr);
            data['results'].forEach(resultat => {
                console.log(resultat);
                const uneoption = document.createElement('li');
                uneoption.innerText = resultat['formatted'];
                uneoption.addEventListener('click', function(event){
                    event.preventDefault();
                    console.log(event.target);
                    console.log('click');
                    inputCountry.value = resultat['country'];
                    inputCodePostal.value = resultat['postcode'];
                    inputVille.value= resultat['city'];
                    inputAddress.value = resultat['address_line1'];
                    listeaddr.style.visibility = 'hidden';
                });
                listeaddr.appendChild(uneoption);
            });
                                    
                                
        },
        error:function(data){
            console.log(data);
        }
        });

    });

    $('#fulladdr').focusin(function(e){
        e.preventDefault();
	
        console.log('entre');
        listeaddr.style.visibility = 'visible';
    });

    $('#fulladdr').focusout(function(e){
	setTimeout(_ => {
        e.preventDefault();

        console.log(e.target);
        console.log('sort');
        listeaddr.style.visibility = 'hidden';
	}, 100)
    });

    
    </script>
@endsection


