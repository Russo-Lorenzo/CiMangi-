<?php
$host = 'localhost';
$db   = 'Cimangi';
$user = 'root'; // Cambia se hai una password diversa
$pass = '';     // Cambia se hai una password diversa

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}
?>