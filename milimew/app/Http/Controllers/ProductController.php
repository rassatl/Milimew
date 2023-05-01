<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Vwproduitdetaille;


class ProductController extends Controller{
    public function show(Vwproduitdetaille $product)
    {
          return view("panier", compact("product"));
    }
}