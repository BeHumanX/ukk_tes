<?php

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function(){
    $this->adminUser = User::factory()->create(['role' => 'admin']);
    $this->normalUser = User::factory()->create(['role'=>'user']);
    $this->category = Category::factory()->create();
});

it('return all books with pagination', function(){
        Book::factory()->count(20)->create();
    $response = $this->getJson('/api/books');
    $response->assertStatus(200)->assertJsonStructure([
        'current_page',
        'data'=>[
            '*'=>[
                'title',
                'author',
                'publisher',
                'year',
                'status',
                'category_id'
            ]
        ]
    ]);
});
it('create a book',function(){
    $bookData = [
        'title' => 'name',
        'author' => 'author',
        'publisher' => 'publisher',
        'year' => 1993,
        'category_id' => $this->category->id
    ];
    $response = $this->actingAs($this->adminUser)->postJson('/api/books',$bookData);
    $response->assertStatus(201)->assertJsonFragment(['title'=>'name']);
    $this->assertDatabaseHas('books',['title'=>'name']);
});

it('update a book',function(){
    $book = Book::factory()->create([
        'title' => 'original',
        'author' => 'original',
        'publisher' => 'original',
        'year' => 1991,
        'category_id' => $this->category->id
    ]);
    $updatedCategory = Category::factory()->create();
    $updatedBook = [
        'title' => 'updated',
        'author' => 'updated',
        'publisher' => 'updated',
        'year' => 1992,
        'category_id' => $updatedCategory->id,
    ];
    $response = $this->actingAs($this->adminUser)->putJson("/api/books/{$book->id}",$updatedBook);
    $response->assertStatus(200)->assertJsonFragment(['title' => 'updated']);
    $this->assertDatabaseHas('books',['title'=> 'updated']);
});
it('delete a book',function(){
    $book = Book::factory()->create();
    $response = $this->actingAs($this->adminUser)->deleteJson("/api/books/{$book->id}");
    $response->assertStatus(204);
    $this->assertDatabaseMissing('books',['id'=>$book->id]);
});