<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Est_filtre_par extends Model
{
    use HasFactory;

    protected $table = 'est_filtre_par';
    protected $primaryKey = "idfiltre";
    public $timestamps = false;
}
