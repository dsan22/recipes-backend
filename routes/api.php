<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecepieCategorieController;
use App\Http\Controllers\RecepieController;
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
    'ingredients'=>IngredientController::class,
    'categories' => RecepieCategorieController::class,
    'recepies' => RecepieController::class,
]);

Route::post('/recepies/search', [RecepieController::class, 'getRecipesByIngredients']);

Route::post('/recepies/{id}/images', [RecepieController::class, 'addImage']);



