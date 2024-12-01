<?php 
// add_patient.php : Ajouter un nouveau patient
session_start();
require_once('db.php');
// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $sexe = $_POST['sexe'];
    $adresse = $_POST['adresse'];
    $etat_general = $_POST['etat_general'];
    $diagnostic = $_POST['diagnostic'];
    $traitement = $_POST['traitement'];

    // Requête SQL pour insérer un patient
    $sql = "INSERT INTO patients (nom, prenom, age, sexe, adresse, etat_general, diagnostic, traitement) VALUES (:nom, :prenom, :age, :sexe, :adresse, :etat_general, :diagnostic, :traitement)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':sexe', $sexe);
    $stmt->bindParam(':adresse', $adresse);
    $stmt->bindParam(':etat_general', $etat_general);
    $stmt->bindParam(':diagnostic', $diagnostic);
    $stmt->bindParam(':traitement', $traitement);
    $stmt->execute();

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Nouveau Patient</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Arrière-plan */
        body {
            background: url('images/dental-background.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Fond sombre pour améliorer la lisibilité */
            z-index: -1;
        }

        /* Formulaire de ajout patient */
        .form-container {
            background: rgba(255, 255, 255, 0.8); /* Fond clair avec transparence */
            margin: 50px auto;
            padding: 30px;
            width: 80%;
            max-width: 800px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007bff; /* Bleu dentaire */
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        label {
            font-size: 1.2rem;
            color: #333;
            display: block;
            margin-bottom: 8px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            background-color: #f9f9f9;
        }

        input[type="text"], input[type="number"], select {
            height: 40px;
        }

        button {
            background-color: #28a745; /* Vert santé */
            color: #fff;
            padding: 12px 20px;
            font-size: 1.2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: #218838;
        }

        /* Slogan */
        .slogan {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
            margin-top: 30px;
        }

        /* Responsivité */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
                margin: 20px;
            }

            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

    <div class="overlay"></div>

    <div class="form-container">
        <h1>Ajouter un Nouveau Patient</h1>
        <form method="POST">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
            
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
            
            <label for="age">Âge :</label>
            <input type="number" id="age" name="age" required>
            
            <label for="sexe">Sexe :</label>
            <select name="sexe" id="sexe">
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
            </select>
            
            <label for="adresse">Adresse :</label>
            <textarea id="adresse" name="adresse" required></textarea>
            
            <label for="etat_general">État Général :</label>
            <textarea id="etat_general" name="etat_general" required></textarea>
            
            <label for="diagnostic">Diagnostic :</label>
            <textarea id="diagnostic" name="diagnostic" required></textarea>
            
            <label for="traitement">Traitement :</label>
            <textarea id="traitement" name="traitement" required></textarea>
            
            <button type="submit">Ajouter le Patient</button>
        </form>
        
        <div class="slogan">
            "Prenez soin de vos dents, préservez votre sourire"
        </div>
    </div>

</body>
</html>
