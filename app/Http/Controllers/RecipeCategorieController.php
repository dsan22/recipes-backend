<?php

namespace App\Http\Controllers;

use App\Models\RecipeCategorie;
use Illuminate\Http\Request;

class RecipeCategorieController extends Controller
{
    public function index()
    {
        $items = RecipeCategorie::all();
        return response()->json($items);
    }

    public function show($id)
    {
        $item = RecipeCategorie::find($id);
        return response()->json($item);
    }

    public function store(Request $request)
    {
        $item = RecipeCategorie::create($request->all());
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = RecipeCategorie::find($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    public function destroy($id)
    {
        RecipeCategorie::destroy($id);
        return response()->json(null, 204);
    }
}
