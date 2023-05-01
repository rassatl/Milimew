@extends('layouts.app')

@section('title','Categorie')

@section('content')
<h1>petit zouzou</h1>

<!--Mes categorie sont :<b> {{$data}} </b>
<div class="navBarCat">
    <ul id="menu">
    @foreach($data as $categorie)
        @if($categorie->cat_idcategorie == null)
            <li class="cat">{{$categorie->libellecategorie}}
                <ul id="sousNav">
                    @foreach($data as $sous_categorie)
                        @if($sous_categorie->cat_idcategorie != null && $sous_categorie->cat_idcategorie == $categorie->idcategorie)
                            <li class="sous_cat">{{$sous_categorie->libellecategorie}}
                                <ul id="sous_sous_cat">
                                    @foreach($data as $sous_sous_categorie)
                                        @if($sous_sous_categorie->cat_idcategorie == $sous_categorie->idcategorie)
                                            <li class="sous_sous_cat">{{$sous_sous_categorie->libellecategorie}}
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @endif
        
      
    @endforeach
    </ul>
</div>
 -->
<script>
    const findOverflows = (element) => {
        const documentWidth = document.documentElement.offsetWidth;
        const box = element.getBoundingClientRect();

        if (box.left < 0 || box.right > documentWidth) {
            return documentWidth - box.right;
        }

        return false;
    };

    const checkOverflows = () => {
        const menu = document.getElementById("menu");
        const menuItems = menu?.querySelectorAll(".cat #sousNav");

        console.log("ok")

        menuItems?.forEach((item) => {
            var overflow = findOverflows(item);
            if (overflow) {
                item.style.left = overflow + "px";
            }
        });
    };
    
    checkOverflows();
</script>
@endsection
