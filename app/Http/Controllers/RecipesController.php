<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Models\Recipes;
use Illuminate\Http\Request;

class RecipesController extends Controller
{
    public function index()
    {
        $items = Recipes::all();
        return RecipeResource::collection($items);
    }

    public function show($id)
    {
        $item = Recipes::find($id);
        return RecipeResource::collection($item);
    }

    public function store(Request $request)
    {
        $item = Recipes::create($request->all());
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = Recipes::find($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    public function destroy($id)
    {
        Recipes::destroy($id);
        return response()->json(null, 204);
    }

    public function getRecipesByIngredients(Request $request)
    {
        //list of strings, names of ingrdients
        $ingredients = $request->input('ingredients');

        $recipes = Recipes::searchByIngredients($ingredients);

        return response()->json(['recipes' => $recipes]);
    }
}
