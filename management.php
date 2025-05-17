<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.html");
    exit;
}

// require_once 'controller/connection.php'; // Descomente se precisar de conexão com o banco
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Área de Gerenciamento</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        .logout-btn {
            display: inline-block;
            margin-bottom: 1rem;
            padding: 0.5rem 1rem;
            background-color: #c00;
            color: #fff;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        form {
            margin-top: 2rem;
            padding: 1rem;
            background-color: #f4f4f4;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<h1>Bem-vindo à Área de Gerenciamento</h1>

<a href="controller/logout.php" class="logout-btn">Sair</a>

<hr>

<h2>Painel de Administração</h2>
<p>Aqui você pode adicionar as funcionalidades do sistema.</p>

<!-- 
<h3>Criar novo usuário (uso temporário)</h3>
<form method="POST">
    <label for="novo_usuario">Usuário:</label><br>
    <input type="text" id="novo_usuario" name="novo_usuario" required><br><br>

    <label for="nova_senha">Senha:</label><br>
    <input type="password" id="nova_senha" name="nova_senha" required><br><br>

    <button type="submit" name="criar_usuario">Criar Usuário</button>
</form>

<?php
/*
if (isset($_POST['criar_usuario'])) {
    require_once 'controller/connection.php';

    $usuario = trim($_POST['novo_usuario']);
    $senha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (usuario, senha) VALUES (?, ?)");
    $stmt->bind_param("ss", $usuario, $senha);

    if ($stmt->execute()) {
        echo "<p>Usuário criado com sucesso!</p>";
    } else {
        echo "<p>Erro ao criar usuário: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
*/
?>
-->

</body>
</html>
