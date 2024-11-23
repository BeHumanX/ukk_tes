<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    /** @use HasFactory<\Database\Factories\BorrowFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_date',
        'return_date',
        'returned_at'
    ];
    public $timestamps = false;
    public function book(){
        return $this->belongsTo(Book::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
