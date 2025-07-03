<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libretto;

class LibrettoController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $librettos = Libretto::all();
        return response()->json($librettos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_id' => 'required|exists:authors,id'
        ]);

        $libretto = Libretto::create($request->all());
        return response()->json($libretto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $libretto = Libretto::findOrFail($id);
        return response()->json($libretto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'author_id' => 'sometimes|exists:authors,id'
        ]);

        $libretto = Libretto::findOrFail($id);
        $libretto->update($request->all());
        return response()->json($libretto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $libretto = Libretto::findOrFail($id);
        $libretto->delete();
        return response()->json(null, 204);
    }
}
