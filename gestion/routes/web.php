<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProviderController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('prueba',function(){
    
    $categoria =Category::all();
    return $categoria;

});
Route::resource('almacen/categoria',CategoryController::class);
Route::resource('almacen/articulo',ItemController::class);
Route::resource('ventas/cliente',ClientController::class);
Route::resource('compras/proveedor',ProviderController::class);
Route::resource('compras/ingreso',IncomeController::class);