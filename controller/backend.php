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
    case 'retornaPlataforma':
        retornaPlataforma($conn);
        break;
    case 'salvarPlataforma':
        salvarPlataforma($conn);
        break;
    default:
        echo json_encode(['status' => 'erro', 'mensagem' => 'Ação inválida.']);
        break;
}

function listarPlataformas($conn)
{
    $sql = "SELECT id, nome, link, logo, ordem FROM plataformas ORDER BY ordem ASC";
    $result = $conn->query($sql);

    $plataformas = [];
    while ($row = $result->fetch_assoc()) {
        $plataformas[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($plataformas);
    exit;
}



function gerenciarPlataformas($conn)
{
    $retorno = [];
    $sql = "SELECT id, nome, ordem, link, logo FROM plataformas ORDER BY ordem, nome";
    $result = $conn->query($sql);

    if (!$result) {
        $retorno['success'] = 0;
        $retorno['msg'] = "Erro ao consultar plataformas.";
        echo json_encode($retorno);
        return;
    }

    if ($result->num_rows === 0) {
        $retorno['success'] = 0;
        $retorno['msg'] = "Não há plataformas cadastradas.";
        echo json_encode($retorno);
        return;
    }

    $plataformas = [];
    while ($row = $result->fetch_assoc()) {
        $plataformas[] = $row;
    }

    $retorno['success'] = 1;
    $retorno['msg'] = "Dados obtidos.";
    $retorno['dados'] = $plataformas;
    echo json_encode($retorno);
}

function retornaPlataforma($conn)
{
    $retorno = [];
    $id = $_POST['id'];
    $sql = "SELECT * FROM plataformas WHERE id = {$id}";
    $result = $conn->query($sql);

    if (!$result) {
        $retorno['success'] = 0;
        $retorno['msg'] = "Erro ao consultar plataforma.";
        echo json_encode($retorno);
        return;
    }

    if ($result->num_rows === 0) {
        $retorno['success'] = 0;
        $retorno['msg'] = "Não foi possível buscar os dados da plataforma.";
        echo json_encode($retorno);
        return;
    }

    $plataforma = $result->fetch_assoc(); // apenas UM registro

    $retorno['success'] = 1;
    $retorno['msg'] = "Dados obtidos.";
    $retorno['dados'] = $plataforma;
    echo json_encode($retorno);
}

function salvarPlataforma($conn)
{
    $retorno = [];

    $id = $_POST['id'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $ordem = $_POST['ordem'] ?? '';
    $link = $_POST['link'] ?? '';

    // Upload do logo, se existir
    $logo = '';
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid('logo_') . '.' . $ext;
        $pastaImagens = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'images';

        if (!is_dir($pastaImagens)) {
            mkdir($pastaImagens, 0755, true);
        }

        $destino = $pastaImagens . DIRECTORY_SEPARATOR . $nomeArquivo;


        if (!move_uploaded_file($_FILES['logo']['tmp_name'], $destino)) {
            $retorno['success'] = 0;
            $retorno['msg'] = 'Falha ao salvar o arquivo de logo.';
            echo json_encode($retorno);
            return;
        }

        $logo = $nomeArquivo;
    }

    if (empty($id)) {
        // INSERT
        $stmt = $conn->prepare("INSERT INTO plataformas (nome, ordem, link, logo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $nome, $ordem, $link, $logo);
    } else {
        if ($logo !== '') {
            // UPDATE com logo
            $stmt = $conn->prepare("UPDATE plataformas SET nome = ?, ordem = ?, link = ?, logo = ? WHERE id = ?");
            $stmt->bind_param("sissi", $nome, $ordem, $link, $logo, $id);
        } else {
            // UPDATE sem alterar logo
            $stmt = $conn->prepare("UPDATE plataformas SET nome = ?, ordem = ?, link = ? WHERE id = ?");
            $stmt->bind_param("sisi", $nome, $ordem, $link, $id);
        }
    }

    if ($stmt->execute()) {
        $retorno['success'] = 1;
        $retorno['msg'] = 'Dados salvos com sucesso.';
    } else {
        $retorno['success'] = 0;
        $retorno['msg'] = 'Erro ao salvar no banco de dados.';
    }

    echo json_encode($retorno);
}
