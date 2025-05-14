<?php
require_once 'db.php';

function login($id, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM Utenti WHERE ID=? AND Password=?");
    $stmt->execute([$id, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $insert = $pdo->prepare("INSERT INTO Token (Valore) VALUES (?)");
        $insert->execute([$token]);
        return $token;
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $token = login($input['ID'], $input['Password']);
    if ($token) {
        echo json_encode(['token' => $token]);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Credenziali non valide']);
    }
}
?>
