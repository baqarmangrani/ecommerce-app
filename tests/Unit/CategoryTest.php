<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a category', function () {
    $data = [
        'name' => 'Test Category',
        'description' => 'Test Description',
    ];

    $category = Category::create($data);

    expect($category)->toBeInstanceOf(Category::class);
    expect($category->name)->toBe('Test Category');
});

it('can update a category', function () {
    $category = Category::factory()->create();

    $data = [
        'name' => 'Updated Category',
        'description' => 'Updated Description',
    ];

    $category->update($data);

    expect($category->name)->toBe('Updated Category');
});

it('can delete a category', function () {
    $category = Category::factory()->create();

    $category->delete();

    expect(Category::find($category->id))->toBeNull();
});