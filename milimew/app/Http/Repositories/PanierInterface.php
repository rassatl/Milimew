<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vwproduitdetaille;


interface PanierInterface {

	// Afficher le panier
    public function gopanier();

	// Ajouter un produit au panier
	public function addProduct(Vwproduitdetaille $product);

	// Retirer un produit du panier
	public function delProduct(Vwproduitdetaille $product);

	// Vider le panier
	public function vide();

}