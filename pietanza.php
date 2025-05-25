<?php
require_once 'db.php';
require_once 'auth_middleware.php';

checkAuth();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare("SELECT * FROM Pietanza WHERE ID=?");
            $stmt->execute([$_GET['id']]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $pdo->query("SELECT * FROM Pietanza");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($data);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("INSERT INTO Pietanza (ID_Categoria, Nome, Prezzo, Descrizione, Piatto_Del_Giorno) VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([
            $input['ID_Categoria'],
            $input['Nome'],
            $input['Prezzo'],
            $input['Descrizione'],
            $input['Piatto_Del_Giorno']
        ]);
        echo json_encode(['success' => $result]);
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $input);
        $stmt = $pdo->prepare("UPDATE Pietanza SET ID_Categoria=?, Nome=?, Prezzo=?, Descrizione=?, Piatto_Del_Giorno=? WHERE ID=?");
        $result = $stmt->execute([
            $input['ID_Categoria'],
            $input['Nome'],
            $input['Prezzo'],
            $input['Descrizione'],
            $input['Piatto_Del_Giorno'],
            $input['ID']
        ]);
        echo json_encode(['success' => $result]);
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $stmt = $pdo->prepare("DELETE FROM Pietanza WHERE ID=?");
        $result = $stmt->execute([$id]);
        echo json_encode(['success' => $result]);
        break;
}
?>
