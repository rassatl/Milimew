<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categorie;
use App\Models\Testvueproduit;
use App\Models\Produit;
use App\Models\Produitfini;
use App\Models\Regroupement;
use App\Models\Panier;
use App\Models\Vwproduitdetaille;
use App\Models\Vwproduitpanieruser;
use App\Models\Vwfiltrecategorie;
use Illuminate\support\facades\Auth;

class MilimewController extends Controller
{
    public function gocat(){
        return view("categorie", ["data"=>Categorie::all()]);
    }

    public function golistprod(){
        return view("produit", ["data"=>Testvueproduit::all()]);
    }

    /*public function golistfiltre(){
        return view("filtre", ["data"=>Vwfiltrecategorie::all(), "lesfiltres"=>Vwfiltrecategorie::all()]);
    }*/
    public function golistfiltreprod($idcatfil){
        return view("filtre", ["data"=>Vwfiltrecategorie::all(), "lesfiltres"=>Vwfiltrecategorie::whereRaw('idcategorie = ?',[$idcatfil])->get()]);
    }

    public function goprod(){
        return view("produit", ["data"=>Testvueproduit::all(), "lescategories"=>Categorie::all()]);
    }
    
    public function gocatprod($idCat){
        return view("produit", ["data"=>Testvueproduit::selectByCategorie($idCat)], ["idCatego" => $idCat]);
    }
    public function goreg(){
        return view("regroupement", ["data"=>Regroupement::all(), "lesregroupements"=>Regroupement::all()]);
    }

    public function goregprod($idReg){
        return view("produit", ["data"=>Testvueproduit::selectByRegroupement($idReg)]);
    }

    public function govueprod($idProd){
        return view("ficheproduit", ["data"=>Vwproduitdetaille::whereRaw('idproduitfini = ?',[$idProd])->first(), "lesavis"=>json_decode(Vwproduitdetaille::select('listeavis')->where('idproduitfini', $idProd)->get(),true)]);
    }

    // public function govueprod($idProd){
    //     return view("ficheproduit", ["data"=>Vwproduitdetaille::whereRaw('idproduitfini = ?',[$idProd])->first(), "idpanieruser"=>(Vwproduitpanieruser::where('idclient', [Auth::user()->id])->first())->idpanier]);
    // }

    // public function getavis($idProd){
    //     $lesavis = Vwproduitdetaille::whereRaw('idproduitfini = ?',[$idProd])->listeavis;
    //     return view('ficheproduit')->with($lesavis);
    // }

    public function search(Request $request)
    {
        $search = $request['q'] ?? "";
        $s=explode(" ",$search);
        foreach($s as $mot){
            $produit = Vwproduitdetaille::where(Vwproduitdetaille::raw('lower(nom_produit)'), 'LIKE', '%'.strtolower($mot).'%')->orWhere(Vwproduitdetaille::raw('lower(libellecoloris)'), 'LIKE', '%'.strtolower($mot).'%')->get();
        }   
        $data = compact('produit', 'search');

        return view('search')->with($data, $search);
    }
    
    public function triCroissant(Request $request)
    {
        return view("produit",["data"=>Testvueproduit::orderBy('prix','asc')->get()]);        
    }

    public function triDecroissant()
    {
        return view("produit",["data"=>Testvueproduit::orderBy('prix','desc')->get()]);
    }   

}