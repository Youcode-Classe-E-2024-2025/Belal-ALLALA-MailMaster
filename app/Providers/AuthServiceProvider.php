<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        \App\Models\Newsletter::class => \App\Policies\NewsletterPolicy::class, // Ajout de la policy pour Newsletter
        \App\Models\Campaign::class => \App\Policies\CampaignPolicy::class,     // Ajout de la policy pour Campaign
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Implicitly grant "Super Admin" role all permissions
        // For example, User with role 'admin' can bypass all policies
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->isAdmin() ? true : null; // Si l'utilisateur est admin, retourne true (autorisé), sinon continue la vérification avec les policies
        });
    }
}