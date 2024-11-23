<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;

uses(RefreshDatabase::class);

beforeEach(function(){
    $this->adminUser = User::factory()->create(['role'=>'admin']);
    $this->normalUser = User::factory()->create(['role'=>'user']);
});

it('return all categories on index',function(){
    Category::factory()->count(5)->create();
    $response = $this->getJson('/api/categories');
    $response->assertStatus(200)->assertJsonStructure([
        '*'=>[
            'id',
            'name'
        ]
    ]);
});
it('create a category', function(){
    $categoryData = [
        'name' => 'tes'
    ];
    $response = $this->actingAs($this->adminUser)->postJson('/api/categories',$categoryData);
    $response->assertStatus(201)->assertJsonFragment(['name' => 'tes']);
    $this->assertDatabaseHas('categories',['name' => 'tes']);
});
it('update a category', function() {
    $category = Category::factory()->create(['name' => 'original']);
    $updatedData = [
        'name' => 'updated'
    ];
    $response = $this->actingAs($this->adminUser)
        ->putJson("/api/categories/{$category->id}", $updatedData);
    $response->assertStatus(200)->assertJsonFragment(['name' => 'updated']);
    $this->assertDatabaseHas('categories', ['name' => 'updated']);
});
it('delete a category', function(){
    $category = Category::factory()->create();
    $response = $this->actingAs($this->adminUser)->deleteJson("/api/categories/{$category->id}");
    $response->assertStatus(204);
    $this->assertDatabaseMissing('categories',['id' => $category->id]);
});