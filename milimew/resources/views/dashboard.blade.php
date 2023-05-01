{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

@extends('layouts.app')

@section('title','Mon compte')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>


<div id="phoenix">
    <h2>Compte et réglages ⚙️</h2>

    <div class="tab">
        <button class="tablinks" onclick="openSettings(event, 'Client')" id="defaultOpen" title="Voir ou modifier mes informations client">👤 Client </button>
        <button class="tablinks" onclick="openSettings(event, 'Securite')" title="Voir ou modifier mon email / mot de passe de connexion">🔑 Securité </button>
        <button class="tablinks" onclick="openSettings(event, 'Favoris')" title="Gérer mes favoris">❤️ Favoris </button>
        <button class="tablinks" onclick="openSettings(event, 'Commandes')" title="Voir l'état et l'historique de mes commandes">📦 Commandes</button>
        <button class="tablinks" onclick="openSettings(event, 'Paiement')" title="Enregistrer, modifier ou supprimer mon moyen de paiement">💳 Paiement</button>
        <button class="tablinks" onclick="openSettings(event, 'Livraison')" title="Voir ou modifier mon addresse de livraison">🚚 Livraison</button>
        <button class="tablinks" onclick="openSettings(event, 'Confidentialite')" title="Gérer mes préférences de confidentialté">✋ Confidentialité</button>
        <a href="/logout"><button class="tablinks">🚪 Déconnexion</button></a>

        
    </div>

    <div id="Client" class="tabcontent">
        <h3>👤 Client</h3>

        @if($data->avatar != null)
            <div id="profilePicture">
                <img src="{{ $data->avatar }}" alt="">
            </div>
        @else
            <div id="profilePicture">
                <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y" alt="">
            </div>
        @endif

            
            
        <form action="{{ url('storeclientupdate') }}" method="post">
            @csrf
            <p>Nom: <input type="text" id="name" name="name" autocomplete="family-name" required value="{{ $data->nom }}"></p>
            <p>Prénom: <input type="text" id="surname" name="surname" autocomplete="given-name" required value="{{ $data->prenom }}"></p>
            <p>Numéro téléphone: <input type="tel" id="tel" name="tel" autocomplete="tel" required pattern="^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$" value="{{ $data->numportable }}"></p>
{{--             <div id="newLivr">
                <input type="text" required pattern="^[1-9](?:[\s.-]*\d{2}){4}$" id="phone">
                <input type="hidden" id="tel" name="tel" value="">
            </div> --}}
            <input class="button" type="reset" value="Annuler">
            <input class="button" type="submit" value="Enregister">
        </form>
    </div>

    <div id="Securite" class="tabcontent">
        <h3>🔑 Securité </h3>
        <form action="{{ url('storesecuriteupdate') }}" method="post">
            @csrf
            <p>Email de connexion: <input type="text" id="mail" name="mail" autocomplete="email" pattern="[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+" required value="{{ $data->mail }}"></p>
        
            <input class="button" type="reset" value="Annuler">
            <input class="button" type="submit" value="Enregister">
        </form>
        <br>

        <form action="{{ url('storepasswordupdate') }}" method="post">
            @csrf
            <fieldset>
                <legend>Changer de mot de passe</legend>
                <p>Mot de passe: <input type="password" id="password" name="password" required pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{12,}$" autocomplete="new-password" maxlength="20"></p>
                
                <p>Confirmation mot de passe: <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" ></p>
                <span id='message'></span>
                <div class="infoTinyRed">
                    <p>Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.</p>
                </div>
                <input id="SavePass" class="button" type="submit" value="Enregister">
            </fieldset>
        </form>
    </div>

    <div id="Favoris" class="tabcontent">
        <h3>❤️ Favoris</h3>
        @if($lesfavoris == null)
            <p>Vous n'avez pas encore de favoris</p>
        @else                
            @foreach($lesfavoris as $favoris)
                <div class="favorisMainboxs">
                    <a href="/ficheproduit/{{$favoris["idproduitfini"]}}">
                            <img src='/{{substr(str_replace('"', "", $favoris["listeurlphoto"]), 1, -1)}}' width="150rem"/>
                    </a>
                    <div class="infofav">
                        <p>{{$favoris["nom_produit"]}}</p>
                        <p>{{$favoris["prix"]}}€ <a href="/delfav/{{$favoris["idproduitfini"]}}">❌</a></p>
                        
                    </div>
                </div>
                <hr>
            @endforeach
        @endif
    </div>

    <div id="Commandes" class="tabcontent">
        <h3>📦 Commandes</h3>
        <div>
            <h4>En cours <div class="dot"></div></h4>
            <?php use App\Models\Commande;
            $lescommandes=Commande::all(); ?>
            @php $nbdecommande = 0 @endphp
            @foreach($lescommandes as $lacommande)
                @if($data->idclient == $lacommande->idclient && $lacommande->etatcommande == null)
                    @php $nbdecommande += 1 @endphp
                    <p>Numéro de commande : {{$lacommande->idcommande}} Montant : {{$lacommande->montantcommande}}€</p>
                    <p>Date : {{$lacommande->datecommande}}</p>
                @endif
            @endforeach
            @if($nbdecommande == 0) 
                <p>Vous n'avez pas de commande en cours</p>
            @else
                <p>Nb Total de commandes : {{$nbdecommande}}</p>
            @endif
        </div>
        <div>
            <h4>Historique</h4>
            @php $nbdecommandefini = 0 @endphp
            @foreach($lescommandes as $lacommande)
                @if($data->idclient == $lacommande->idclient && $lacommande->etatcommande != null)
                    @php $nbdecommandefini += 1 @endphp
                    <p>Numéro de commande : {{$lacommande->idcommande}} Montant : {{$lacommande->montantcommande}}€</p>
                    <p>Date : {{$lacommande->datecommande}}</p>
                @endif
            @endforeach
            @if($nbdecommandefini == 0) 
                <p>Aucune commande</p>
            @endif
        </div>
    </div>

    <div id="Paiement" class="tabcontent">
        <h3>💳 Paiement</h3>
        <div class="cardbank">
            <div class="card__info">
                <div class="card__logo">MyBank</div>
                <div class="card__chip">
                    <svg class="card__chip-lines" role="img" width="20px" height="20px" viewBox="0 0 100 100" aria-label="Chip">
                        <g opacity="0.8">
                            <polyline points="0,50 35,50" fill="none" stroke="#000" stroke-width="2" />
                            <polyline points="0,20 20,20 35,35" fill="none" stroke="#000" stroke-width="2" />
                            <polyline points="50,0 50,35" fill="none" stroke="#000" stroke-width="2" />
                            <polyline points="65,35 80,20 100,20" fill="none" stroke="#000" stroke-width="2" />
                            <polyline points="100,50 65,50" fill="none" stroke="#000" stroke-width="2" />
                            <polyline points="35,35 65,35 65,65 35,65 35,35" fill="none" stroke="#000" stroke-width="2" />
                            <polyline points="0,80 20,80 35,65" fill="none" stroke="#000" stroke-width="2" />
                            <polyline points="50,100 50,65" fill="none" stroke="#000" stroke-width="2" />
                            <polyline points="65,65 80,80 100,80" fill="none" stroke="#000" stroke-width="2" />
                        </g>
                    </svg>
                    <div class="card__chip-texture"></div>
                </div>
                <div class="card__type">debit</div>
                <div class="card__number">
                    <span>{{$data->numerocarte}}</span>
                </div>
                <div class="card__valid-thru" aria-label="Valid thru">{{$data->expirationcarte}}</div>
                <div class="card__exp-date"><time datetime="2038-01">CVC {{$data->cvccarte}}</time></div>
                <div class="card__name" aria-label="Dee Stroyer">{{$data->nomcarte}}</div>
                <div class="card__vendor" role="img" aria-labelledby="card-vendor">
                    <span id="card-vendor" class="card__vendor-sr">Mastercard</span>
                </div>
            </div>
            <div class="card__texture"></div>
        </div>
        <form action="{{ url('storepaiementupdate') }}" method="post">
            @csrf
            <p>Numéro de carte: <input type="text" id="cardnumber" name="cardnumber" autocomplete="cc-number" pattern="(^4[0-9]{12}(?:[0-9]{3})?$)|(^(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}$)|(3[47][0-9]{13})|(^3(?:0[0-5]|[68][0-9])[0-9]{11}$)|(^6(?:011|5[0-9]{2})[0-9]{12}$)|(^(?:2131|1800|35\d{3})\d{11}$)" value="{{ $data->numerocarte }}" required></p>
            <p>Date d'expiration: <input type="date" id="expiration" name="expiration" autocomplete="cc-exp" required value="{{ $data->expirationcarte }}"></p>
            <p>CVC: <input type="text" id="cvc" name="cvc" autocomplete="cc-csc" required pattern="^[0-9]{2,4}$" value="{{ $data->cvccarte }}"></p>
            <p>Nom sur la carte: <input type="text" id="ccname" name="ccname" required autocomplete="cc-name" value="{{ $data->nomcarte }}"></p>
            
            <input class="button" type="reset" value="Annuler">
            <input class="button" type="submit" value="Enregister">
        </form>
    </div>

    <div id="Livraison" class="tabcontent">
        <h3>🚚 Livraison</h3>
        <form action="{{ url('storelivraisonupdate') }}" method="post">
            @csrf

            <div class="ml-4" id="fulladdr">
                <!-- Adresse -->
                <div>
                    <x-input-label for="address" :value="__('Adresse')" /> <br>
                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" required autofocus value="{{ $data->adresse }}" />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
                <div id="containeraddr">
                    <ul class='addrul'>
                    </ul>
                </div>
            </div>

            <p>Ville: 
                <input type="text" id="ville" name="ville" required autofocus readonly value="{{ $data->ville }}">
            </p>
            
            <p>Code postal: 
                <input id="codepostal" type="text" name="codepostal" required autofocus readonly value="{{ $data->codepostal }}">
            </p>

            <p>Pays: 
                <input type="text" id="pays" name="pays" autocomplete="country-name" required autofocus readonly value="{{ $data->pays }}">
            </p>
            
            <input class="button" type="reset" value="Annuler">
            <input class="button" type="submit" value="Enregister">
        </form>
    </div>

    <div id="Confidentialite" class="tabcontent">
        <h3>✋ Confidentialité</h3>
        <a class="button" href="#">Préférences cookies</a>
        <a id="butdelaccount" href="/dashboard/delconfirm">Supprimer mon compte</a>
    </div>
    
</div>

    <script>

        
        function openSettings(evt, settName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(settName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        document.getElementById("defaultOpen").click();


    // API address

    function removeAllChildNodes(parent) {
        while (parent.firstChild) {
            parent.removeChild(parent.firstChild);
        }
    }

    const savepass = document.querySelector("#SavePass");
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


    $('#SavePass').prop('disabled', true);
    savepass.style.opacity = "0.5";

    $('#password, #password_confirmation').on('keyup', function () {
        if ($('#password').val() == $('#password_confirmation').val() && $('#password').val() != '') {
            $('#message').html('Les mots de passe correspondent').css('color', 'green');
            $('#SavePass').prop('disabled', false);
            savepass.style.opacity = "1";

        } 
        else {
            $('#message').html('Les mots de passe ne correspondent pas').css('color', 'red');
            document.querySelector('#SavePass').disabled = false;
            $('#SavePass').prop('disabled', true);
            savepass.style.opacity = "0.5";


        }
    });

    const phoneInputField = document.getElementById("phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
        utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });
    const telinput = document.querySelector("#tel");
    telinput.value = phoneInput.getNumber();



    </script>
    
    
@endsection
