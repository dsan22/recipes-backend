<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Models\RecipeImage;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RecipeController extends Controller
{
    public function index()
    {
        $items = Recipe::all();
        return RecipeResource::collection($items);
    }

    public function show($id)
    {
        $item = Recipe::find($id);
        return new RecipeResource($item);
    }

    public function store(Request $request)
    {
        $item = Recipe::create($request->all());
        $item->ingredients()->attach($request['ingredients']);
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = Recipe::find($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    public function destroy($id)
    {
        Recipe::destroy($id);
        return response()->json(null, 204);
    }

    public function getRecipesByIngredients(Request $request)
    {
        //list of strings, names of ingrdients
        $ingredients = $request->input('ingredients');

        $recipes = Recipe::searchByIngredients($ingredients);

        return response()->json(['recipes' => $recipes]);
    }

    public function addImage(Request $request, int $recipe_id)
    {
        // Validate the request
        try {
            $validated = $request->validate([
                'image' => 'required|image|max:5120', // 5MB max
                'is_cover' => 'sometimes|boolean',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        // Store the image
        $path = $request->file('image')->store('recipe_images', 'public');

        // Save the image record
        $image = RecipeImage::create([
            'recipe_id' => $recipe_id,
            'image' => $path,
            'is_cover' => $request->input('is_cover', false),
        ]);

        return response()->json([
            'message' => 'Image uploaded successfully',
            'data' => $image,
        ], 201);
    }
}
