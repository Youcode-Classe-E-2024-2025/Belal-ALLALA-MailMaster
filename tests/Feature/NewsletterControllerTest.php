<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Newsletter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class NewsletterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_newsletters_returns_paginated_list()
    {
        Sanctum::actingAs(User::factory()->create());
        Newsletter::factory(3)->create();

        $response = $this->getJson('/api/newsletters');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_store_valid_newsletter_creates_newsletter()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/newsletters', [
            'title' => 'Test Newsletter',
            'content' => 'Test Content',
        ]);

        $response->assertStatus(201)
            ->assertJson(['title' => 'Test Newsletter']);
        $this->assertDatabaseHas('newsletters', ['title' => 'Test Newsletter']);
    }

    public function test_store_newsletter_validation_fails_for_invalid_data()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/newsletters', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'content']);
    }

    public function test_show_newsletter_returns_newsletter_data()
    {
        Sanctum::actingAs(User::factory()->create());
        $newsletter = Newsletter::factory()->create();

        $response = $this->getJson("/api/newsletters/{$newsletter->id}");

        $response->assertStatus(200)
            ->assertJson(['title' => $newsletter->title]);
    }

    public function test_update_valid_newsletter_updates_newsletter()
    {
        Sanctum::actingAs(User::factory()->create());
        $newsletter = Newsletter::factory()->create();

        $response = $this->putJson("/api/newsletters/{$newsletter->id}", [
            'title' => 'Updated Newsletter Title',
        ]);

        $response->assertStatus(200)
            ->assertJson(['title' => 'Updated Newsletter Title']);
        $this->assertDatabaseHas('newsletters', ['id' => $newsletter->id, 'title' => 'Updated Newsletter Title']);
    }

    public function test_destroy_newsletter_deletes_newsletter_for_admin_user()
    {
        $adminUser = User::factory()->admin()->create();
        Sanctum::actingAs($adminUser);
        $newsletter = Newsletter::factory()->create();

        $response = $this->deleteJson("/api/newsletters/{$newsletter->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('newsletters', ['id' => $newsletter->id]);
    }

    public function test_destroy_newsletter_forbidden_for_non_admin_user()
    {
        Sanctum::actingAs(User::factory()->create());
        $newsletter = Newsletter::factory()->create();

        $response = $this->deleteJson("/api/newsletters/{$newsletter->id}");

        $response->assertStatus(403); // Forbidden for non-admin
    }
}