<?php
session_start();
header('Content-Type: application/json');
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Método inválido']);
    exit;
}

$usuario = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';

$stmt = $conn->prepare("SELECT id, senha_hash FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($row = $resultado->fetch_assoc()) {
    if (password_verify($senha, $row['senha_hash'])) {
        $_SESSION['usuario_id'] = $row['id'];
        $_SESSION['usuario_nome'] = $usuario;
        echo json_encode(['status' => 'ok', 'mensagem' => 'Login realizado com sucesso']);
        exit;
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Senha incorreta']);
        exit;
    }
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não encontrado']);
    exit;
}
?>
