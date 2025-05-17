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
    case 'gerenciarPlataformas':
        gerenciarPlataformas($conn);
        break;
    default:
        echo json_encode(['status' => 'erro', 'mensagem' => 'Ação inválida.']);
        break;
}

function listarPlataformas($conn) {
    $sql = "SELECT id, nome, ordem, link, logo FROM plataformas ORDER BY ordem, nome";
    $result = $conn->query($sql);

    if (!$result) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao consultar plataformas.']);
        return;
    }

    if ($result->num_rows === 0) {
        echo json_encode(['status' => 'vazio', 'mensagem' => 'Não há plataformas cadastradas.']);
        return;
    }

    $plataformas = [];
    while ($row = $result->fetch_assoc()) {
        $plataformas[] = $row;
    }

    echo json_encode(['status' => 'ok', 'dados' => $plataformas]);
}


function gerenciarPlataformas($conn) {
    $retorno = [];
    $sql = "SELECT id, nome, ordem, link, logo FROM plataformas ORDER BY ordem, nome";
    $result = $conn->query($sql);

    if (!$result) {
        $retorno['success'] = 0;
        $retorno['msg'] = "Erro ao consultar plataformas.";
        // echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao consultar plataformas.']);
        echo json_encode($retorno);
        return;
    }

    if ($result->num_rows === 0) {
        $retorno['success'] = 0;
        $retorno['msg'] = "Não há plataformas cadastradas.";
        // echo json_encode(['status' => 'vazio', 'mensagem' => 'Não há plataformas cadastradas.']);
        echo json_encode($retorno);
        return;
    }

    $plataformas = [];
    while ($row = $result->fetch_assoc()) {
        $plataformas[] = $row;
    }

    $retorno['success'] = 0;
    $retorno['msg'] = "Dados obtidos.";
    $retorno['dados'] = $plataformas;
    // echo json_encode(['status' => 'ok', 'dados' => $plataformas]);
    echo json_encode($retorno);
}