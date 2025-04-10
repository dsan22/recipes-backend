<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $items = Ingredient::all();
        return response()->json($items);
    }

    public function show($id)
    {
        $item = Ingredient::find($id);
        return response()->json($item);
    }

    public function store(Request $request)
    {
        $item = Ingredient::create($request->all());
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = Ingredient::find($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    public function destroy($id)
    {
        Ingredient::destroy($id);
        return response()->json(null, 204);
    }
}
