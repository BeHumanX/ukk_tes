<?php

use App\Models\Borrow;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function(){
    $this->adminUser = User::factory()->create(['role'=>'admin']);
    $this->normalUser = User::factory()->create(['role'=>'user']);
});

it('return borrows on index',function(){
    Borrow::factory()->count(3)->create();
    $response = $this->actingAs($this->adminUser)
        ->getJson('/api/borrows');
    $response->assertStatus(200)->assertJsonStructure([
        '*'=>[
            'id',
            'user_id',
            'book_id',
            'borrow_date',
            'return_date'
        ]
    ]);
});

it('allows user to borrow a book', function() {
    $book = Book::factory()->create(['status' => 'available']);
    $borrowData = [
        'book_id' => $book->id,
        'return_date' => now()->addDays(7)->toDateString()
    ];
    
    $response = $this->actingAs($this->normalUser)
        ->postJson('/api/borrow', $borrowData);
    
    $response->assertStatus(201)
        ->assertJsonStructure([
            'borrow' => [
                'id',
                'user_id',
                'book_id',
                'borrow_date',
                'return_date'
            ],
            'book' => [
                'id',
                'status'
            ]
        ]);
    
    $this->assertDatabaseHas('books', [
        'id' => $book->id,
        'status' => 'borrowed'
    ]);
});