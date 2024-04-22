<?php

use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\RecipeCategoriesController;
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
/*  Ingredients  */
Route::get('/ingredients', [IngredientsController::class, 'index']);
Route::get('/ingredients/{id}', [IngredientsController::class, 'show']);
Route::post('/ingredients', [IngredientsController::class, 'store']);
Route::put('/ingredients/{id}', [IngredientsController::class, 'update']);
Route::delete('/ingredients/{id}', [IngredientsController::class, 'destroy']);

/*  Recipe Categories  */
Route::get('/categories', [RecipeCategoriesController::class, 'index']);
Route::get('/categories/{id}', [RecipeCategoriesController::class, 'show']);
Route::post('/categories', [RecipeCategoriesController::class, 'store']);
Route::put('/categories/{id}', [RecipeCategoriesController::class, 'update']);
Route::delete('/categories/{id}', [RecipeCategoriesController::class, 'destroy']);

