<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecepieResource;
use App\Models\Recepie;
use App\Models\RecepieImage;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RecepieController extends Controller
{
    public function index()
    {
        $items = Recepie::all();
        return RecepieResource::collection($items);
    }

    public function show($id)
    {
        $item = Recepie::find($id);
        return new RecepieResource($item);
    }

    public function store(Request $request)
    {
        $item = Recepie::create($request->all());
        $item->ingredients()->attach($request['ingredients']);
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = Recepie::find($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    public function destroy($id)
    {
        Recepie::destroy($id);
        return response()->json(null, 204);
    }

    public function getRecipesByIngredients(Request $request)
    {
        //list of strings, names of ingrdients
        $ingredients = $request->input('ingredients');

        $recipes = Recepie::searchByIngredients($ingredients);

        return response()->json(['recipes' => $recipes]);
    }

    public function addImage(Request $request, int $recepie_id)
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
        $path = $request->file('image')->store('recepie_images', 'public');

        // Save the image record
        $image = RecepieImage::create([
            'recepie_id' => $recepie_id,
            'image' => $path,
            'is_cover' => $request->input('is_cover', false),
        ]);

        return response()->json([
            'message' => 'Image uploaded successfully',
            'data' => $image,
        ], 201);
    }
}
