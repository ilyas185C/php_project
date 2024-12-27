<?php
$servename = 'localhost';
$username = 'root';
$password = '';
$dbname = 'gestionproduit_v2';  
try {
    $conn = new PDO("mysql:host=$servename;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
