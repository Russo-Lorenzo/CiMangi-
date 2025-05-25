<?php
require_once 'db.php';

function checkAuth() {
	 global $pdo;
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Token mancante']);
        exit;
    }
    $token = $headers['Authorization'];
    $stmt = $pdo->prepare("SELECT * FROM Token WHERE Valore=?");
    $stmt->execute([$token]);
    if (!$stmt->fetch()) {
        http_response_code(401);
        echo json_encode(['error' => 'Token non valido']);
        exit;
    }
}
?>
