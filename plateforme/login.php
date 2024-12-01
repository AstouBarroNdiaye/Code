<?php
// login.php : Page de connexion

session_start();
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification de l'authentification
    $identifiant = $_POST['identifiant'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Requête SQL pour vérifier les identifiants
    $sql = "SELECT * FROM utilisateurs WHERE identifiant = :identifiant";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->execute();

    $user = $stmt->fetch();

    // Si l'utilisateur existe et le mot de passe est correct
    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id_utilisateur'];
        $_SESSION['role'] = $user['id_role'];
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Identifiants incorrects!";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Cabinet Dentaire</title>
    <!-- Lien vers la dernière version de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('image_cabinet.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            color: #fff;
            margin: 0;
            height: 100vh; /* Prend toute la hauteur de la fenêtre */
        }

        /* Style de la page de connexion */
        .login-section {
            padding: 60px;
            border-radius: 30px;
            margin-left: auto;
            margin-right: auto;
            background-color: rgba(0, 0, 0, 0.7); /* Fond semi-transparent */
            max-width: 1000px;
            margin-top: 30px; /* Ajout d'une marge pour centrer verticalement */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 3rem;
            color: darkturquoise;
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

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        /* Message d'erreur */
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
            <a class="navbar-brand" href="#">Veillez vous connecter pour accéder aux données des patients</a>
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

    <!-- Formulaire de connexion -->
    <div class="container">
        <section class="login-section">
            <h2 class="text-center">Connexion</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="identifiant" class="form-label">Identifiant</label>
                    <input type="text" class="form-control" id="identifiant" name="identifiant" required>
                </div>
                <div class="mb-3">
                    <label for="mot_de_passe" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>

            <!-- Message d'erreur -->
            <?php if (isset($message)) { echo "<p class='error-message'>$message</p>"; } ?>
        </section>
    </div>

    <!-- Script Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


