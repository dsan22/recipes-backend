<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Models\RecipeImage;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\UpdateRecipeRequest;
use Illuminate\Support\Facades\DB;

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
            'data' => $image,
        ], 201);
    }
}
