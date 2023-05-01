<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\Response;

use App\Models\Vwproduitpanieruser;
use App\Models\Vwproduitdetaille;
use App\Models\Vwinfoclient;
use App\Models\Contient;
use App\Models\Panier;
use App\Models\Commande;
use App\Models\Livraison;
use Cookie;



use Illuminate\support\facades\Auth;



class PanierController extends Controller{
   
    public function gopanieruser($idPanier){
        return view("panier", ["data"=>Vwproduitpanieruser::whereRaw('idpanier = ?',[$idPanier])->get()]);
    }

    public function goCommander($idPanier){
        return view("commande", ["data"=>Vwproduitpanieruser::whereRaw('idpanier = ?',[$idPanier])->get()], ["datalivraison"=>Vwinfoclient::whereRaw('idclient = ?', [Auth::user()->id])->first()]);
    }

    /**
     * Store a new flight in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function addPan(Request $request){
        
        //dd($request->idProd);

        //crée un nouveau contient dans la table contient

        //récup l'id panier du client actuel
        $idpanieradd = Panier::where('idclient', [Auth::user()->id])->value('idpanier');

        //récupère dans panier l'idproduitfini par rapport à l'id du panier est présent
        $proddanspanier = Contient::whereRaw('idpanier = ? and idproduitfini = ?',[$idpanieradd, $request->idProd])->first();

        if($proddanspanier != null){//si oui ajouter 1
            $proddanspanier->increment('nbproduit');
        }        
        else{
            $newcontientProd = new Contient;
            $newcontientProd->idpanier = $idpanieradd;
            $newcontientProd->idproduitfini = $request->idProd;
            $newcontientProd->nbproduit = 1;
            $newcontientProd->save(); //enregistre dans la base de donnée
        }
        $d = $request->idProd;
        return view("panier", ["data"=>Vwproduitpanieruser::where('idclient', [Auth::user()->id])->get()]);

    }
    public function addLivraison(Request $request, $idPanier){
        $valuesLivraison = json_decode($request->livraison);//info idtype & momentlivraison
        $values = json_decode($request->pathliv);
        $adresseLivraison = json_decode($request->adresse);
        $lalivraison = new Livraison;
        $lalivraison->idtype = $valuesLivraison->idtype;
        $templivraison = date('Y-m-d');//valeur de base
        $templivraison = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+$valuesLivraison->momentlivraison, date("Y")));
        if($valuesLivraison->idtype == 1){
            $idtransporteur = 1;
        }
        else{
            $idtransporteur = rand(2,5);
        }           
        $lalivraison->idtransporteur = $idtransporteur;
        $lalivraison->idcommande = 100;

        if($request->instructionLivr != null){
            $lalivraison->instructionlivraison = $request->instructionLivr;
        }
        else{
            $lalivraison->instructionlivraison = "Aucunes instructions de livraison indiquées";
        }
        $lalivraison->momentlivraison = $templivraison;

        if (isset($_COOKIE['livraison'])){
            unset($_COOKIE['livraison']);
        }
        setcookie("livraison", json_encode($lalivraison), time() + 3600, '/');
        setcookie("adresse", json_encode($adresseLivraison), time() + 3600, '/');


        //$lalivraison->save();// caca car si on annule la commande la livraison sera crée dans la bdd, essayer de mettre le save dans le addCommande si possible 
        return view("validationCommande", ["data"=>Vwproduitpanieruser::whereRaw('idpanier = ?',[$idPanier])->get()], ["datalivraison"=>Vwinfoclient::whereRaw('idclient = ?', [Auth::user()->id])->first()]);
    }

    public function addCommande(Request $request){

        if(isset($_COOKIE['livraison']))
        {
            $value = json_decode($_COOKIE['livraison']);
            
            $lalivraison = new Livraison;
            $lalivraison->idtype = $value->idtype;
            $lalivraison->idtransporteur = $value->idtransporteur;
            $lalivraison->idcommande = $value->idcommande;
            $lalivraison->instructionlivraison = $value->instructionlivraison;
            $lalivraison->momentlivraison = $value->momentlivraison;
            $lalivraison->save();
            unset($_COOKIE['livraison']);

        }
        $values = json_decode($request->path);
        //9 Rue de l'Arc en Ciel
        $lacommande = new Commande;
        $lacommande->idpanier = $values->idpanier;
        $lacommande->idclient = $values->idclient;
        $lacommande->idmoyen = 1;
        $lacommande->datecommande = $values->datecommande;
        $lacommande->montantcommande = $values->montantcommande;
        $lacommande->etatcommande = null;

        if(isset($_COOKIE['adresse']))
        {
            $value = json_decode($_COOKIE['adresse']);
            
            $lacommande->adresselivraison = $value->adresse;
            $lacommande->idville = $value->ville;
            $lacommande->idcodepostal = $value->codepostal;
            $lacommande->idpays = $value->pays;

            unset($_COOKIE['adresse']);
        }

        $lacommande->save();
        Contient::whereRaw('idpanier = ?', [$lacommande->idpanier])->delete();
        return view("welcome");
    }

    public function infoCommande(Request $request, $idPanier){
        $adresse = null;
        $ville = null;
        $codepostal = null;
        $pays = null;
        return view("infoCommande",["data"=>Vwproduitpanieruser::whereRaw('idpanier = ?',[$idPanier])->get(),  "adresse"=>$adresse, "ville"=>$ville, "codepostal"=>$codepostal, "pays"=>$pays], ["datalivraison"=>Vwinfoclient::whereRaw('idclient = ?', [Auth::user()->id])->first()]);
    }
    public function modifAdres(Request $request, $idPanier){
        $adresse = $request->address;
        $ville = $request->ville;
        $codepostal = $request->codepostal;
        $pays = $request->pays;
        return view("infoCommande",["data"=>Vwproduitpanieruser::whereRaw('idpanier = ?',[$idPanier])->get(),  "adresse"=>$adresse, "ville"=>$ville, "codepostal"=>$codepostal, "pays"=>$pays], ["datalivraison"=>Vwinfoclient::whereRaw('idclient = ?', [Auth::user()->id])->first()]);
    }
    

    public function delProdPanier(Request $request){
        $idpanier = Panier::where('idclient', [Auth::user()->id])->value('idpanier');
        $prod = Contient::whereRaw('idpanier = ? and idproduitfini = ?', [$idpanier, $request->idProd])->delete();
        $d = $request->idProd;
        return view("panier", ["data"=>Vwproduitpanieruser::where('idclient', [Auth::user()->id])->get()]);
    }


    public function cookiePanierSet(Request $request){

        $newCookie = array(
            "idprod" => $request->idProd,
            "quantite" => $request->quantite
        );
        
        if (isset($_COOKIE['panier'])){

            $oldArray = json_decode($_COOKIE['panier']);
            $present= FALSE;
            foreach($oldArray as $produit)
            {
                if($produit->idprod == $request->idProd)
                {
                    $present = TRUE;
                    $produit->quantite += $request->quantite;
                }
            }
            
            if(!$present)
            {
                array_push($oldArray, $newCookie);
            }
            
            unset($_COOKIE['panier']);
            setcookie("panier", json_encode($oldArray), time() + 3600, '/');
        }
        else{
            $oldArray = array();
            array_push($oldArray, $newCookie);
            setcookie("panier", json_encode($oldArray), time() + 3600, '/');
        }
        return redirect('cookie/panier') ;
    }

    public function cookiePanierGet(Request $request){
        $response = array();
        if(isset($_COOKIE['panier']))
        {
            foreach(json_decode($_COOKIE['panier']) as $prod)
            {
                $produitcorrespondant = Vwproduitdetaille::where('idproduitfini', $prod->idprod)->first();
                $produitcorrespondant->quantite = $prod->quantite;
                array_push($response, $produitcorrespondant);
            }
        }
        return view('panierguest',['panier'=>$response]);
    }

    public function cookiePanierDel(Request $request){
        $cookieArray = json_decode($_COOKIE['panier']);
        $newCookie = array();
        foreach($cookieArray as $produit)
        {
            if($produit->idprod != $request->idProd)
            {
                array_push($newCookie, $produit);
                // unset($cookieArray[array_search($produit, json_decode(json_encode($cookieArray, true)))]);
            }
        }
        unset($_COOKIE['panier']);
        setcookie("panier", json_encode($newCookie), time() + 3600, '/');
        return redirect('/cookie/panier');
    }

    public function setquantity(Request $request){
        $affected = Contient::whereRaw('idpanier = ? and idproduitfini = ?', [$request->idpanier, $request->idproduit])->update(['nbproduit' => $request->quantite]);
        return($affected);
    }

    public function setquantitycookie(Request $request){
        $cookieArray = json_decode($_COOKIE['panier']);
        foreach($cookieArray as $produit)
        {
            if($produit->idprod == $request->idproduit)
            {
                $produit->quantite = $request->quantite;
            }
        }
        
        unset($_COOKIE['panier']);
        setcookie("panier", json_encode($cookieArray), time() + 3600, '/');
        return ($cookieArray);
    }
   
}