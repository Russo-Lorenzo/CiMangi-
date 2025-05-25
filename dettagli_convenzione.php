<?php
require_once 'db.php';
require_once 'auth_middleware.php';

checkAuth();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare("SELECT * FROM Dettagli_Convenzione WHERE ID=?");
            $stmt->execute([$_GET['id']]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $pdo->query("SELECT * FROM Dettagli_Convenzione");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($data);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("INSERT INTO Dettagli_Convenzione (Max_Piatti_Principali, Max_Piatti_Secondari, Azienda_O_Ristorante) VALUES (?, ?, ?)");
        $result = $stmt->execute([
            $input['Max_Piatti_Principali'],
            $input['Max_Piatti_Secondari'],
            $input['Azienda_O_Ristorante']
        ]);
        echo json_encode(['success' => $result]);
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $input);
        $stmt = $pdo->prepare("UPDATE Dettagli_Convenzione SET Max_Piatti_Principali=?, Max_Piatti_Secondari=?, Azienda_O_Ristorante=? WHERE ID=?");
        $result = $stmt->execute([
            $input['Max_Piatti_Principali'],
            $input['Max_Piatti_Secondari'],
            $input['Azienda_O_Ristorante'],
            $input['ID']
        ]);
        echo json_encode(['success' => $result]);
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $stmt = $pdo->prepare("DELETE FROM Dettagli_Convenzione WHERE ID=?");
        $result = $stmt->execute([$id]);
        echo json_encode(['success' => $result]);
        break;
}
?>
