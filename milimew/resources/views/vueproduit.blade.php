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
            <form method="POST" action="#" >
					{{ csrf_field() }}
                    <a href="#" class="button_favoris">❤️</a>
                    <a href="#" type="submit" class="buttonAddPanier">Ajouter au panier</a>
			</form>
        </div>
    </div>

    <div id="sectionAvis">
        <div id="headeravis">
            <h2>Avis</h2>
            <h3>Note moyenne : 4.9 ⭐️</h3>
        </div>
        <div class="boxAvis">
            <p id="infoUser">Bob</p>
            <p>⭐️⭐️⭐️⭐️⭐️</p>
            <p>
            Et ullamco ea veniam veniam do occaecat amet est sint incididunt cillum et proident. Eiusmod cillum ullamco aliqua cupidatat ipsum non officia sunt laborum voluptate. 
            Sunt enim aute esse commodo ullamco excepteur magna minim non ut laboris dolor nulla non nisi tempor anim.
            </p>
        </div>  

{{--         @foreach ($data as $avisproduit)
            <div class="boxAvis">
                <p id="infoUser">{{$avisproduit->prenom}}</p>
                <p>{{$avisproduit->note}}</p>
                <p>{{$avisproduit->commentaire}}</p>
            </div>
        @endforeach --}}
    </div>
    

@endsection
