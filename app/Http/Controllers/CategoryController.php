<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();
        return response()->json($categories,200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if(auth()->user()->role == 'user'){
            return response()->json(['error' => 'Your not authorized'],403);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $category = Category::create($validatedData);
        return response()->json($category,201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if(auth()->user()->role == 'user'){
            return response()->json(['error'=>'You are not authorized'],403);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $category->update($validatedData);
        return response()->json($category,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(null,204);
    }
}
