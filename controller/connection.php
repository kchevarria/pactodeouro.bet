<?php
// Bloqueia acesso direto via navegador
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    http_response_code(403);
    exit('Acesso direto não permitido.');
}

// Configurações do banco
$host = 'localhost';
$usuario = 'seu_usuario';
$senha = 'sua_senha';
$banco = 'seu_banco';

// Criando conexão
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    http_response_code(500); // erro interno
    echo json_encode(['status' => 'erro', 'mensagem' => 'Falha na conexão com o banco.']);
    exit;
}
?>
