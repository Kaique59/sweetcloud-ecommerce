<?php

session_start();
require_once '../conexao.php'; 

header('Content-Type: application/json');
session_start();


// Lê o JSON do corpo da requisição
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

// Garante que o JSON foi decodificado corretamente
if (!$data || !is_array($data)) {
    echo json_encode(array('success' => false, 'error' => 'Dados inválidos.'));
    exit;
}

$carrinho = isset($data['carrinho']) ? $data['carrinho'] : array();
$id_cliente = isset($_SESSION['usuario']['id']) ? $_SESSION['usuario']['id'] : null;
if (!$id_cliente) {
    echo json_encode(['success' => false, 'error' => 'Usuário não autenticado.']);
    exit;
}

$metodo_pagamento = isset($data['metodo_pagamento']) ? $data['metodo_pagamento'] : '';
$valor_total = isset($data['valor_total']) ? $data['valor_total'] : 0;

try {
    $pdo->beginTransaction();

    // 1. Inserir Pedido
    $stmtPedido = $pdo->prepare("INSERT INTO Pedido (data_pedido, status, id_cliente) VALUES (CURDATE(), :status, :id_cliente)");
    $stmtPedido->execute(array(
        ':status' => 'Pendente',
        ':id_cliente' => $id_cliente
    ));
    $id_pedido = $pdo->lastInsertId();

    // 2. Inserir Itens do Pedido
    $stmtItem = $pdo->prepare("INSERT INTO ItemPedido (quantidade, preco_unitario, subtotal, id_pedido, id_produto) VALUES (:qtd, :preco, :subtotal, :id_pedido, :id_produto)");
    foreach ($carrinho as $item) {
        $subtotal = $item['preco'] * $item['qtd'];
        $stmtItem->execute(array(
            ':qtd' => $item['qtd'],
            ':preco' => $item['preco'],
            ':subtotal' => $subtotal,
            ':id_pedido' => $id_pedido,
            ':id_produto' => $item['id_produto']
        ));
    }

    // 3. Inserir Pagamento
    $stmtPagamento = $pdo->prepare("INSERT INTO Pagamento (data, valor, metodo, status, id_pedido) VALUES (CURDATE(), :valor, :metodo, :status, :id_pedido)");
    $stmtPagamento->execute(array(
        ':valor' => $valor_total,
        ':metodo' => $metodo_pagamento,
        ':status' => 'Pendente',
        ':id_pedido' => $id_pedido
    ));

    $pdo->commit();

    echo json_encode(array('success' => true, 'id_pedido' => $id_pedido));

} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(array('success' => false, 'error' => $e->getMessage()));
}
?>
