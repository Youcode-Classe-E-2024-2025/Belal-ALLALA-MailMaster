# MailMaster API - Premier Livrable (Jours 1-4)

## Description du Projet

**MailMaster API** est une API RESTful robuste, développée avec **Laravel 10**, conçue pour offrir une solution complète et autonome de gestion de campagnes de newsletters.  L'objectif fondamental de ce projet est de professionnaliser et simplifier l'envoi d'emails marketing, en fournissant une alternative performante aux services externes et en offrant un contrôle total sur la communication par email.

Ce **premier livrable (Jours 1-4)** marque la fondation du projet. Il se concentre sur l'établissement d'une architecture API solide et fonctionnelle, la modélisation et la gestion des entités clés, la sécurisation de l'accès via l'authentification, et la mise en place des opérations CRUD indispensables pour l'administration des données.

## État du Premier Livrable (Jours 1-4) - Livrables Validés

Conformément aux spécifications du brief initial, le premier livrable est complété et validé pour les points suivants :

*   **✅ API de base fonctionnelle :**  L'API est entièrement fonctionnelle et opérationnelle, offrant les fonctionnalités CRUD de base pour la gestion des données essentielles.
*   **✅ CRUD principal et Authentification terminés :**  Les opérations CRUD (Créer, Lire, Mettre à jour, Supprimer) pour les entités principales (**Newsletters**, **Abonnés**, et **Campagnes**) sont intégralement implémentées et testées.  Le système d'authentification robuste avec **Laravel Sanctum** est mis en place et fonctionnel, incluant l'enregistrement, la connexion, la déconnexion sécurisée, et la gestion des rôles utilisateurs (Administrateur/Éditeur) pour le contrôle d'accès.
*   **✅ Documentation Partielle de l'API (Swagger) :**  La documentation interactive de l'API via **Swagger (OpenAPI)** est installée et configurée.  Une documentation partielle, mais essentielle, des endpoints principaux a été réalisée à l'aide d'annotations Swagger, facilitant la compréhension et l'utilisation de l'API.
*   **✅ README de projet :**  Ce fichier **`README.md`** est créé, complet et finalisé pour ce premier livrable. Il fournit une documentation de base du projet, les instructions d'installation et d'utilisation pour cette première phase.

## Fonctionnalités Clés Implémentées (Premier Livrable - Jours 1-4)

Ce premier livrable inclut les fonctionnalités fondamentales suivantes, posant les bases solides pour le développement ultérieur :

*   **Initialisation et Configuration du Projet Laravel 10 :**  Mise en place d'un nouveau projet Laravel 10, préparé pour un développement API RESTful.
*   **Configuration de la Base de Données MySQL :**  Établissement et configuration d'une connexion fonctionnelle à une base de données MySQL, prête à stocker les données de l'application.
*   **Modélisation de la Base de Données et Création des Migrations & Modèles :**
    *   **`User` (Utilisateur) :**  Gestion des utilisateurs de l'API, avec distinction des rôles (**Administrateur** et **Éditeur**) pour la gestion des permissions.
    *   **`Newsletter` (Newsletter) :**  Modèle pour la gestion des newsletters, incluant le titre et le contenu.
    *   **`Subscriber` (Abonné) :**  Modèle pour la gestion des abonnés aux newsletters, incluant email et nom.
    *   **`Campaign` (Campagne) :**  Modèle pour la gestion des campagnes d'envoi de newsletters, incluant le lien vers la newsletter, le titre, le sujet, le statut et la date d'envoi.
*   **Développement d'une API RESTful Complète avec Contrôleurs CRUD :**
    *   **`NewsletterController` :**  Gestion CRUD des Newsletters via l'endpoint `/api/newsletters`.
    *   **`SubscriberController` :**  Gestion CRUD des Abonnés via l'endpoint `/api/subscribers`.
    *   **`CampaignController` :**  Gestion CRUD des Campagnes via l'endpoint `/api/campaigns`.
