@extends('layouts.app')

@section('title', 'Mon Panier')

@section('content')
    @if(Count($data) != 0)
        <div id="containerPanier">
            <div id="panier">
                <h2>Mon Panier</h2>
                <hr>
                @php $total = 0 @endphp
                @foreach ($data as $panier)
                    @php $total += $panier['prix'] * $panier['nbproduit'] @endphp
                        <div class="productCart">
                            <div class="productinfo">
                                <div id="gauche">
                                    <img class="photopanier" src="/{{explode(",",  substr(str_replace('"', "", $panier->listeurlphoto), 1, -1))[0]}}" alt="panier product image">
                                </div>
                                <div id="droit">
                                    <p>Titre : {{ $panier['nom_produit'] }}</p>
                                    <p>Couleur : {{ $panier['libellecoloris'] }}</p>
                                </div>
                            </div>
                            <div id="div{{$panier['idproduitfini']}}">
                                <div id="blocquantite">
                                    <p>Quantité :</p>
                                    <p id="labelquantite">x{{ $panier['nbproduit'] }}</p>
                                    <select class="selectquantite" name="myDropDown" onchange="changeQuantity({{$panier['idproduitfini']}}, {{$panier['idpanier']}})">
                                        @for($i = 1; $i <= $panier->stockproduit ; $i++)
                                            <option id={{$i}} value={{$i}}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <p>Prix : <span id="prixproduit">{{ $panier['prix'] }}</span> € <a href="/panier/delProdPanier/{{$panier['idproduitfini']}}">❌</a></p>
                            </div>
                        </div>
                        <hr>
                @endforeach
            </div>
            <div id="Payer">
                <h2>Résumé de a commande : </h2>
                <div id="soustot">
                    <p id="soustotGauche">Sous total :</p>
                    <p id="soustotDroit"><span id="prixtot">{{ $total }}</span>€</p>
                </div>
                <a href="/informationCommande/{{$panier['idpanier']}}" id="boutonValiderCmd">Valider ma commande</a>            </div>
        </div>
    @else
        <h1>Aucuns produits présent dans le panier</h1>
    @endif
    <script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function changeQuantity(id, panier){
        console.log(id);
        console.log(document.getElementById('div'+id));
        const quantite = document.getElementById('div'+id).querySelector(".selectquantite").value;
        console.log(quantite);
        console.log(panier);
        const prixprod = document.getElementById('prixproduit').innerHTML;
        console.log(prixprod);
        const lesprodprixtot = document.getElementById('prixtot');
        lesprodprixtot.innerHTML = prixprod * quantite;

        $.ajax({
        type:'POST',
        url:"{{ route('setquantity') }}",
        data:{quantite:quantite, idpanier:panier, idproduit:id},
        success:function(data){
            
            const card = document.getElementById('div'+id);
            const label =card.querySelector("#labelquantite");
            label.innerHTML = "x"+quantite;
            const option = card.querySelector(".selectquantite");
            option.selected = quantite;
                                
        },
        error:function(data){
            console.log('error');
        }
        });


    }
</script>
@endsection




