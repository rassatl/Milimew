<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\MilimewController;
use App\Http\Controllers\PanierController;



Route::get('/dashboard', [ClientController::class, "goinfouser"], function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/delconfirm', function () {
    return view('deleteaccountconfirm');
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/', function () {return view('welcome');});

Route::get('/stats', function () {return view('stats');});

Route::get('/about', function () {return view('about');});

Route::get('/rgpd', function () {return view('polconf');});





Route::get("/categorie", [MilimewController::class, "gocat"]);

Route::get("/produit", [MilimewController::class, "triCroissant"]);
Route::get("/produit/{idCat}", [MilimewController::class, "gocatprod"]);

Route::get("/reg/{idReg}", [MilimewController::class, "goregprod"]);


Route::get("/ficheproduit/{idProd}", [MilimewController::class, "govueprod"]);
Route::get("/ficheproduit/add/{idProd}", [ClientController::class, "addfav"])->middleware('auth');


Route::get("/search", [MilimewController::class, "search"]);

Route::get("/triCroissant", [MilimewController::class, "triCroissant"]);
Route::get("/triDecroissant", [MilimewController::class, "triDecroissant"]);

Route::get('/panier/{idPanier}', [PanierController::class, "gopanieruser"]);
Route::get("/panier/add/{idProd}", [PanierController::class, "addPan"]);
Route::get("/panier/delProdPanier/{idProd}", [PanierController::class, "delProdPanier"]);
Route::get('/confirmationCommande/{idPanier}', [PanierController::class, "goCommander"]);
Route::get("/cookie/{idProd}/{quantite}/set", [PanierController::class, "cookiePanierSet"]);
Route::get("/cookie/panier/", [PanierController::class, "cookiePanierGet"]);
Route::get("/cookie/del", [PanierController::class, "cookiePanierDel"]);
Route::get("/panier/delProdPanierCookie/{idProd}", [PanierController::class, "cookiePanierDel"]);



Route::get('/filtre/{idcatfil}', [MilimewController::class, "golistfiltreprod"]);
Route::get('/favoris', [ClientController::class, "gofavoris"])->middleware('auth');
Route::get('/reglages', [ClientController::class, "gomodfif"])->middleware('auth');
Route::get("/delfav/{idProd}", [ClientController::class, "delfav"])->middleware('auth');

Route::get('/panier', [ClientController::class, 'vwpanier']);



Route::get('/updateuser', [ClientController::class, 'updateUser'])->middleware('auth');
Route::get("/informationCommande/{idPanier}", [PanierController::class, "infoCommande"]);
Route::post("/nouvelleAdresse/{idPanier}", [PanierController::class, "modifAdres"]);
Route::post("/validationCommande/{idPanier}", [PanierController::class, "validCommande"]);
Route::post("/creationLivraison/{idPanier}", [PanierController::class, "addLivraison"]);
Route::post("/creationCommande", [PanierController::class, "addCommande"]);

Route::post('/setquantity', [PanierController::class, 'setquantity'])->name('setquantity');
Route::post('/setquantitycookie', [PanierController::class, 'setquantitycookie'])->name('setquantitycookie');
Route::post('storeclientupdate', [ClientController::class, 'clientupdate']);
Route::post('storepasswordupdate', [ClientController::class, 'passwordupdate']);
Route::post('storesecuriteupdate', [ClientController::class, 'securiteupdate']);
Route::post('storepaiementupdate', [ClientController::class, 'paiementupdate']);
Route::post('storelivraisonupdate', [ClientController::class, 'livraisonupdate']);






