<?php
require_once 'db.php';
require_once 'auth_middleware.php';

checkAuth();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare("SELECT * FROM Utenti WHERE ID=?");
            $stmt->execute([$_GET['id']]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $pdo->query("SELECT * FROM Utenti");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($data);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("INSERT INTO Utenti (Password, ID_Ristorante, ID_Azienda) VALUES (?, ?, ?)");
        $result = $stmt->execute([
            $input['Password'],
            $input['ID_Ristorante'] ?? null,
            $input['ID_Azienda'] ?? null
        ]);
        echo json_encode(['success' => $result]);
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $input);
        $stmt = $pdo->prepare("UPDATE Utenti SET Password=?, ID_Ristorante=?, ID_Azienda=? WHERE ID=?");
        $result = $stmt->execute([
            $input['Password'],
            $input['ID_Ristorante'],
            $input['ID_Azienda'],
            $input['ID']
        ]);
        echo json_encode(['success' => $result]);
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $stmt = $pdo->prepare("DELETE FROM Utenti WHERE ID=?");
        $result = $stmt->execute([$id]);
        echo json_encode(['success' => $result]);
        break;
}
?>
