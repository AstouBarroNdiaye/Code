<?php
// Inclure la connexion à la base de données
require_once 'db.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $identifiant = $_POST['identifiant'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $role_id = $_POST['role_id']; // Récupère le rôle depuis un formulaire

    // Vérifier si l'identifiant existe déjà dans la base de données
    $sql_check = "SELECT * FROM utilisateurs WHERE identifiant = :identifiant";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->bindParam(':identifiant', $identifiant);
    $stmt_check->execute();

    // Si l'identifiant existe déjà, afficher un message
    if ($stmt_check->rowCount() > 0) {
        $message = "L'identifiant '$identifiant' existe déjà dans la base de données.";
    } else {
        // Hacher le mot de passe
        $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Insertion dans la base de données avec le mot de passe haché
        $sql = "INSERT INTO utilisateurs (identifiant, mot_de_passe, role_id) VALUES (:identifiant, :mot_de_passe, :role_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':identifiant', $identifiant);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe_hache);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->execute();

        $message = "Utilisateur ajouté avec succès!";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un utilisateur</title>
    <!-- Lien vers la dernière version de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Style de la page d'ajout d'utilisateur */
        body {
            background: url('image_cabinet.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            color: #fff;
            height: 100vh; /* Prend toute la hauteur de la fenêtre */
        }

        .navbar {
            margin-bottom: 30px;
        }

        .navbar a {
            color: white !important;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        /* Cadre du formulaire d'ajout d'utilisateur (similaire à login.php) */
        .form-container {
            padding: 10px;
            border-radius: 30px;
            margin-left: auto;
            margin-right: auto;
            background-color: rgba(0, 0, 0, 0.7); /* Fond semi-transparent */
            max-width: 1000px; /* Augmenter la largeur à 600px */
            margin-top: 10px; /* Ajout d'une marge pour centrer verticalement */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 3rem;
            color: darkturquoise;
        }

        .form-group label {
            color: darkturquoise;
            font-size: 1.4rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 20px;
            border: 6px solid #ddd;
            font-size: 1.3rem;
        }

        .form-control:focus {
            border-color: darkturquoise;
            box-shadow: 0 0 5px rgba(92, 184, 92, 0.7);
        }

        .btn-primary {
            background-color: darkturquoise;
            border-color: black;
            font-size: 1.1rem;
            padding: 10px 20px;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #4cae4c;
            border-color: black;
        }

        /* Message de confirmation ou d'erreur */
        .alert {
            padding: 20px;
            font-size: 1.3rem;
            margin-bottom: 20px;
            background-color: darksalmon;
        }
    </style>
</head>
<body>

    <!-- En-tête avec barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Veillez Ajouter un nouveau utilisateur</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#a-propos">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="login.php">Se Connecter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ajouter_utilisateur.php">Ajouter un utilisateur</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <section class="form-container">
            <h2>Ajouter un utilisateur</h2>

            <!-- Affichage du message (confirmation ou erreur) -->
            <?php if (isset($message)) : ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>

            <!-- Formulaire d'ajout d'utilisateur -->
            <form action="ajouter_utilisateur.php" method="POST">
                <div class="form-group">
                    <label for="identifiant">Identifiant :</label>
                    <input type="text" name="identifiant" id="identifiant" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="mot_de_passe">Mot de passe :</label>
                    <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="role_id">Rôle :</label>
                    <select name="role_id" id="role_id" class="form-control">
                        <option value="1">Administrateur</option>
                        <option value="2">Médecin</option>
                        <option value="3" selected>Secrétaire</option>
                        <!-- Ajouter d'autres rôles ici si nécessaire -->
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Ajouter l'utilisateur</button>
            </form>
        </section>
    </div>

    <!-- Script Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
