<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vwproduitpanieruser extends Model
{
    use HasFactory;

    protected $table = 'Vwproduitpanieruser';
    protected $primaryKey = "idpanier";
    public $timestamps = false;
}
