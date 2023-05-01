@extends('layouts.app')

@section('title', 'Produit')
<script>
    function nav()
    {
        var w = document.formtri.tri.selectedIndex;
        var url_add = document.formtri.tri.options[w].value;
        window.location.href = url_add;
    }

</script>
@section('content')
    <h3>{{Count($data)}} produits </h3>
    @if(Count($data) != 0)
        <form name="formtri"action="#" method="post">
        @csrf
            <select name="tri" id="tri" onChange="nav()">
                <option selected disabled value="">Trier Par :</option>
                <option value="/triCroissant">Prix Croissant</option>
                <option value="/triDecroissant">Prix Décroissant</option>
            </select>
        </form>
    @else
        <h3>Aucun produit n'a été trouvé pour cette catégorie</h3>
    @endif 

        <div class="container">
            @foreach($data as $leproduit)
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
        {{-- <h1>zerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr</h1>
        @foreach($data as $each_article)
            <div class="card">
                    <a href="/ficheproduit/{{str_replace(' ', '_', $each_article->idproduitfini)}}">            
                    <img class="card-img-top" src="/{{explode(",",  substr(str_replace('"', "", $each_article->listeurlphoto), 1, -1))[0]}}" alt="product card image">
                    <div class="card-body">                            <h5 class="card-title"><b>{{$each_article->nom_produit}} {{$each_article->libellecoloris}}</b></h5>
                        <p>Coloris disponible : {{$each_article->libellecoloris}}</p>
                    </div>
                    <div class="price"><b>{{$each_article->prix}}</b> EUR</div>
                </a>
            </div>        
        @endforeach --}}
@endsection


