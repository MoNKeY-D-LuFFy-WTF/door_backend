<?php

use App\Http\Controllers\CatalogChildController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DoorColorController;
use App\Http\Controllers\DoorComboController;
use App\Http\Controllers\DoorController;
use App\Http\Controllers\DoorKeyController;
use App\Http\Controllers\DoorMaterialController;
use App\Http\Controllers\DoorOpenSystemController;
use App\Http\Controllers\DoorStatusController;
use App\Http\Controllers\DoorThikController;
use App\Http\Controllers\FrozenController;
use App\Http\Controllers\FurnitureController;
use App\Http\Controllers\GetProductsController;
use App\Http\Controllers\ImageCatalogController;
use App\Http\Controllers\InstalmentController;
use App\Http\Controllers\JoinUsController;
use App\Http\Controllers\MainBanerController;
use App\Http\Controllers\OrderInstalltaionController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\UserClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(MainBanerController::class)->group(function () {
    Route::get('/banners/{id}/img', 'getImg');
    Route::get('/banners', 'index');
    Route::post('/banners', 'store');
    Route::get('/banners/{id}',  'show');
    Route::patch('/banners/{id}', 'update');
    Route::delete('/banners/{id}', 'destroy');
});
Route::controller(PromotionController::class)->group(function () {
    Route::get('/promotions/{id}/img', 'getImg');
    Route::get('/promotions',  'index');
    Route::post('/promotions', 'store');
    Route::get('/promotions/{id}',  'show');
    Route::patch('/promotions/{id}', 'update');
    Route::delete('/promotions/{id}', 'destroy');
});
Route::controller(InstalmentController::class)->group(function () {
    Route::get('/instalments',  'index');
    Route::post('/instalments', 'store');
    Route::get('/instalments/{id}',  'show');
    Route::patch('/instalments/{id}', 'update');
    Route::delete('/instalments/{id}', 'destroy');
});
Route::controller(JoinUsController::class)->group(function () {
    Route::get('/join_us',  'index'); # show photos
    Route::post('/join_us', 'store'); # create photo
    Route::get('/join_us/{id}',  'show'); # show photo
    Route::patch('/join_us/{id}', 'update'); # update photo
    Route::delete('/join_us/{id}', 'destroy'); # delete photo
});
Route::controller(FrozenController::class)->group(function () {
    Route::get('/frozens',  'index');
    Route::post('/frozens', 'store');
    Route::get('/frozens/{id}',  'show');
    Route::patch('/frozens/{id}', 'update');
    Route::delete('/frozens/{id}', 'destroy');
});
Route::controller(DoorKeyController::class)->group(function () {
    Route::get('/door_keys',  'index');
    Route::post('/door_keys', 'store');
    Route::get('/door_keys/{id}',  'show');
    Route::patch('/door_keys/{id}', 'update');
    Route::delete('/door_keys/{id}', 'destroy');
});
Route::controller(OrderInstalltaionController::class)->group(function () {
    Route::get('/order_installations',  'index'); # show photos
    Route::post('/order_installations', 'store'); # create photo
    Route::get('/order_installations/{id}',  'show'); # show photo
    Route::patch('/order_installations/{id}', 'update'); # update photo
    Route::delete('/order_installations/{id}', 'destroy'); # delete photo
});
Route::controller(CatalogController::class)->group(function () {
    Route::get('/catalogs',  'index'); # show photos
    Route::post('/catalogs', 'store'); # create photo
    Route::get('/catalogs/{id}',  'show'); # show photo
    Route::patch('/catalogs/{id}', 'update'); # update photo
    Route::delete('/catalogs/{id}', 'deleted'); # update photo
    Route::delete('/catalogs/{name}/{params}', 'destroy'); # delete photo
});
Route::controller(FurnitureController::class)->group(function () {
    Route::get('/furnitures',  'index');
    Route::post('/furnitures', 'store');
    Route::get('/furnitures/{id}',  'show');
    Route::post('/furnitures/{id}', 'update');
    Route::delete('/furnitures/{id}', 'destroy');
    Route::post('/furnitures/trash/{id}', 'refresh');
});
Route::controller(GetProductsController::class)->group(function () {
    Route::get('/catalog_products/{parent_url}/{child_url}', 'getProduct'); # Modile data for get products
    Route::post('/catalog_products/basket', 'getBasketProduct'); # Modile data for get products
});
Route::controller(ImageCatalogController::class)->group(function () {
    Route::get('/images_catalog',  'index'); # show photos
    Route::post('/images_catalog', 'store'); # create photo
    Route::get('/images_catalog/{id}',  'show'); # show photo
    Route::patch('/images_catalog/{id}', 'update'); # update photo
    Route::delete('/images_catalog/{id}', 'destroy'); # delete photo
});
Route::controller(CatalogChildController::class)->group(function () {
    Route::get('/catalog_children',  'index');
    Route::get('/catalog_children/{id}',  'getCatalogChildren');
    Route::post('/catalog_children',  'store');
    Route::patch('/catalog_children/{id}',  'update');
    Route::delete('/catalog_children/{id}',  'destroy');
    Route::get('/catalog_child/furniture/{id}',  'getFurniture');
    Route::get('/catalog_child/furniture/trash/{id}',  'getFurnitureWithTrash');
});
Route::controller(DoorStatusController::class)->group(function () {
    Route::get('/door_status',  'index');
    Route::post('/door_status', 'store');
});
Route::controller(DoorMaterialController::class)->group(function () {
    Route::get('/door_materials',  'index');
    Route::post('/door_materials',  'store');
    Route::get('/door_materials/{id}/colors',  'getMaterialColors');
});
Route::controller(DoorColorController::class)->group(function () {
    Route::get('/door_colors',  'index');
    Route::post('/door_colors', 'store');
    Route::get('/door_colors/{name}/image',  'getImageColors');
});
Route::controller(DoorOpenSystemController::class)->group(function () {
    Route::get('/door_open_systems',  'index'); # show photos
    Route::post('/door_open_systems', 'store'); # create photo
});
Route::controller(DoorThikController::class)->group(function () {
    Route::get('/door_thicks',  'index'); # show photos
    Route::post('/door_thicks', 'store'); # create photo

});
Route::controller(DoorController::class)->group(function () {
    Route::get('/doors',  'index');
    Route::post('/doors', 'store');
    Route::get('/doors/materials',  'material');
    Route::get('/doors/{id}',  'show');
    Route::post('/doors/{id}/update', 'update');
    Route::delete('/doors/{id}', 'destroy');
    Route::get('/doors/get/trash/{catalogChildId}', 'trash');
    Route::post('/doors/get/trash/{id}', 'trashReturn');
    Route::get('/doors/material_doors/{material_door}/{name}', 'getDoorWithMaterial');
    Route::get('/doors/catalog_children/{catalogChildId}', 'getDoorsFromCatalogChildId');
    Route::get('/doors/{id}/catalog_child',  'getDoorsWithCatalogChildId');
    Route::post('/doors/basket',  'basket');
    Route::get('/doors/find/{name}',  'find');
});
Route::controller(UserClientController::class)->group(function () {
    Route::get('/user_clients',  'index'); # show photos
    Route::post('/user_clients', 'store'); # create photo
});
Route::controller(DoorComboController::class)->group(function () {
    Route::get('/door_combos',  'index');
    Route::post('/door_combos', 'store');
    Route::get('/door_combos/{id}',  'show');
    Route::patch('/door_combos/{id}', 'update');
    Route::delete('/door_combos/{id}', 'destroy');
    Route::post('/combo_find',  'comboFind');
});
