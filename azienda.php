<?php
require_once 'db.php';
require_once 'auth_middleware.php';

checkAuth();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare("SELECT * FROM Azienda WHERE ID=?");
            $stmt->execute([$_GET['id']]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $pdo->query("SELECT * FROM Azienda");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($data);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("INSERT INTO Azienda (Nome, Indirizzo, Citta, ID_Responsabile) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([
            $input['Nome'],
            $input['Indirizzo'],
            $input['Citta'],
            $input['ID_Responsabile']
        ]);
        echo json_encode(['success' => $result]);
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $input);
        $stmt = $pdo->prepare("UPDATE Azienda SET ID_Responsabile=?, Nome=?, Indirizzo=?, Citta=? WHERE ID=?");
        $result = $stmt->execute([
            $input['ID_Responsabile'],
            $input['Nome'],
            $input['Indirizzo'],
            $input['Citta'],
            $input['ID']
        ]);
        echo json_encode(['success' => $result]);
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $stmt = $pdo->prepare("DELETE FROM Azienda WHERE ID=?");
        $result = $stmt->execute([$id]);
        echo json_encode(['success' => $result]);
        break;
}
?>
