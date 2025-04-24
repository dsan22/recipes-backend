<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index(Recipe $recipe)
    {
        // Only fetch ingredients belonging to this recipe
        return response()->json($recipe->ingredients);
    }

    public function show(Recipe $recipe, Ingredient $ingredient)
    {
        // Optional: ensure the ingredient belongs to the recipe
        if ($ingredient->recipe_id !== $recipe->id) {
            return response()->json(['error' => 'Ingredient not found in this recipe'], 404);
        }

        return response()->json($ingredient);
    }

    public function store(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'amount' => 'nullable|string',
            'name' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $ingredient = $recipe->ingredients()->create($validated);

        return response()->json($ingredient, 201);
    }

    public function update(Request $request, Recipe $recipe, Ingredient $ingredient)
    {
        if ($ingredient->recipe_id !== $recipe->id) {
            return response()->json(['error' => 'Ingredient not found in this recipe'], 404);
        }

        $ingredient->update($request->only(['amount', 'name', 'notes']));

        return response()->json($ingredient);
    }

    public function destroy(Recipe $recipe, Ingredient $ingredient)
    {
        if ($ingredient->recipe_id !== $recipe->id) {
            return response()->json(['error' => 'Ingredient not found in this recipe'], 404);
        }

        $ingredient->delete();

        return response()->json(null, 204);
    }
}
