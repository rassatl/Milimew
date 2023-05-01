<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vwproduitdetaille;


interface PanierSession {

	// Afficher le panier
    public function gopanier(){
        return view("panier", ["data"=>Panier::all()]);
    }

	// Ajouter un produit au panier
	public function addProduct(Vwproduitdetaille $product){
        $panier = session()->get("panier"); // On récupère le panier en session

        // Les informations du produit à ajouter
		$product_details = [
			'name' => $product->nom_produit,
			'price' => $product->prix,
			'color' => $product->libellecoloris
		]; 

        $panier[$product->idproduitfini	] = $product_details; // On ajoute ou on met à jour le produit au panier
		session()->put("panier", $panier); // On enregistre le panier
    }

	// Retirer un produit du panier
	public function delProduct(Vwproduitdetaille $product){
        $panier = session()->get("panier"); // On récupère le panier en session
		unset($basket[$product->idproduitfini]); // On supprime le produit du tableau $panier
		session()->put("panier", $panier); // On enregistre le panier
    }

	// Vider le panier
	public function vide(){
        session()->forget("panier");
    }

}