@extends('layouts.app')

@section('title', $data->nom_produit)
    
@section('content')
    <form>
        <input id="backButton" type="button" value="<" onclick="history.back()">
   </form>
    <div id="blocImgProduit">
        <?php 
        foreach(explode(",",  substr(str_replace('"', "", $data->listeurlphoto), 1, -1)) as $url){
            echo "<img src='/$url' />";
        }
        ?>
    </div>
    <div id="sectionTechnique">
        <div id="blocGauche">
            <h2>Description</h2>
            <p>{{$data->description}}</p>
        </div>
        <div id="blocInfoProduit2">
            <h2>Aspects techniques</h2>
            <p>{!!$data->aspecttechnique!!}</p>
            <h2>Entretien</h2>
            <p>{{$data->instructionentretien}}</p>
        </div>
    </div>
        
    <div id="sectionInfoProduit">
        <div id="blocGauche">
            <h3>{{$data->nom_produit}}</h3>
            <p>{{$data->libellecoloris}}</p>
            @if($data->libellestock == "Produit en rupture de stock")
                <p id="stockrouge">{{$data->libellestock}}</p>
            @else
                <p id="stockvert">{{$data->libellestock}}</p>
            @endif
        </div>
        <div id="blocInfoProduit">
            <h1>{{$data->prix}}€</h1>
            <a href="/ficheproduit/add/{{$data->idproduitfini}}" class="button_favoris">❤️</a>
            
            
            @if($data->libellestock != "Produit en rupture de stock")
                @if(Auth::user())
                    <a href="/panier/add/{{$data->idproduitfini}}" class="buttonAddPanier">Ajouter au panier</a>
                @else
                    <a href="/cookie/{{$data->idproduitfini}}/1/set" class="buttonAddPanier">Ajouter au panier</a>
                @endif
            @endif
        </div>
    </div>

    <div id="sectionAvis">
        <div id="headeravis">
            <h2>Avis</h2>
            {{--<h3>Note moyenne : {{$moyenne}} ⭐️</h3>--}}
        </div>
        {{--<div class="boxAvis">
            <p id="infoUser">Bob</p>
            <p>⭐️⭐️⭐️⭐️⭐️</p>
            <p>
            Et ullamco ea veniam veniam do occaecat amet est sint incididunt cillum et proident. Eiusmod cillum ullamco aliqua cupidatat ipsum non officia sunt laborum voluptate. 
            Sunt enim aute esse commodo ullamco excepteur magna minim non ut laboris dolor nulla non nisi tempor anim.
            </p>
            <p> @dump(json_decode(implode(" ",$lesavis[0]), true))</p>
        </div>--}}

        {{--@if (Count($lesavis) != 0)
            {{$lesavis = (json_decode(implode("",$lesavis[0]), true))}}
            @if($lesavis != null)--}}
            

                @foreach ((json_decode(implode("",$lesavis[0]), true)) as $avisproduit)
                    <div class="boxAvis">
                        <p id="infoUser">{{$avisproduit["prenomclient"]}}</p>
                        <p>{{$avisproduit["noteavis"]}} ⭐️</p>
                        <p>{{$avisproduit["texteavis"]}}</p>
                    </div>
                    {{--@php$somme+=$avisproduit["noteavis"]@endphp--}}
                @endforeach 


            {{--@endif
        
        @endif--}}
            {{--@php $somme = 0 @endphp--}}
            
            {{--@php $moyenne = $somme / (json_decode(implode(" ",$lesavis[0]), true)).Count@endphp--}}
        
    </div>
    {{--
    <h2>Produits Similaires</h1>
    <div>
        <?php use App\Models\Vwlisteproduit;
        $lesmemeproduits=Vwlisteproduit::all(); ?>
        {{$data->idproduitfini}}
        @foreach($lesmemeproduits as $lesprods)   
                     <p>{{$lesprods->listeidcategorie}}</p>

            @if($lesprods->idproduitfini == $data->idproduitfini)
            @endif

        @if($lesprods->idproduitfini == $data->idproduitfini)
                <div class="card">
                        <a href="/ficheproduit/{{str_replace(' ', '_', $lesprods->idproduitfini)}}">            
                            <img class="card-img-top" src="/{{explode(",",  substr(str_replace('"', "", $lesprods->listeurlphoto), 1, -1))[0]}}" alt="product card image">
                            <div class="card-body">
                                <h5 class="card-title"><b>{{$lesprods->nom_produit}} {{$lesprods->libellecoloris}}</b></h5>
                                <p>Coloris disponible : {{$lesprods->libellecoloris}}</p>
                            </div>
                            <div class="price"><b>{{$lesprods->prix}}</b> EUR</div>
                        </a>
                    </div>
                @endif
        @endforeach
    </div>--}}
    

@endsection
