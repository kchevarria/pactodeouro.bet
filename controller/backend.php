<?php
header('Content-Type: application/json');

// Verifica se veio a ação via POST
if (!isset($_POST['action'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Ação não especificada.']);
    exit;
}

require_once 'connection.php'; // Inclui a conexão ao banco

switch ($_POST['action']) {
    case 'listarPlataformas':
        listarPlataformas($conn);
        break;

    default:
        echo json_encode(['status' => 'erro', 'mensagem' => 'Ação inválida.']);
        break;
}

// Funções
function listarPlataformas($conn) {
    // $sql = "SELECT id, nome FROM plataformas ORDER BY nome";
    // $result = $conn->query($sql);

    // if (!$result) {
    //     echo json_encode(['status' => 'erro', 'mensagem' => 'Erro na consulta.']);
    //     return;
    // }

    // $plataformas = [];
    // while ($row = $result->fetch_assoc()) {
    //     $plataformas[] = $row;
    // }

    // echo json_encode(['status' => 'ok', 'dados' => $plataformas]);
    echo json_encode("foi");
}
?>
