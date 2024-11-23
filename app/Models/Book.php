<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;
    protected $fillable = ['title','author','publisher','year','status','category_id'];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function borrows(){
        return $this->hasMany(Borrow::class);
    }
}
