<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class SubscriberControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_subscribers_returns_paginated_list()
    {
        Sanctum::actingAs(User::factory()->create());
        Subscriber::factory(3)->create();

        $response = $this->getJson('/api/subscribers');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_store_valid_subscriber_creates_subscriber()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/subscribers', [
            'email' => 'test@example.com',
            'name' => 'Test Subscriber',
        ]);

        $response->assertStatus(201)
            ->assertJson(['email' => 'test@example.com']);
        $this->assertDatabaseHas('subscribers', ['email' => 'test@example.com']);
    }

    public function test_store_subscriber_validation_fails_for_invalid_data()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/subscribers', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_show_subscriber_returns_subscriber_data()
    {
        Sanctum::actingAs(User::factory()->create());
        $subscriber = Subscriber::factory()->create();

        $response = $this->getJson("/api/subscribers/{$subscriber->id}");

        $response->assertStatus(200)
            ->assertJson(['email' => $subscriber->email]);
    }

    public function test_update_valid_subscriber_updates_subscriber()
    {
        Sanctum::actingAs(User::factory()->create());
        $subscriber = Subscriber::factory()->create();

        $response = $this->putJson("/api/subscribers/{$subscriber->id}", [
            'name' => 'Updated Subscriber Name',
        ]);

        $response->assertStatus(200)
            ->assertJson(['name' => 'Updated Subscriber Name']);
        $this->assertDatabaseHas('subscribers', ['id' => $subscriber->id, 'name' => 'Updated Subscriber Name']);
    }

    public function test_destroy_subscriber_deletes_subscriber()
    {
        Sanctum::actingAs(User::factory()->create());
        $subscriber = Subscriber::factory()->create();

        $response = $this->deleteJson("/api/subscribers/{$subscriber->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('subscribers', ['id' => $subscriber->id]);
    }
}
