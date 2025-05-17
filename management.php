<?php
// session_start();
// if (!isset($_SESSION['usuario_id'])) {
//     header("Location: login.html");
//     exit;
// }
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