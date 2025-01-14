<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('category:id,name')
            ->select('id', 'title', 'author', 'publisher', 'year', 'status', 'category_id')
            ->paginate(10);
        return response()->json($books, 200);
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
            return response()->json(['error'=>'You are not authorized'],403);
        }
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:'.(date('Y')+1),
            'category_id' => 'required|exists:categories,id'
        ]);
        $book = Book::with('category')->create($validatedData);
        return response()->json($book,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
        if(auth()->user()->role == 'user'){
            return response()->json(['error'=>'You are not authorized'],403);
        }
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:'.(date('Y')+1),
            'category_id' => 'required|exists:categories,id'
        ]);
        $book->update($validatedData);
        $book->load('category');
        return response()->json($book,200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if(auth()->user()->role == 'user'){
            return response()->json(['error'=>'You are not authorized'],403);
        }
        $book->delete();
        return response()->json(null,204);
    }
}
