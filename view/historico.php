<?php
session_start();
require_once '../conexao.php';
// echo "<pre>";
// var_dump($_SESSION['usuario']);
// echo "</pre>";


// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$id_cliente = $_SESSION['usuario']['id'];

// Buscar nome do cliente
$stmt = $pdo->prepare("SELECT nome FROM Cliente WHERE id_cliente = ?");
$stmt->execute([$id_cliente]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

// Buscar histórico de pedidos com status
$sql = "
    SELECT 
        p.id_pedido,
        p.data_pedido,
        p.status AS status_pedido,
        pr.nome AS nome_produto,
        ip.quantidade,
        ip.preco_unitario,
        (ip.quantidade * ip.preco_unitario) AS total_item
    FROM Pedido p
    JOIN ItemPedido ip ON p.id_pedido = ip.id_pedido
    JOIN Produto pr ON ip.id_produto = pr.id_produto
    WHERE p.id_cliente = :id_cliente
    ORDER BY p.data_pedido DESC, p.id_pedido DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_cliente' => $id_cliente]);

$historico = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Debug: mostrar o conteúdo do array
// echo "<h2>📜 Histórico (variável \$historico):</h2>";
// echo "<pre>";
// print_r($historico);
// echo "</pre>"; 


// echo "<h2>🧾 Lista de Pedidos no Banco:</h2>";

// $sql = "SELECT * FROM Pedido";
// foreach($pdo->query($sql) as $row) {
//     echo "<strong>Pedido ID: {$row['id_pedido']}</strong>";
//     echo "<pre>";
//     print_r($row);
//     echo "</pre>";
// }
?>

<?php include_once("../includes/header.php"); ?>

<link rel="stylesheet" href="../css/historico.css">

<section class="painel-usuario">
    <div class="menu-lateral">
        <h2>Olá <?= htmlspecialchars($cliente['nome']) ?></h2>
        <ul>
            <li><a href="meusdados.php">Meus Dados</a></li>
            <li><strong>Histórico</strong></li>
            <li><a href="notificacoes.php">Notificações</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </div>

    <div class="conteudo">
        <h2>Histórico de Pedidos</h2>

        <?php if (count($historico) === 0): ?>
            <p>Você ainda não fez nenhum pedido.</p>
            <?php else:
            $pedidoAtual = null;
            foreach ($historico as $item):
                if ($pedidoAtual !== $item['id_pedido']):
                    if ($pedidoAtual !== null) echo "</table></div><br>";
                    $pedidoAtual = $item['id_pedido'];
            ?>
                    <div class="card-dados">
                        <p>
                            <strong>Pedido #<?= $item['id_pedido'] ?></strong> -
                            <span><?= date("d/m/Y", strtotime($item['data_pedido'])) ?></span><br>
                            <em>Status: <?= htmlspecialchars($item['status_pedido']) ?></em>
                        </p>
                        <table class="tabela-historico">
                            <tr>
                                <th>Produto</th>
                                <th>Qtd</th>
                                <th>Preço</th>
                                <th>Total</th>
                            </tr>
                        <?php
                    endif;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nome_produto']) ?></td>
                            <td><?= $item['quantidade'] ?></td>
                            <td>R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?></td>
                            <td>R$ <?= number_format($item['total_item'], 2, ',', '.') ?></td>
                        </tr>
                <?php endforeach;
            echo "</table></div>";
        endif; ?>
                    </div>
</section>

<?php include_once("contato.php"); ?>
<?php include_once("../includes/footer.php"); ?>