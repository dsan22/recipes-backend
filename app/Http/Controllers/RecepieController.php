<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecepieResource;
use App\Models\Recepie;
use Illuminate\Http\Request;

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
        return RecepieResource::collection($item);
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
}
