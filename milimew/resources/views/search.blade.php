@extends('layouts.app')

@section('title', 'Produit')

@section('content')
    @if(Count($produit) != 0)
            <h3>{{Count($produit)}} produits </h3>
            <p>Resultats pour la recherche : "{{$search}}"</p>
            <div class="container">
                @foreach($produit as $leproduit)
                        <div class="card">
                            <a href="/ficheproduit/{{str_replace(' ', '_', $leproduit->idproduitfini)}}">            
                                <img class="card-img-top" src="/{{explode(",",  substr(str_replace('"', "", $leproduit->listeurlphoto), 1, -1))[0]}}" alt="product card image">
                                <div class="card-body">
                                    <h5 class="card-title"><b>{{$leproduit->nom_produit}} {{$leproduit->libellecoloris}}</b></h5>
                                    <p>Coloris disponible : {{$leproduit->libellecoloris}}</p>
                                </div>
                                <div class="price"><b>{{$leproduit->prix}}</b> EUR</div>
                            </a>
                        </div>
                @endforeach
            </div>
    @else
        <h3>Aucuns produit n'a été trouvé pour la recherche "{{$search}}"</h3>   
    @endif
@endsection