*   **Implémentation de l'Authentification API Sécurisée avec Laravel Sanctum :**
    *   **Enregistrement d'utilisateur :**  Endpoint `/api/register` pour la création de nouveaux comptes utilisateurs.
    *   **Connexion et Obtention de Token d'accès :**  Endpoint `/api/login` pour l'authentification des utilisateurs et la réception d'un token d'accès **Sanctum** (Bearer Token).
    *   **Déconnexion et Invalidation de Token :**  Endpoint `/api/logout` pour la déconnexion sécurisée et l'invalidation du token d'accès courant (nécessite un token valide).
    *   **Protection des Routes API :**  Sécurisation des routes API nécessitant une authentification via le middleware `auth:sanctum`, garantissant que seuls les utilisateurs authentifiés peuvent accéder aux ressources protégées.
*   **Gestion des Rôles Utilisateurs (Administrateur/Éditeur) et Autorisations :**
    *   **Ajout du Rôle Utilisateur :**  Intégration d'une colonne `role` à la table `users` (type `enum` avec valeurs 'admin' et 'editor'), permettant de définir le rôle de chaque utilisateur.
    *   **Politiques d'Autorisation (Policies) :**  Mise en place de Policies Laravel pour **Newsletters** et **Campaigns**, définissant les règles d'autorisation et restreignant notamment la suppression de Newsletters et Campagnes aux seuls utilisateurs ayant le rôle **Administrateur**.
*   **Installation et Configuration de la Documentation API Interactive avec Swagger (OpenAPI) :**
    *   **Installation de Swagger (l5-swagger) :**  Intégration de la librairie `l5-swagger` pour la génération de la documentation OpenAPI/Swagger.
    *   **Configuration de Swagger UI :**  Swagger UI accessible et fonctionnel via l'URL `/api/documentation`, offrant une interface interactive pour explorer et tester l'API.
    *   **Annotations Swagger de Base :**  Ajout d'annotations Swagger de base dans les contrôleurs API pour documenter les endpoints, les paramètres, les requêtes et les réponses, fournissant une première version de la documentation.

## Installation et Configuration de l'API (Premier Livrable)

Pour mettre en place et exécuter l'API MailMaster (Premier Livrable), suivez les étapes d'installation ci-dessous :

1.  **Cloner le Répertoire du Projet (Repository) :**
    ```bash
    git clone [URL_DE_VOTRE_REPOSITORY_GITHUB] mailmaster-api
    cd mailmaster-api
    ```
    *Remplacez `[URL_DE_VOTRE_REPOSITORY_GITHUB]` par l'URL de votre repository GitHub contenant le code du projet.*

2.  **Installer les Dépendances PHP via Composer :**
    ```bash
    composer install
    ```
    *Cette commande installera toutes les librairies PHP nécessaires au projet, définies dans le fichier `composer.json`.*

3.  **Configurer la Connexion à la Base de Données MySQL :**
    *   **Copier le Fichier d'Exemple `.env.example` vers `.env` :**
        ```bash
        cp .env.example .env
        ```
    *   **Modifier le Fichier `.env` :**  Ouvrez le fichier `.env` avec un éditeur de texte et renseignez vos informations de connexion à la base de données MySQL.  Modifiez les variables suivantes avec vos paramètres :
        ```
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=votre_nom_de_base_de_donnees
        DB_USERNAME=votre_nom_utilisateur_mysql
        DB_PASSWORD=votre_mot_de_passe_mysql
        ```
        *Assurez-vous que la base de données spécifiée (`DB_DATABASE`) existe ou sera créée.*

4.  **Exécuter les Migrations de la Base de Données et les Seeders (pour initialiser des données de test) :**
    ```bash
    php artisan migrate --seed
    ```
    *Cette commande exécutera les migrations pour créer les tables dans votre base de données etSeeders pour insérer des données de test (utilisateurs initiaux, etc.).*

5.  **Générer la Clé d'Application Laravel (si ce n'est pas déjà fait) :**
    ```bash
    php artisan key:generate
    ```
    *Cette commande génère une clé unique pour votre application Laravel, essentielle pour la sécurité (cryptographie, sessions, etc.). Si vous avez déjà exécuté cette commande, vous pouvez l'ignorer.*

6.  **Démarrer le Serveur de Développement Laravel :**
    ```bash
    php artisan serve
    ```
    *Cette commande démarre le serveur de développement intégré de Laravel. L'API sera accessible par défaut à l'adresse `http://127.0.0.1:8000` ou `http://localhost:8000`.*

    Ouvrez votre navigateur web et accédez à l'une de ces adresses pour vérifier que le serveur Laravel est en cours d'exécution.

