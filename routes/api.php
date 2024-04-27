<?php

use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\RecipeCategoriesController;
use App\Http\Controllers\RecipesController;
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



Route::apiResources([
    'ingredients'=>IngredientsController::class,
    'categories' => RecipeCategoriesController::class,
    'recipes' => RecipesController::class,
]);

Route::post('/recipes/search', [RecipesController::class, 'getRecipesByIngredients']);