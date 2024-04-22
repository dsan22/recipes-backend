<?php

namespace App\Http\Controllers;

use App\Models\RecipeCategories;
use Illuminate\Http\Request;

class RecipeCategoriesController extends Controller
{
    public function index()
    {
        $items = RecipeCategories::all();
        return response()->json($items);
    }

    public function show($id)
    {
        $item = RecipeCategories::find($id);
        return response()->json($item);
    }

    public function store(Request $request)
    {
        $item = RecipeCategories::create($request->all());
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = RecipeCategories::find($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    public function destroy($id)
    {
        RecipeCategories::destroy($id);
        return response()->json(null, 204);
    }
}
