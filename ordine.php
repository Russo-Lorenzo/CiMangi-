<?php
require_once 'db.php';
require_once 'auth_middleware.php';

checkAuth();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare("SELECT * FROM Ordine WHERE ID=?");
            $stmt->execute([$_GET['id']]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $pdo->query("SELECT * FROM Ordine");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($data);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("INSERT INTO Ordine (ID_Dipendente, Data_Inserimento, Azienda_O_Ristorante, Dettagli_Ristorante, Apertura_Ordinazioni, Chiusura_Ordinazioni, Commento, Annullato, Aperte_Automaticamente, Annullabile) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $result = $stmt->execute([
            $input['ID_Dipendente'],
            $input['Data_Inserimento'],
            $input['Azienda_O_Ristorante'],
            $input['Dettagli_Ristorante'],
            $input['Apertura_Ordinazioni'],
            $input['Chiusura_Ordinazioni'],
            $input['Commento'],
            $input['Annullato'],
            $input['Aperte_Automaticamente'],
            $input['Annullabile']
        ]);
        echo json_encode(['success' => $result]);
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $input);
        $stmt = $pdo->prepare("UPDATE Ordine SET ID_Dipendente=?, Data_Inserimento=?, Azienda_O_Ristorante=?, Dettagli_Ristorante=?, Apertura_Ordinazioni=?, Chiusura_Ordinazioni=?, Commento=?, Annullato=?, Aperte_Automaticamente=?, Annullabile=? WHERE ID=?");
        $result = $stmt->execute([
            $input['ID_Dipendente'],
            $input['Data_Inserimento'],
            $input['Azienda_O_Ristorante'],
            $input['Dettagli_Ristorante'],
            $input['Apertura_Ordinazioni'],
            $input['Chiusura_Ordinazioni'],
            $input['Commento'],
            $input['Annullato'],
            $input['Aperte_Automaticamente'],
            $input['Annullabile'],
            $input['ID']
        ]);
        echo json_encode(['success' => $result]);
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $stmt = $pdo->prepare("DELETE FROM Ordine WHERE ID=?");
        $result = $stmt->execute([$id]);
        echo json_encode(['success' => $result]);
        break;
}
?>
