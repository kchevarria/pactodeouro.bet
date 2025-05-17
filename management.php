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

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="d-flex flex-column">
    <div class="d-flex justify-content-end align-items-center m-3">
        <span id="user" class="me-3 text-secondary">
            Olá <?php echo $_SESSION['usuario_nome'] ?>
        </span>
        <button class="btn btn-sm btn-danger" onclick="logout()">
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
                    <tbody id="plataformas">
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
            <div class="card-footer d-flex justify-content-end align-items-center">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="bi bi-plus-lg pe-2"></i> Nova plataforma
                </button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cadastroPlataforma" tabindex="-1" aria-labelledby="cadastroPlataformaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cadastroPlataformaLabel">Cadastro de Plataforma</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="" id="" class="form-control">
                    <input type="number" name="" id="" class="form-control">
                    <input type="text" name="" id="" class="form-control">
                    <input type="file" name="" id="" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Descartar</button>
                    <button type="button" class="btn btn-primary">Salvar</button>
                </div>
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
        function logout() {
            window.location.href = "./controller/logout.php";
        }

        function gerenciarPlataformas() {
            $.ajax({
                url: "controller/backend.php",
                type: 'POST',
                data: {
                    action: 'gerenciarPlataformas'
                },
                dataType: 'json',
                success: function(retorno) {
                    console.log(retorno);
                    switch (retorno.success) {
                        case 1:
                            $("#plataformas").html(retorno.dados);
                            break;
                        default:
                            $("#plataformas").html(retorno.msg);
                            break;
                    }
                    // $("#plataformas").html(retorno.dados);
                },
                error: function(xhr, status, error) {
                    console.error("Erro AJAX:", xhr.responseText || error);
                }
            });
        }

        $(document).ready(function() {
            gerenciarPlataformas();
            infoUser();
        })
    </script>
</body>

</html>