<?php
session_start();

require_once 'connection.php'; // conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Consulta o usuário no banco
    $stmt = $conn->prepare("SELECT id, senha_hash FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($row = $resultado->fetch_assoc()) {
        // Verifica a senha - supondo que senha_hash é hash gerado com password_hash()
        if (password_verify($senha, $row['senha_hash'])) {
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['usuario_nome'] = $usuario;

            header("Location: ../management.php");
            exit;
        } else {
            // senha incorreta
            header("Location: ../login.html?erro=senha");
            exit;
        }
    } else {
        // usuário não encontrado
        header("Location: ../login.html?erro=usuario");
        exit;
    }
} else {
    header("Location: ../login.html");
    exit;
}
?>
