<?php
// delete_patient.php : Supprimer un patient

session_start();
require_once('db.php');

if (isset($_GET['id'])) {
    $id_patient = $_GET['id'];

    // Requête SQL pour supprimer un patient
    $sql = "DELETE FROM patients WHERE id_patient = :id_patient";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_patient', $id_patient);
    $stmt->execute();

    header("Location:dashboard.php");
    exit;
} else {
    echo "ID patient non spécifié.";
}
?>