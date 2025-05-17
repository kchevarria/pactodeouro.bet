<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require_once 'connection.php'; // inclui conexão

if (!isset($_POST['action'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Ação não especificada.']);
    exit;
}

switch ($_POST['action']) {
    case 'listarPlataformas':
        listarPlataformas($conn);
        break;

    default:
        echo json_encode(['status' => 'erro', 'mensagem' => 'Ação inválida.']);
        break;
}

function listarPlataformas($conn) {
    echo json_encode(['status' => 'ok', 'mensagem' => 'Função chamada com sucesso']);
}
