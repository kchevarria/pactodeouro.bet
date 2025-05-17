<?php
// session_start();
// if (!isset($_SESSION['usuario_id'])) {
//     header("Location: login.html");
//     exit;
// }
?>
<?php
require_once 'controller/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['criarUsuario'])) {
    $usuario = trim($_POST['usuario']);
    $senha = $_POST['senha'];

    if (empty($usuario) || empty($senha)) {
        $mensagem = "Usuário e senha são obrigatórios.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $mensagem = "Usuário já existe.";
        } else {
            $stmt->close();
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO usuarios (usuario, senha_hash) VALUES (?, ?)");
            $stmt->bind_param("ss", $usuario, $senha_hash);

            if ($stmt->execute()) {
                $mensagem = "Usuário criado com sucesso.";
            } else {
                $mensagem = "Erro ao criar usuário.";
            }
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MGMT</title>
</head>
<body>
    <h2>Criar primeiro usuário</h2>
    <?php if (isset($mensagem)) echo "<p><strong>$mensagem</strong></p>"; ?>

    <form method="POST">
    <label for="usuario">Usuário:</label><br>
    <input type="text" id="usuario" name="usuario" required><br><br>

    <label for="senha">Senha:</label><br>
    <input type="password" id="senha" name="senha" required><br><br>

    <button type="submit" name="criarUsuario">Criar usuário</button>
    </form>
</body>
</html>