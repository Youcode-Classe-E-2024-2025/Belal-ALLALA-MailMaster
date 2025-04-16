# MailMaster API

## Description du Projet

**MailMaster API** est une API RESTful puissante, développée avec **Laravel 10**, conçue pour la gestion efficace de campagnes de newsletters.  Elle offre une solution interne et autonome pour les entreprises souhaitant professionnaliser leur communication par email, sans dépendre de services externes.

Cette API permet de gérer l'ensemble du cycle de vie des newsletters, de la création de listes de diffusion à l'envoi de campagnes et à la consultation des statistiques (fonctionnalités en développement pour les prochains livrables).

Ce premier livrable met en place les bases de l'API, avec la gestion des entités principales (Newsletters, Abonnés, Campagnes), l'authentification sécurisée et la documentation initiale.

## Fonctionnalités Clés

Ce premier livrable de l'API MailMaster inclut les fonctionnalités essentielles suivantes :

*   **Gestion des Utilisateurs :**  Système d'authentification robuste avec Laravel Sanctum, incluant l'enregistrement, la connexion, la déconnexion et la gestion des rôles (Administrateur/Éditeur) pour la sécurité et le contrôle d'accès.
*   **Gestion des Newsletters :**  Opérations CRUD complètes pour la création, la lecture, la mise à jour et la suppression des newsletters.
*   **Gestion des Abonnés :**  Opérations CRUD complètes pour la gestion des abonnés (ajout, consultation, modification, suppression).
*   **Gestion des Campagnes :**  Opérations CRUD complètes pour la gestion des campagnes d'envoi de newsletters.
*   **API RESTful :**  Architecture RESTful claire et bien structurée, utilisant les méthodes HTTP standard (GET, POST, PUT, DELETE).
*   **Sécurité :**  Authentification par token (Bearer Token) via Laravel Sanctum pour sécuriser l'accès à l'API. Gestion des rôles et politiques d'autorisation pour contrôler les actions des utilisateurs (ex: suppression de newsletters réservée aux admins).
*   **Documentation API (Swagger) :**  Documentation interactive de l'API générée avec Swagger (OpenAPI), accessible via `/api/documentation`.

## Installation

Suivez ces étapes pour installer et configurer l'API MailMaster :

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
    *   Modifier le fichier `.env` avec vos informations de connexion MySQL.

4.  **Exécuter les migrations et les seeders :**
    ```bash
    php artisan migrate --seed
    ```

5.  **Générer la clé d'application :**
    ```bash
    php artisan key:generate
    ```

6.  **Démarrer le serveur de développement :**
    ```bash
    php artisan serve
    ```

    L'API sera accessible à `http://127.0.0.1:8000` (ou `http://localhost:8000`).

## Points d'Accès API (Endpoints)

Voici une liste des principaux points d'accès API.  **Les routes sous "Newsletters", "Subscribers" et "Campaigns" nécessitent une authentification Bearer Token.**

*   **Authentification :**
    *   `POST /api/register` - Enregistrer un utilisateur
    *   `POST /api/login` - Se connecter et obtenir un token
    *   `POST /api/logout` - Se déconnecter (nécessite un token valide)
*   **Newsletters :**
    *   `GET /api/newsletters` - Lister les newsletters
    *   `POST /api/newsletters` - Créer une newsletter
    *   `GET /api/newsletters/{newsletter}` - Afficher une newsletter
    *   `PUT /api/newsletters/{newsletter}` - Mettre à jour une newsletter
    *   `DELETE /api/newsletters/{newsletter}` - Supprimer une newsletter (Admin seulement)
*   **Subscribers :**
    *   `GET /api/subscribers` - Lister les abonnés
    *   `POST /api/subscribers` - Ajouter un abonné
    *   `GET /api/subscribers/{subscriber}` - Afficher un abonné
    *   `PUT /api/subscribers/{subscriber}` - Mettre à jour un abonné
    *   `DELETE /api/subscribers/{subscriber}` - Supprimer un abonné
*   **Campaigns :**
    *   `GET /api/campaigns` - Lister les campagnes
    *   `POST /api/campaigns` - Créer une campagne
    *   `GET /api/campaigns/{campaign}` - Afficher une campagne
    *   `PUT /api/campaigns/{campaign}` - Mettre à jour une campagne
    *   `DELETE /api/campaigns/{campaign}` - Supprimer une campagne (Admin seulement)

Consultez la documentation Swagger UI à `/api/documentation` pour une description complète des endpoints, des paramètres et des exemples d'utilisation.

## Exemple d'Utilisation (Postman/Insomnia)

1.  **Enregistrer un utilisateur (POST /api/register)**
2.  **Se connecter et obtenir un token (POST /api/login)**
3.  **Utiliser le token Bearer dans l'en-tête `Authorization` pour accéder aux routes protégées (ex: GET /api/newsletters)**

(Voir le README complet ou la documentation Swagger pour des exemples détaillés).

## Prochaines Étapes

Les prochaines étapes de développement de MailMaster API incluront :

*   Implémentation des fonctionnalités avancées d'envoi de campagnes (envoi, aperçu, suivi).
*   Ajout de tests unitaires et fonctionnels (PHPUnit) pour garantir la qualité.
*   Finalisation de la documentation Swagger (exemples détaillés, schémas complets).
*   Développement d'une interface frontend simple pour consommer l'API.

---

Ce fichier `README.md` fournit une description générale de l'API MailMaster.  Pour des informations plus détaillées, consultez la documentation Swagger interactive ou le code source du projet.