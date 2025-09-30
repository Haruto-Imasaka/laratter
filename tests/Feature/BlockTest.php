<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a user to block another user', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $blockedUser = User::factory()->create();

    $this->post(route('blocks.store', $blockedUser));

    $this->assertDatabaseHas('blocks', [
        'blocker_id' => $user->id,
        'blocked_id' => $blockedUser->id,
    ]);
});

it('allows a user to unblock a user', function () {
    $user = User::factory()->create();
    $blockedUser = User::factory()->create();

    // 事前にブロック
    $user->blocks()->attach($blockedUser);

    $this->actingAs($user)
        ->delete(route('blocks.destroy', $blockedUser));

    $this->assertDatabaseMissing('blocks', [
        'blocker_id' => $user->id,
        'blocked_id' => $blockedUser->id,
    ]);
});

it('prevents a blocked user from viewing profile', function () {
    $user = User::factory()->create();
    $blockedUser = User::factory()->create();

    // blockedUser が user をブロック
    $blockedUser->blocks()->attach($user);

    $this->actingAs($user);

    $response = $this->get(route('profile.show', $blockedUser));

    $response->assertStatus(200);
    $response->assertSee("さんはあなたをブロックしました");
});

it('shows blocked users on block index', function () {
    $user = User::factory()->create();
    $blockedUser = User::factory()->create();

    $user->blocks()->attach($blockedUser);

    $this->actingAs($user);

    $response = $this->get(route('blocks.index'));

    $response->assertStatus(200);
    $response->assertSee($blockedUser->name);
});
