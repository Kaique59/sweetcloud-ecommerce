<?php
session_start();
require_once('../conexao.php');

header('Content-Type: application/json');

// Verifica se usuário está logado
if (!isset($_SESSION['usuario'])) {
    echo json_encode(array('sucesso' => false, 'erro' => 'Usuário não autenticado'));
    exit;
}

$id_cliente = $_SESSION['usuario']['id'];

// Captura e trata a entrada
$inputRaw = file_get_contents("php://input");
$input = json_decode($inputRaw, true);

$campo = isset($input['campo']) ? $input['campo'] : null;
$valor = isset($input['valor']) ? $input['valor'] : null;

$camposPermitidos = array('promocoes', 'novos_sabores', 'datas_comemorativas', 'pedido_em_producao');

if (!in_array($campo, $camposPermitidos)) {
    echo json_encode(array('sucesso' => false, 'erro' => 'Campo inválido'));
    exit;
}

// Garante que o valor seja 0 ou 1
$valor = ($valor == 1) ? 1 : 0;

try {
    // Monta dinamicamente o SQL com campo validado
    $sql = "UPDATE NotificacaoCliente SET $campo = :valor WHERE id_cliente = :id_cliente";
    $stmt = $pdo->prepare($sql);
    $sucesso = $stmt->execute(array(
        ':valor' => $valor,
        ':id_cliente' => $id_cliente
    ));

    echo json_encode(array('sucesso' => $sucesso));
} catch (Exception $e) {
    echo json_encode(array(
        'sucesso' => false,
        'erro' => 'Erro interno: ' . $e->getMessage()
    ));
}
?>
