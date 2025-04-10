# MailMaster API - Premier Livrable (Jours 1-4)

## Description du Projet

MailMaster API est une API RESTful développée avec Laravel 10, conçue pour la gestion de newsletters. L'objectif principal de ce projet est de fournir une solution robuste et autonome pour la gestion de campagnes d'emails, en évitant la dépendance à des services externes.

Ce premier livrable (Jours 1-4) se concentre sur la mise en place de l'architecture de base de l'API, la gestion des entités principales, l'authentification et les opérations CRUD essentielles.

## État du Premier Livrable (Jours 1-4)

Selon le cahier des charges, voici l'état d'avancement pour le premier livrable :

*   **✅ API de base fonctionnelle :** Oui, l'API de base est fonctionnelle avec les opérations CRUD pour les entités principales.
*   **✅ CRUD principal et auth terminés :**  Le CRUD principal pour Newsletters, Abonnés et Campagnes est implémenté. L'authentification avec Laravel Sanctum est fonctionnelle, incluant l'enregistrement, la connexion et la déconnexion, ainsi que la gestion des rôles utilisateurs (admin/éditeur).
*   **❌ Documentation partielle de l'API :**  La documentation de l'API avec Swagger n'est pas encore finalisée, mais l'installation et la configuration de Swagger sont en cours. *[Note: Vous pouvez mettre "En cours" si vous avez commencé à installer Swagger, ou "Planifiée" si vous prévoyez de le faire prochainement]*
*   **✅ README de projet :** Ce fichier `README.md` est en cours de création et sera finalisé pour le premier livrable.

## Fonctionnalités Clés Implémentées (Premier Livrable)

*   **Setup du projet Laravel 10 :**  Projet Laravel initialisé et configuré.
*   **Configuration de la base de données MySQL :** Connexion à la base de données configurée et fonctionnelle.
*   **Migrations et Modèles pour les entités principales :**
    *   `User` (Utilisateur - rôles admin/éditeur)
    *   `Newsletter` (Newsletter)
    *   `Subscriber` (Abonné)
    *   `Campaign` (Campagne)
*   **API RESTful avec contrôleurs CRUD pour :**
    *   Newsletters (`/api/newsletters`)
    *   Subscribers (`/api/subscribers`)
    *   Campaigns (`/api/campaigns`)
*   **Authentification API avec Laravel Sanctum :**
    *   Enregistrement d'utilisateur (`/api/register`)
    *   Connexion et obtention de token (`/api/login`)
    *   Déconnexion et invalidation de token (`/api/logout`)
    *   Protection des routes API avec le middleware `auth:sanctum`
*   **Gestion des rôles utilisateurs (admin/éditeur) :**
    *   Colonne `role` ajoutée à la table `users` (enum 'admin', 'editor').
    *   Politiques d'autorisation (Policies) pour Newsletters et Campaigns, restreignant la suppression aux admins.
*   **Documentation API (en cours) :**
    *   Installation et configuration de Swagger (l5-swagger) en cours. *[Modifier si vous avez progressé sur ce point]*

## Installation et Configuration

1.  **Cloner le repository :**
    ```bash
    git clone [URL_DE_VOTRE_REPOSITORY_GITHUB] mailmaster-api
    cd mailmaster-api
    ```

2.  **Installer les dépendances Composer :**
    ```bash
    composer install
    ```

3.  **Configurer la base de données :**
    *   Copier le fichier `.env.example` vers `.env` : `cp .env.example .env`
    *   Modifier le fichier `.env` avec vos informations de connexion à la base de données MySQL (DB\_DATABASE, DB\_USERNAME, DB\_PASSWORD, etc.).

4.  **Exécuter les migrations et les seeders :**
    ```bash
    php artisan migrate --seed
    ```

5.  **Générer une clé d'application Laravel (si ce n'est pas déjà fait) :**
    ```bash
    php artisan key:generate
    ```

6.  **Démarrer le serveur de développement Laravel :**
    ```bash
    php artisan serve
    ```
    L'API sera accessible à l'adresse `http://127.0.0.1:8000` (ou `http://localhost:8000`).

## Points d'Accès API (Endpoints)

Voici une liste des principaux points d'accès API implémentés dans ce premier livrable. *[Note: Complétez cette liste avec les endpoints réels de votre API]*

*   **Authentification :**
    *   `POST /api/register` - Enregistrer un nouvel utilisateur
    *   `POST /api/login` - Se connecter et obtenir un token d'accès
    *   `POST /api/logout` - Se déconnecter et invalider le token d'accès (nécessite un token valide)
*   **Newsletters :** (Nécessite un token d'accès valide)
    *   `GET /api/newsletters` - Lister les newsletters (paginé)
    *   `POST /api/newsletters` - Créer une nouvelle newsletter
    *   `GET /api/newsletters/{newsletter}` - Afficher une newsletter spécifique
    *   `PUT /api/newsletters/{newsletter}` - Mettre à jour une newsletter existante
    *   `DELETE /api/newsletters/{newsletter}` - Supprimer une newsletter (Admin seulement)
*   **Subscribers :** (Nécessite un token d'accès valide)
    *   `GET /api/subscribers` - Lister les abonnés (paginé)
    *   `POST /api/subscribers` - Ajouter un nouvel abonné
    *   `GET /api/subscribers/{subscriber}` - Afficher un abonné spécifique
    *   `PUT /api/subscribers/{subscriber}` - Mettre à jour un abonné existant
    *   `DELETE /api/subscribers/{subscriber}` - Supprimer un abonné
*   **Campaigns :** (Nécessite un token d'accès valide)
    *   `GET /api/campaigns` - Lister les campagnes (paginé)
    *   `POST /api/campaigns` - Créer une nouvelle campagne
    *   `GET /api/campaigns/{campaign}` - Afficher une campagne spécifique
    *   `PUT /api/campaigns/{campaign}` - Mettre à jour une campagne existante
    *   `DELETE /api/campaigns/{campaign}` - Supprimer une campagne (Admin seulement)

## Exemple d'Utilisation (via Postman)

1.  **Enregistrer un nouvel utilisateur (POST /api/register) :**
    *   Méthode : `POST`
    *   URL : `http://127.0.0.1:8000/api/register`
    *   Body (raw JSON) :
        ```json
        {
            "name": "Nom Utilisateur",
            "email": "nouvel_utilisateur@example.com",
            "password": "motdepasse",
            "password_confirmation": "motdepasse"
        }
        ```
    *   Vous recevrez un token dans la réponse (champ `"token"`).

2.  **Accéder à une route protégée (GET /api/newsletters) :**
    *   Méthode : `GET`
    *   URL : `http://127.0.0.1:8000/api/newsletters`
    *   Headers :
        *   `Authorization : Bearer [VOTRE_TOKEN_RECUPERE_ICI]` (remplacez `[VOTRE_TOKEN_RECUPERE_ICI]` par le token obtenu lors de l'étape précédente).

## Prochaines Étapes (Jours 5-8)

Pour le prochain livrable (Jours 5-8), les tâches principales seront :

*   Implémentation des routes API avancées (envoi de campagne, suivi, etc.).
*   Ajout de tests unitaires et fonctionnels (PHPUnit).
*   Finalisation de la documentation Swagger de l'API.
*   Création d'une interface frontend simple pour consommer l'API.
*   Préparation de la soutenance et de la démonstration du projet.

---

