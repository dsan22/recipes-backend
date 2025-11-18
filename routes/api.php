<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\InstructionController;
use App\Http\Controllers\RecipeCategorieController;
use App\Http\Controllers\RecipeController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



Route::apiResources([
    'recipe.ingredients'=>IngredientController::class,
    'categories' => RecipeCategorieController::class,
    'recipes' => RecipeController::class,
    'recipe.instructions'=> InstructionController::class,
]);

Route::post('/recipes/search', [RecipeController::class, 'getRecipesByIngredients']);

Route::post('/recipes/{id}/images', [RecipeController::class, 'addImage']);
Route::delete('/recipes/{recipe}/images/{image}', [RecipeController::class, 'deleteImage']);

Route::get('/my-recipes', [RecipeController::class, 'myRecipes'])->middleware('auth:sanctum');



