<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MailMaster Admin</title>
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}"> {{-- Lien vers le CSS public --}}
</head>
<body>
    <header>
        <h1>MailMaster Admin</h1>
    </header>

    <main>
        <section id="campaigns-section">
            <h2>Campaigns</h2>
            <button id="create-campaign-btn">Create New Campaign</button>
            <ul id="campaign-list">
                <!-- Campaigns will be listed here -->
            </ul>
        </section>

        <section id="create-campaign-form" style="display:none;">
            <h2>Create New Campaign</h2>
            <form id="campaign-form">
                <label for="newsletter_id">Newsletter ID:</label>
                <input type="number" id="newsletter_id" name="newsletter_id" required><br><br>

                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required><br><br>

                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required><br><br>

                <button type="submit">Create Campaign</button>
                <button type="button" id="cancel-create-campaign">Cancel</button>
            </form>
        </section>

        <section id="subscribers-section">
            <h2>Subscribers</h2>
            <ul id="subscriber-list">
                <!-- Subscribers will be listed here -->
            </ul>
        </section>
    </main>

    <footer>
        <p>© {{ date('Y') }} MailMaster</p> {{-- Exemple d'utilisation de Blade pour l'année --}}
    </footer>

    <script src="{{ asset('frontend/script.js') }}"></script> {{-- Lien vers le JS public --}}
</body>
</html>