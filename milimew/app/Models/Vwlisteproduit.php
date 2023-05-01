<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vwlisteproduit extends Model
{
    use HasFactory;

    protected $table = 'vwlisteproduit';
    protected $primaryKey = "idproduitfini";
    public $timestamps = false;
}
