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
    <link rel="shortcut icon" href="./images/ouro.png" type="image/x-icon">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-DQvkBjpPgn7RC31MCQoOeC9TI2kdqa4+BSgNMNj8v77fdC77Kj5zpWFTJaaAoMbC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-YUe2LzesAfftltw+PEaao2tjU/QATaW/rOitAq67e0CT0Zi2VVRL0oC4+gAaeBKu" crossorigin="anonymous"></script>
</head>
<head>
    <meta charset="UTF-8">
    <title>Área de Gerenciamento</title>
    <link rel="shortcut icon" href="./images/ouro.png" type="image/x-icon">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-DQvkBjpPgn7RC31MCQoOeC9TI2kdqa4+BSgNMNj8v77fdC77Kj5zpWFTJaaAoMbC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-YUe2LzesAfftltw+PEaao2tjU/QATaW/rOitAq67e0CT0Zi2VVRL0oC4+gAaeBKu" crossorigin="anonymous"></script>

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="d-flex flex-column">
    <div class="d-flex justify-content-end m-3">
         <span class="me-3 text-secondary" onclick="logout()">
            Olá Fulano
        </span>
        <button class="btn btn-sm btn-danger">
            Sair
        </button>
    </div>
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="h2">Gerenciamento</div>
        <hr>
        <div class="card">
            <div class="card-header">Plataformas</div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>top</td>
                            <td>nome</td>
                            <td>link</td>
                            <td><i class="bi bi-pencil-square"></i></td>
                        </tr>
                        <tr>
                            <td>top</td>
                            <td>nome</td>
                            <td>link</td>
                            <td>edição</td>
                        </tr>
                        <tr>
                            <td>top</td>
                            <td>nome</td>
                            <td>link</td>
                            <td>edição</td>
                        </tr>
                        <tr>
                            <td>top</td>
                            <td>nome</td>
                            <td>link</td>
                            <td>edição</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
    <script>
        function logout(){
            window.location.href = ".controller/logout.php";
        }
    </script>
</body>
</html>
