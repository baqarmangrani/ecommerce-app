<?php

use App\Models\Discount;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a discount', function () {
    $data = [
        'discount_code' => 'TEST10',
        'amount' => 10,
        'type' => 'percentage',
    ];

    $discount = Discount::create($data);

    expect($discount)->toBeInstanceOf(Discount::class);
    expect($discount->discount_code)->toBe('TEST10');
});

it('can update a discount', function () {
    $discount = Discount::factory()->create();

    $data = [
        'amount' => 20,
        'type' => 'flat',
    ];

    $discount->update($data);

    expect($discount->amount)->toBe(20);
});

it('can delete a discount', function () {
    $discount = Discount::factory()->create();

    $discount->delete();

    expect(Discount::find($discount->id))->toBeNull();
});

it('can apply a flat discount', function () {
    $discount = Discount::factory()->create(['type' => 'flat', 'amount' => 10]);

    $total = 100;
    $newTotal = $discount->applyTo($total);

    expect($newTotal)->toBe(90);
});

it('can apply a percentage discount', function () {
    $discount = Discount::factory()->create(['type' => 'percentage', 'amount' => 10]);

    $total = 100;
    $newTotal = $discount->applyTo($total);

    expect($newTotal)->toBe(90);
});