<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    //
    public function index(){
        if(auth()->user()->role == 'user'){
            return response()->json(['error'=> 'You are not authorized'],403);
        }
        $borrows = Borrow::all();
        return response()->json($borrows,200);
    }

    public function borrow(Request $request){
        if(auth()->user()->role !== 'user'){
            return response()->json(['error' => 'Only user can borrow a book'],403);
        }
        $validatedData = $request->validate([
            'book_id' => 'required|exists:books,id',
            'return_date' => 'required|date',
        ]);
        $validatedData['user_id'] = auth()->id();
        $validatedData['borrow_date'] = now();
        $book = Book::findOrFail($validatedData['book_id']);
        if($book->status !== 'available'){
            return response()->json(['error' => 'Book is not available for borrowing'],400);
        }
        DB::beginTransaction();
        try{
            $book->update(['status'=>'borrowed']);
            $borrow = Borrow::create($validatedData);
            DB::commit();
            return response()->json(['borrow' => $borrow, 'book' => $book->fresh()],201);
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error'=> 'Failed to borrow book. Please try again'],500);
        }
    }
}
