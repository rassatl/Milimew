<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        <link rel="stylesheet" href="/css/style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>

        <!-- head content -->
        <!-- Deferred CSS loading (recommended) -->
        <link rel="stylesheet" href="/cookiebanner/src/cookieconsent.css" media="print" onload="this.media='all'">


        

        <!-- Fonts --
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">-->

        <!-- Scripts -->
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            
            

            <!-- Page Content -->
            <main>
                

                <div class="topnav">
                <a href="/"><img id="imglogo" src="/media/logotemp.png"></a>
                    {{-- / @yield('title') --}}
                    <div class="form-rechercher">
                        <form  method="get" action="/search">
                            @csrf
                            <div>
                                <input type="search" id="maRecherche" name="q" placeholder="Rechercher sur le site…" size="30"/>
                            </div>
                        </form>
                    </div>
                    <div class="topnav-right">
                        <a href="/produit">Produit</a>       
                        @if(Auth::user())
                            <a href="/panier">Panier</a>
                        @else
                            <a href="/cookie/panier">Panier</a>
                        @endif
                        <a class="button" href="/dashboard">Mon compte</a>
                    </div>
                </div>

                <div>
                    <div>
                        <ul id="regroupe">
                        <?php use App\Models\Regroupement;
                        $lesregroupements=Regroupement::all(); ?>
                            @foreach($lesregroupements as $regroupement)
                                <li>
                                    <a href="/reg/{{$regroupement->idregroupement}}">{{$regroupement->libelleregroupement}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="navBarCat">
                        <ul id="menu">
                        <?php use App\Models\Categorie;
                        $lescategories=Categorie::all(); ?>
                        @foreach($lescategories as $categorie)
                            @if($categorie->cat_idcategorie == null)
                                <a href="/produit/{{$categorie->idcategorie}}">
                                    <li class="cat">
                                        {{$categorie->libellecategorie}} 
                                            <ul id="sousNav">
                                                @foreach($lescategories as $sous_categorie)
                                                    @if($sous_categorie->cat_idcategorie != null && $sous_categorie->cat_idcategorie == $categorie->idcategorie)
                                                        <a href="/produit/{{$sous_categorie->idcategorie}}">
                                                            <li class="sous_cat">
                                                                {{$sous_categorie->libellecategorie}}
                                                                <ul id="sous_sous_cat">
                                                                    @foreach($lescategories as $sous_sous_categorie)
                                                                        @if($sous_sous_categorie->cat_idcategorie == $sous_categorie->idcategorie)
                                                                            <a href="/produit/{{$sous_sous_categorie->idcategorie}}">
                                                                                <li class="sous_sous_cat">
                                                                                    {{$sous_sous_categorie->libellecategorie}}
                                                                                </li>
                                                                            </a>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </ul>
                                    </li>
                                </a>
                            @endif
                        @endforeach
                        </ul>
                    </div>
                    @yield('content')
                </div>
                
                {{-- https://www.w3schools.com/tags/tryit.asp?filename=tryhtml5_input_type_checkbox --}} {{-- que quand on recherche avec une categorie --}}
                <?php use App\Models\Filtre;
                $lesfiltres=Filtre::all(); ?>
                <?php use App\Models\Vwfiltrecategorie;
                $filtrePar=Vwfiltrecategorie::all(); ?>
                
                {{-- juste modifier la bdd et rajouter quel filtre appartient à quelle catégorie de produit, c'est tout  --}}
                {{--<p>idcategorie actuelle : {{$idCatego}}</p>
                <div class="navBarFiltre">  
                    <ul id="menu">
                    @foreach($lesfiltres as $filtre)
                        @if($filtre->fil_idfiltre == null || $filtre->idfiltre == $idCatego) 
                            <a href="/filtre/{{$filtre->idfiltre}}">
                                <li class="fil">
                                    {{$filtre->libellefiltre}} 
                                    <ul id="sousNav">
                                        @foreach($lesfiltres as $sous_filtres)
                                            @if($sous_filtres->fil_idfiltre != null && $sous_filtres->fil_idfiltre == $filtre->idfiltre)
                                                <a href="/filtre/{{$sous_filtres->idfiltre}}">
                                                    <li class="sous_cat">
                                                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                                        {{$sous_filtres->libellefiltre}}
                                                    </li>
                                                </a>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            </a>
                        @endif
                    @endforeach
                    </ul>
                </div>--}}

                <footer>
                </footer>
            </main>
        </div>
        <!-- body content -->
        <script defer src="/cookiebanner/src/cookieconsent.js"></script>
        <script defer src="/cookiebanner/cookieconsent-init.js"></script>
    </body>
</html>

