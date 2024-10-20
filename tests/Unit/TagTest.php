<?php

use App\Models\Tag;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a tag', function () {
    $data = [
        'name' => 'Test Tag',
        'description' => 'Test Description',
    ];

    $tag = Tag::create($data);

    expect($tag)->toBeInstanceOf(Tag::class);
    expect($tag->name)->toBe('Test Tag');
});

it('can update a tag', function () {
    $tag = Tag::factory()->create();

    $data = [
        'name' => 'Updated Tag',
        'description' => 'Updated Description',
    ];

    $tag->update($data);

    expect($tag->name)->toBe('Updated Tag');
});

it('can delete a tag', function () {
    $tag = Tag::factory()->create();

    $tag->delete();

    expect(Tag::find($tag->id))->toBeNull();
});

it('can attach a product to a tag', function () {
    $tag = Tag::factory()->create();
    $product = Product::factory()->create();

    $tag->products()->attach($product->id);

    expect($tag->products)->toContain($product);
});