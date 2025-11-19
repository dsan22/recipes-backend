<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Http\Resources\ImageResource;
use App\Models\Recipe;
use App\Models\RecipeImage;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\UpdateRecipeRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        return response()->json($item, 201);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        DB::transaction(function () use ($recipe, $request) {

            // --- Update main recipe fields ---
            $recipe->update($request->only(['name', 'description']));

            // --- INGREDIENTS ---
            $existingIngredientIds = [];

            foreach ($request->ingredients ?? [] as $ingredientData) {
                if (isset($ingredientData['id'])) {
                    $ingredient = $recipe->ingredients()->find($ingredientData['id']);
                    if ($ingredient) {
                        $ingredient->update([
                            'name' => $ingredientData['name'],
                            'amount' => $ingredientData['amount'],
                        ]);
                        $existingIngredientIds[] = $ingredient->id;
                    }
                } else {
                    $new = $recipe->ingredients()->create([
                        'name' => $ingredientData['name'],
                        'amount' => $ingredientData['amount'],
                    ]);
                    $existingIngredientIds[] = $new->id;
                }
            }

            // Delete removed ingredients
            $recipe->ingredients()
                ->whereNotIn('id', $existingIngredientIds)
                ->delete();


            // --- INSTRUCTIONS ---
            $existingInstructionIds = [];

            foreach ($request->instructions ?? [] as $instructionData) {
                if (isset($instructionData['id'])) {
                    $instruction = $recipe->instructions()->find($instructionData['id']);
                    if ($instruction) {
                        $instruction->update([
                            'instruction' => $instructionData['instruction'],
                            'step' => $instructionData['step'],
                        ]);
                        $existingInstructionIds[] = $instruction->id;
                    }
                } else {
                    $new = $recipe->instructions()->create([
                        'instruction' => $instructionData['instruction'],
                        'step' => $instructionData['step'],
                    ]);
                    $existingInstructionIds[] = $new->id;
                }
            }

            // Delete removed instructions
            $recipe->instructions()
                ->whereNotIn('id', $existingInstructionIds)
                ->delete();
        });

        return new RecipeResource($recipe->fresh('ingredients', 'instructions'));
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
            'data' => new ImageResource($image),
        ], 201);
    }

    public function updateImageCover(Request $request, int $recipe_id, int $image_id)
    {
        // Validate the incoming field
        $validated = $request->validate([
            'is_cover' => 'required|boolean',
        ]);

        // Find the image
        $image = RecipeImage::where('recipe_id', $recipe_id)
            ->where('id', $image_id)
            ->first();

        if (!$image) {
            return response()->json([
                'message' => 'Image not found for this recipe.'
            ], 404);
        }

        // If setting this image as cover, remove cover from others
       /* if ($validated['is_cover']) {
            RecipeImage::where('recipe_id', $recipe_id)
                ->update(['is_cover' => false]);
        }*/

        // Update selected image
        $image->update([
            'is_cover' => $validated['is_cover']
        ]);

        return response()->json([
            'message' => 'Image cover status updated.',
            'data' => $image
        ]);
    }


    public function myRecipes()
    {
        // Ensure the user is authenticated
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Fetch only recipes belonging to this user
        $recipes = Recipe::where('user_id', $user->id)
            ->with(['ingredients', 'instructions'])
            ->latest()
            ->get();

        // Return the recipes wrapped in the resource collection
        return RecipeResource::collection($recipes);
    }
}
