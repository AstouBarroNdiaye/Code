<?php
// edit_patient.php : Modifier les informations d'un patient

session_start();
require_once('db.php');

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Récupérer l'ID du patient depuis l'URL
if (isset($_GET['id'])) {
    $id_patient = $_GET['id'];

    // Requête pour récupérer les informations du patient
    $sql = "SELECT * FROM patients WHERE id_patient = :id_patient";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_patient', $id_patient);
    $stmt->execute();
    $patient = $stmt->fetch();
} else {
    echo "Aucun ID de patient spécifié.";
    exit;
}

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $sexe = $_POST['sexe'];
    $adresse = $_POST['adresse'];
    $etat_general = $_POST['etat_general'];
    $diagnostic = $_POST['diagnostic'];
    $traitement = $_POST['traitement'];

    // Requête SQL pour mettre à jour les informations du patient
    $sql = "UPDATE patients SET nom = :nom, prenom = :prenom, age = :age, sexe = :sexe, adresse = :adresse, etat_general = :etat_general, diagnostic = :diagnostic, traitement = :traitement WHERE id_patient = :id_patient";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':sexe', $sexe);
    $stmt->bindParam(':adresse', $adresse);
    $stmt->bindParam(':etat_general', $etat_general);
    $stmt->bindParam(':diagnostic', $diagnostic);
    $stmt->bindParam(':traitement', $traitement);
    $stmt->bindParam(':id_patient', $id_patient);
    $stmt->execute();

    header("Location: index.php"); // Rediriger vers la page d'accueil après la mise à jour
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Patient</title>
</head>
<body>
    <header>
        <h1>Modifier le Dossier du Patient</h1>
        <nav>
            <a href="index.php">Retour à la liste des patients</a>
        </nav>
    </header>
    
    <section>
        <h2>Formulaire de Modification</h2>
        <form method="POST">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($patient['nom']); ?>" required><br>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($patient['prenom']); ?>" required><br>

            <label for="age">Âge :</label>
            <input type="number" id="age" name="age" value="<?= $patient['age']; ?>" required><br>

            <label for="sexe">Sexe :</label>
            <select name="sexe" id="sexe" required>
                <option value="Homme" <?= $patient['sexe'] == 'Homme' ? 'selected' : ''; ?>>Homme</option>
                <option value="Femme" <?= $patient['sexe'] == 'Femme' ? 'selected' : ''; ?>>Femme</option>
            </select><br>

            <label for="adresse">Adresse :</label>
            <textarea id="adresse" name="adresse" required><?= htmlspecialchars($patient['adresse']); ?></textarea><br>

            <label for="etat_general">État Général :</label>
            <textarea id="etat_general" name="etat_general" required><?= htmlspecialchars($patient['etat_general']); ?></textarea><br>

            <label for="diagnostic">Diagnostic :</label>
            <textarea id="diagnostic" name="diagnostic" required><?= htmlspecialchars($patient['diagnostic']); ?></textarea><br>

            <label for="traitement">Traitement :</label>
            <textarea id="traitement" name="traitement" required><?= htmlspecialchars($patient['traitement']); ?></textarea><br>

            <button type="submit">Mettre à jour le patient</button>
        </form>
    </section>
</body>
</html>
