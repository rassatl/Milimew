<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testvueproduit extends Model
{
    use HasFactory;

    protected $table = "testvueproduit";
    protected $primaryKey = "idproduitfini";
    public $timestamps = false;

    public static function selectByCategorie($idCat){
        $all = Testvueproduit::all();
        $filtered=$all->filter(function($value, $key) use ($idCat){
            $categories=substr($value->listeidcategorie,1,-1);
            $categories=explode(",",$categories);
            return in_array($idCat, $categories);
        });
        return $filtered;
    }
}
