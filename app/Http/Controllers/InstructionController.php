<?php

namespace App\Http\Controllers;

use App\Models\Instruction;
use App\Models\Recipe;
use Illuminate\Http\Request;

class InstructionController extends Controller
{
    public function index(Recipe $recipe)
    {
        return response()->json($recipe->instructions, 200);
    }

    public function store(Request $request, Recipe $recipe)
    {
        $instruction = $recipe->instructions()->create(
            $request->validate([
                'step' => 'required|integer',
                'instruction' => 'required|string',
            ])
        );

        return response()->json($instruction, 201);
    }

    public function show(Recipe $recipe, Instruction $instruction)
    {
        if ($instruction->recipe_id !== $recipe->id) {
            return response()->json(null, 404);
        }

        return response()->json($instruction, 200);
    }

    public function update(Request $request, Recipe $recipe, Instruction $instruction)
    {
        if ($instruction->recipe_id !== $recipe->id) {
            return response()->json(null, 404);
        }

        $instruction->update(
            $request->validate([
                'step' => 'sometimes|integer',
                'instruction' => 'sometimes|string',
            ])
        );

        return response()->json($instruction, 200);
    }

    public function destroy(Recipe $recipe, Instruction $instruction)
    {
        if ($instruction->recipe_id !== $recipe->id) {
            return response()->json(null, 404);
        }

        $instruction->delete();

        return response()->json(null, 204);
    }
}
