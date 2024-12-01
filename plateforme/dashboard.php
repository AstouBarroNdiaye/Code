<?php
session_start(); // Démarre la session

// Vérification de l'utilisateur s'il est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirection vers la page login.php si non connecté
    exit();
}

// Connexion à la base de données
require_once 'db.php';

// Récupération de la liste des patients
$sql = "SELECT * FROM patients";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$patients = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <style>
        /* Arrière-plan de la page */
        body {
            background: url('image_cabinet.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            color: #fff;
        }

        /* Filtre de transparence sur l'arrière-plan */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Fond sombre pour rendre le texte lisible */
            z-index: -1;
        }

        /* Conteneur du tableau de bord */
        .dashboard-container {
            max-width: 2000px;
            margin: auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9); /* Fond semi-transparent */
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            justify-content: center;
        }

        h2 {
            color: #007bff; /* Bleu dentaire */
            font-size: 3rem;
            margin-bottom: 30px;
        }

        h3 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #343a40; /* Gris foncé pour le texte */
        }

        a.btn {
            display: inline-block;
            padding: 12px 20px;
            margin: 10px;
            background-color: #28a745; /* Vert santé */
            color: #fff;
            font-size: 1.2rem;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a.btn:hover {
            background-color: #218838; /* Vert plus foncé */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #007bff; /* Bleu dentaire */
            color: #fff;
        }

        td {
            background-color: #f9f9f9;
            color: #333; /* Texte plus sombre pour améliorer la lisibilité */
        }

        /* Slogan */
        .slogan {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff; /* Bleu dentaire */
            margin-top: 50px;
        }

        /* Responsivité */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 20px;
            }

            h2 {
                font-size: 2rem;
            }

            h3 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="overlay"></div>

    <div class="dashboard-container">
        <h2>Bienvenue sur le tableau de bord dentaire</h2>

        <!-- Boutons pour gérer les patients -->
        <div>
            <a href="add_patient.php" class="btn">Ajouter un patient</a>
            <a href="edit_patient.php" class="btn">Modifier un patient</a>
            <a href="delete_patient.php" class="btn">Supprimer un patient</a>
        </div>

        <!-- Liste des patients -->
        <h3>Liste des patients</h3>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Âge</th>
                    <th>Adresse</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?= htmlspecialchars($patient['nom']) ?></td>
                        <td><?= htmlspecialchars($patient['prenom']) ?></td>
                        <td><?= htmlspecialchars($patient['age']) ?></td>
                        <td><?= htmlspecialchars($patient['adresse']) ?></td>

                        <td>
                            <a href="edit_patient.php?id=<?= $patient['id'] ?>" class="btn btn-warning">Modifier</a>
                            <a href="delete_patient.php?id=<?= $patient['id'] ?>" class="btn btn-danger">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Slogan dentaire -->
        <div class="slogan">"Prenez soin de vos dents, prenez soin de votre sourire"</div>
    </div>

</body>
</html>
