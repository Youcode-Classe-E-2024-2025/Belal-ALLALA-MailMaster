<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Campaign;
use App\Models\Newsletter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Mail; // Facade Mail pour le mocking

class CampaignControllerTest extends TestCase
{
    use RefreshDatabase; // Pour réinitialiser la base de données après chaque test

    public function test_index_campaigns_returns_paginated_list()
    {
        Sanctum::actingAs(User::factory()->create()); // Authentifier un utilisateur pour accéder à la route protégée
        Campaign::factory(3)->create(); // Créer quelques campagnes

        $response = $this->getJson('/api/campaigns');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']); // Vérifier la structure de pagination
    }

    public function test_store_valid_campaign_creates_campaign()
    {
        Sanctum::actingAs(User::factory()->create());
        $newsletter = Newsletter::factory()->create(); // Assurez-vous qu'une newsletter existe

        $response = $this->postJson('/api/campaigns', [
            'newsletter_id' => $newsletter->id,
            'title' => 'Test Campaign',
            'subject' => 'Test Subject',
        ]);

        $response->assertStatus(201)
            ->assertJson(['title' => 'Test Campaign']);
        $this->assertDatabaseHas('campaigns', ['title' => 'Test Campaign']); // Vérifier que la campagne est bien enregistrée en base
    }

    public function test_store_campaign_validation_fails_for_invalid_data()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/campaigns', []); // Envoyer des données invalides (champs manquants)

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['newsletter_id', 'title', 'subject']); // Vérifier les erreurs de validation
    }

    public function test_show_campaign_returns_campaign_data()
    {
        Sanctum::actingAs(User::factory()->create());
        $campaign = Campaign::factory()->create();

        $response = $this->getJson("/api/campaigns/{$campaign->id}");

        $response->assertStatus(200)
            ->assertJson(['title' => $campaign->title]);
    }

    public function test_update_valid_campaign_updates_campaign()
    {
        Sanctum::actingAs(User::factory()->create());
        $campaign = Campaign::factory()->create();

        $response = $this->putJson("/api/campaigns/{$campaign->id}", [
            'title' => 'Updated Campaign Title',
        ]);

        $response->assertStatus(200)
            ->assertJson(['title' => 'Updated Campaign Title']);
        $this->assertDatabaseHas('campaigns', ['id' => $campaign->id, 'title' => 'Updated Campaign Title']);
    }

    public function test_destroy_campaign_deletes_campaign_for_admin_user()
    {
        $adminUser = User::factory()->admin()->create(); // Créer un utilisateur admin
        Sanctum::actingAs($adminUser);
        $campaign = Campaign::factory()->create();

        $response = $this->deleteJson("/api/campaigns/{$campaign->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('campaigns', ['id' => $campaign->id]);
    }

    public function test_destroy_campaign_forbidden_for_non_admin_user()
    {
        Sanctum::actingAs(User::factory()->create()); // Utilisateur non-admin
        $campaign = Campaign::factory()->create();

        $response = $this->deleteJson("/api/campaigns/{$campaign->id}");

        $response->assertStatus(403); // Code 403 Forbidden car policy NewsletterPolicy interdit la suppression aux non-admins
    }

    public function test_send_campaign_starts_sending_process()
    {
        Sanctum::actingAs(User::factory()->create());
        $campaign = Campaign::factory()->draft()->create(); // Créer une campagne au statut 'draft'
        Subscriber::factory(2)->create(); // Créer quelques abonnés
        Mail::fake(); // Mock la facade Mail pour ne pas envoyer de vrais emails pendant les tests

        $response = $this->postJson("/api/campaigns/{$campaign->id}/send");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Campaign sending started to 2 subscribers.']);
        $this->assertDatabaseHas('campaigns', ['id' => $campaign->id, 'status' => 'pending']); // Vérifier que le statut est mis à jour
        Mail::assertSentCount(2); // Vérifier que Mail::raw a été appelé 2 fois (pour 2 abonnés) - **Très important pour tester l'envoi sans réellement envoyer d'emails**
    }

    public function test_preview_campaign_returns_newsletter_content()
    {
        Sanctum::actingAs(User::factory()->create());
        $newsletter = Newsletter::factory()->create(['content' => '<h1>Test Newsletter Content</h1>']);
        $campaign = Campaign::factory()->for($newsletter)->create(); 

        $response = $this->getJson("/api/campaigns/{$campaign->id}/preview");

        $response->assertStatus(200)
            ->assertJson(['content' => '<h1>Test Newsletter Content</h1>']);
    }
}