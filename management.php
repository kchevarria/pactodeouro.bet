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
<style>
    #spin i {
        font-size: 3rem;
        /* aumenta o tamanho do ícone */
        animation: girar 2s linear infinite;
        /* animação contínua girando */
    }

    @keyframes girar {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>

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
        <div class="card w-75">
            <div class="card-header">Plataformas</div>
            <div class="card-body overflow-auto" style="max-height: 70vh;">
                <table class="table table-striped table-hover m-0" id="table_plataformas">
                    <thead class="text-center">
                        <th>Nome</th>
                        <th>Ordem</th>
                        <th>Link</th>
                        <th>Logo</th>
                        <th>Edição</th>
                    </thead>
                    <tbody id="plataformas">

                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end align-items-center">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" onclick="editarPlataforma(null)">
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
                    <h1 class="modal-title fs-5" id="cadastroPlataformaLabel">Cadastro de plataforma</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column gap-2">
                    <div>
                        <input type="hidden" id="id">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" class="form-control">
                    </div>
                    <div>
                        <label for="ordem">Ordem:</label>
                        <input type="number" id="ordem" class="form-control">
                    </div>
                    <div>
                        <label for="link">Link:</label>
                        <input type="text" id="link" class="form-control">
                    </div>
                    <div>
                        <label for="logo">Logo:</label>
                        <input type="file" id="logo" class="form-control">
                    </div>
                    <div class="row d-none" id="spin">
                        <span class="d-flex justify-content-center">
                            <i class="bi bi-arrow-repeat text-secondary"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Descartar</button>
                    <button type="button" id="btnSalvar" class="btn btn-primary" onclick="salvarPlataforma()">Salvar</button>
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
        const backend = "controller/backend.php";

        function logout() {
            window.location.href = "./controller/logout.php";
        }

        function gerenciarPlataformas() {
            $.ajax({
                url: backend,
                type: 'POST',
                data: {
                    action: 'gerenciarPlataformas'
                },
                dataType: 'json',
                success: function(retorno) {
                    console.log(retorno);
                    switch (retorno.success) {
                        case 1:
                            let html = "";
                            retorno.dados.forEach(function(plataforma, index) {
                                html += `
                                    <tr>
                                        <td>
                                            ${plataforma.nome}
                                        </td>
                                        <td>
                                            ${plataforma.ordem}
                                        </td>
                                        <td>
                                            <a href="${plataforma.link}" target="_blank">
                                                ${plataforma.link}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <img src="../images/${plataforma.logo}" alt="Logo" style="height: 30px;">
                                        </td>
                                        <td class="d-flex justify-content-center align-items-center">
                                            <button class="btn btn-sm btn-warning" onclick="editarPlataforma(${plataforma.id})">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });
                            $("#plataformas").html(html);
                            break;
                        default:
                            // $("#table_plataformas").html(retorno.msg);
                            $("#table_plataformas").html(`
                            <div class="alert alert-warning text-center m-0" role="alert">
                                ${retorno.msg}
                            </div>
                            `);
                            break;
                    }
                    // $("#plataformas").html(retorno.dados);
                },
                error: function(xhr, status, error) {
                    console.error("Erro AJAX:", xhr.responseText || error);
                }
            });
        }

        function editarPlataforma(id) {
            
            if (id === null || id === '') {
                $("#id").val('');
                $("#nome").val('');
                $("#ordem").val('');
                $("#link").val('');
                $("#logo").val('');
                $("#logo").next(".form-text").remove();
                $("#cadastroPlataforma").modal("show");
                $("#nome").focus();
            } else {
                $.ajax({
                    url: backend,
                    type: 'POST',
                    data: {
                        action: 'retornaPlataforma',
                        id: id
                    },
                    dataType: 'json',
                    success: function(retorno) {
                        console.log(retorno);

                        if (retorno.success === 1) {
                            const dados = retorno.dados;

                            $("#id").val(dados.id);
                            $("#nome").val(dados.nome);
                            $("#ordem").val(dados.ordem);
                            $("#link").val(dados.link);

                            // input type="file" não pode receber valor via JavaScript
                            $("#logo").val('');
                            $("#logo").next(".form-text").remove(); // limpa mensagens anteriores
                            if (dados.logo) {
                                $("#logo").after(`<div class="form-text">Logo atual: ${dados.logo}</div>`);
                            }

                            $("#cadastroPlataforma").modal("show");
                        } else {
                            alert(retorno.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro AJAX:", xhr.responseText || error);
                    }
                });
            }
        }


        function salvarPlataforma() {
            $("#btnSalvar").addClass("disabled");
            $("#spin").removeClass("d-none");
            const formData = new FormData();
            formData.append("action", "salvarPlataforma");
            formData.append("id", $("#id").val());
            formData.append("nome", $("#nome").val());
            formData.append("ordem", $("#ordem").val());
            formData.append("link", $("#link").val());

            const logoInput = $("#logo")[0];
            if (logoInput.files.length > 0) {
                formData.append("logo", logoInput.files[0]);
            }

            $.ajax({
                url: backend,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(retorno) {
                    if (retorno.success === 1) {
                        $("#spin").addClass("d-none");
                        alert(retorno.msg);
                        gerenciarPlataformas();
                        $("#btnSalvar").removeClass("disabled");
                        $("#cadastroPlataforma").modal("hide");
                    } else {
                        alert(retorno.msg);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erro AJAX:", xhr.responseText || error);
                }
            });
        }

        $(document).ready(function() {
            gerenciarPlataformas();
        })
    </script>
</body>

</html>