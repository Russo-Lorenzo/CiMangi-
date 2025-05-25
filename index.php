<?php
header('Content-Type: application/json');
$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
switch ($uri[2] ?? '') {
    case 'pietanza':
        require 'pietanza.php';
        break;
    case 'categoria':
        require 'categoria.php';
        break;
    case 'ristoranti':
        require 'ristoranti.php';
        break;
    case 'utenti':
        require 'utenti.php';
        break;
    case 'ordine':
        require 'ordine.php';
        break;
    case 'azienda':
        require 'azienda.php';
        break;
    case 'dettagli_convenzione':
        require 'dettagli_convenzione.php';
        break;
    case 'auth':
        require 'auth.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint non trovato']);
}
?>