## Points d'Accès API (Endpoints) - Premier Livrable

Voici la liste des principaux points d'accès (endpoints) de l'API implémentés et documentés dans ce premier livrable.  **Toutes les routes listées sous "Newsletters", "Subscribers" et "Campaigns" nécessitent une authentification valide via un Bearer Token.**

*   **Authentification des Utilisateurs :**
    *   **`POST /api/register`** - **Enregistrer un nouvel utilisateur :**  Permet de créer un nouveau compte utilisateur. Requiert les champs `name`, `email`, `password`, et `password_confirmation` dans le corps de la requête (JSON).
    *   **`POST /api/login`** - **Se Connecter et Obtenir un Token d'Accès :**  Permet à un utilisateur existant de se connecter avec son email et mot de passe, et de recevoir un token d'accès **Sanctum** (Bearer Token) en réponse. Requiert les champs `email` et `password` dans le corps de la requête (JSON).
    *   **`POST /api/logout`** - **Se Déconnecter et Invalider le Token d'Accès :**  Permet à un utilisateur authentifié de se déconnecter et d'invalider son token d'accès courant. **Nécessite un token d'accès valide** dans l'en-tête `Authorization` (Bearer Token).

*   **Gestion des Newsletters :**  *(Nécessite un token d'accès valide)*
    *   **`GET /api/newsletters`** - **Lister les Newsletters (paginé) :**  Récupère une liste paginée de toutes les newsletters enregistrées.
    *   **`POST /api/newsletters`** - **Créer une Nouvelle Newsletter :**  Permet de créer une nouvelle newsletter. Requiert les champs `title` et `content` dans le corps de la requête (JSON).
    *   **`GET /api/newsletters/{newsletter}`** - **Afficher une Newsletter Spécifique :**  Récupère les informations détaillées d'une newsletter spécifique, identifiée par son `ID`.
    *   **`PUT /api/newsletters/{newsletter}`** - **Mettre à Jour une Newsletter Existante :**  Permet de modifier les informations d'une newsletter existante.  Accepte les champs `title` et `content` dans le corps de la requête (JSON).
    *   **`DELETE /api/newsletters/{newsletter}`** - **Supprimer une Newsletter :**  Supprime une newsletter spécifique, identifiée par son `ID`. **Réservé aux utilisateurs ayant le rôle Administrateur.**

*   **Gestion des Abonnés (Subscribers) :** *(Nécessite un token d'accès valide)*
    *   **`GET /api/subscribers`** - **Lister les Abonnés (paginé) :**  Récupère une liste paginée de tous les abonnés.
    *   **`POST /api/subscribers`** - **Ajouter un Nouvel Abonné :**  Permet d'ajouter un nouvel abonné. Requiert le champ `email` (et optionnellement `name`) dans le corps de la requête (JSON).
    *   **`GET /api/subscribers/{subscriber}`** - **Afficher un Abonné Spécifique :**  Récupère les informations détaillées d'un abonné spécifique, identifié par son `ID`.
    *   **`PUT /api/subscribers/{subscriber}`** - **Mettre à Jour un Abonné Existant :**  Permet de modifier les informations d'un abonné existant. Accepte les champs `email` et `name` dans le corps de la requête (JSON).
    *   **`DELETE /api/subscribers/{subscriber}`** - **Supprimer un Abonné :**  Supprime un abonné spécifique, identifié par son `ID`.

*   **Gestion des Campagnes :** *(Nécessite un token d'accès valide)*
    *   **`GET /api/campaigns`** - **Lister les Campagnes (paginé) :**  Récupère une liste paginée de toutes les campagnes.
    *   **`POST /api/campaigns`** - **Créer une Nouvelle Campagne :**  Permet de créer une nouvelle campagne. Requiert les champs `newsletter_id`, `title`, et `subject` dans le corps de la requête (JSON).
    *   **`GET /api/campaigns/{campaign}`** - **Afficher une Campagne Spécifique :**  Récupère les informations détaillées d'une campagne spécifique, identifiée par son `ID`.
    *   **`PUT /api/campaigns/{campaign}`** - **Mettre à Jour une Campagne Existante :**  Permet de modifier les informations d'une campagne existante. Accepte les champs `newsletter_id`, `title`, `subject`, et `status` dans le corps de la requête (JSON).
    *   **`DELETE /api/campaigns/{campaign}`** - **Supprimer une Campagne :**  Supprime une campagne spécifique, identifiée par son `ID`. **Réservé aux utilisateurs ayant le rôle Administrateur.**

## Exemple d'Utilisation de l'API (via Postman ou Insomnia)

Pour tester l'API, vous pouvez utiliser un client REST comme **Postman**, **Insomnia**, ou **Thunder Client**.  Voici un exemple de flux d'utilisation typique :

1.  **Enregistrer un Nouvel Utilisateur (POST `/api/register`) :**
    *   **Méthode :** `POST`
    *   **URL :** `http://127.0.0.1:8000/api/register`
    *   **Corps (Body) :**  Sélectionnez le format `raw` et `JSON` et entrez le JSON suivant :
        ```json
        {
            "name": "Nom de l'Utilisateur",
            "email": "nouvel_utilisateur@example.com",
            "password": "motdepasse_securise",
            "password_confirmation": "motdepasse_securise"
        }
        ```
    *   **Envoyez la requête.** Si l'enregistrement réussit, vous recevrez une réponse avec un code de statut `201 Created` et un token d'accès dans le champ `"token"` de la réponse JSON. **Copiez ce token, vous en aurez besoin pour les prochaines étapes.**

2.  **Accéder à une Route Protégée - Lister les Newsletters (GET `/api/newsletters`) :**
    *   **Méthode :** `GET`
    *   **URL :** `http://127.0.0.1:8000/api/newsletters`
    *   **En-têtes (Headers) :**  Ajoutez un nouvel en-tête :
        *   **Clé (Key) :** `Authorization`
        *   **Valeur (Value) :** `Bearer [VOTRE_TOKEN_RECUPERE_ICI]`
            *__Important :__ Remplacez `[VOTRE_TOKEN_RECUPERE_ICI]` par le token d'accès que vous avez copié à l'étape précédente.*

    *   **Envoyez la requête.** Si l'authentification est réussie et que votre token est valide, vous recevrez une réponse avec un code de statut `200 OK` et une liste paginée de newsletters au format JSON.

Suivez des étapes similaires pour tester les autres endpoints API, en ajustant la méthode HTTP, l'URL, le corps de la requête (si nécessaire) et en incluant toujours l'en-tête `Authorization` avec votre Bearer Token pour les routes protégées.

## Prochaines Étapes - Développement du Second Livrable (Jours 5-8)

Pour le prochain cycle de développement (Jours 5-8), nous allons nous concentrer sur l'implémentation des fonctionnalités avancées de l'API et la préparation de la démonstration finale :

*   **Implémentation des Routes API Avancées :**
    *   Développement des endpoints pour l'**envoi de campagnes** (gestion de l'envoi d'emails).
    *   Intégration du **suivi des ouvertures** d'emails (tracking pixel).
    *   Ajout d'une route pour l'**aperçu des campagnes** avant l'envoi.
*   **Ajout de Tests Unitaires et Fonctionnels (PHPUnit) :**  Développement de tests automatisés avec PHPUnit pour garantir la qualité et la stabilité de l'API.
*   **Finalisation de la Documentation Swagger de l'API :**  Compléter et améliorer la documentation Swagger, en ajoutant des exemples de requêtes et réponses plus détaillés, et en affinant les descriptions des endpoints et des schémas.
*   **Création d'une Interface Frontend Simple :**  Développement d'une interface utilisateur web basique (en JavaScript ou un framework JS léger) pour consommer l'API et permettre l'administration des newsletters et campagnes.
*   **Préparation de la Soutenance et de la Démonstration du Projet :**  Préparation de la présentation orale et de la démonstration technique du projet pour la soutenance finale.

---

Ce document `README.md` fournit une vue d'ensemble du premier livrable de l'API MailMaster.  Pour toute question ou problème, veuillez consulter la documentation Swagger de l'API (accessible via `/api/documentation` une fois l'application démarrée) ou contacter l'équipe de développement.