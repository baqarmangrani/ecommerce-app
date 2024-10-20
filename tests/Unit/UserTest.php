<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a user', function () {
    $data = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ];

    $user = User::create($data);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toBe('Test User');
});

it('can update a user', function () {
    $user = User::factory()->create();

    $data = [
        'name' => 'Updated User',
        'email' => 'updated@example.com',
    ];

    $user->update($data);

    expect($user->name)->toBe('Updated User');
});

it('can delete a user', function () {
    $user = User::factory()->create();

    $user->delete();

    expect(User::find($user->id))->toBeNull();
});