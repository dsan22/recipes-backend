<?php

namespace App\Http\Controllers;

use App\Models\RecepieCategorie;
use Illuminate\Http\Request;

class RecepieCategorieController extends Controller
{
    public function index()
    {
        $items = RecepieCategorie::all();
        return response()->json($items);
    }

    public function show($id)
    {
        $item = RecepieCategorie::find($id);
        return response()->json($item);
    }

    public function store(Request $request)
    {
        $item = RecepieCategorie::create($request->all());
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = RecepieCategorie::find($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    public function destroy($id)
    {
        RecepieCategorie::destroy($id);
        return response()->json(null, 204);
    }
}
