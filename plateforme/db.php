<?php 
// db.php : Connexion à la base de données avec PDO

// Paramètres de connexion à la base de données
$host = 'localhost'; // Adresse du Serveur de base de données (127.0.0.1 ou localhost)
$dbname = 'plateforme'; // Nom de la base de données
$username = 'root'; // Nom d'utilisateur (par défaut sur XAMPP : root)
$password = ''; // Mot de passe (par défaut sur XAMPP il est vide)


// DSN pour la connexion PDO
$dsn = "mysql:host=$host;dbname=$dbname";

$options =
[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Essaie de se connecter à la base de données avec PDO
try
{
    $pdo = new PDO($dsn, $username, $password, $options);
    //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
}   
catch (PDOException $e)
{
    // Afficher l'erreur si la connexion échoue
    die("La connexion a échoué : " . $e->getMessage());
    //throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>

