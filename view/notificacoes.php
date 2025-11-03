<?php
session_start();
include '../includes/header.php';
require_once '../conexao.php';
include_once("./modal-generico.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$id_cliente = $_SESSION['usuario']['id'];

// Busca nome do cliente
$stmt = $pdo->prepare("SELECT nome FROM Cliente WHERE id_cliente = ?");
$stmt->execute([$id_cliente]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

// Busca preferências de notificação
$stmt = $pdo->prepare("SELECT * FROM NotificacaoCliente WHERE id_cliente = ?");
$stmt->execute([$id_cliente]);
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

// Se não existir, cria registro padrão
if (!$dados) {
    $stmt = $pdo->prepare("INSERT INTO NotificacaoCliente (id_cliente) VALUES (?)");
    $stmt->execute([$id_cliente]);

    $dados = [
        'promocoes' => 0,
        'novos_sabores' => 0,
        'datas_comemorativas' => 0,
        'pedido_em_producao' => 0
    ];
}
?>
<link rel="stylesheet" href="../css/notificacoes.css">

<section class="painel-usuario">
    <div class="menu-lateral">
        <h2>Olá <?= htmlspecialchars($cliente['nome']) ?></h2>
        <ul>
            <li><a href="meusdados.php">Meus Dados</a></li>
            <li><a href="historico.php">Histórico</a></li>
            <li><strong>Notificações</strong></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </div>

    <div class="conteudo">
        <h2>Fique por Dentro !!</h2>
        <div class="card-dados">
            <label>
                <input type="checkbox" name="promocoes" <?= $dados['promocoes'] ? 'checked' : '' ?>>
                Quero receber promoções e descontos exclusivos por e-mail.
            </label>
            <label>
                <input type="checkbox" name="novos_sabores" <?= $dados['novos_sabores'] ? 'checked' : '' ?>>
                Avisar quando houver novos sabores disponíveis.
            </label>
            <label>
                <input type="checkbox" name="datas_comemorativas" <?= $dados['datas_comemorativas'] ? 'checked' : '' ?>>
                Me notificar sobre encomendas especiais para datas comemorativas.
            </label>
            <label>
                <input type="checkbox" name="pedido_em_producao" <?= $dados['pedido_em_producao'] ? 'checked' : '' ?>>
                Me informar quando o meu pedido estiver em produção.
            </label>
        </div>
    </div>
</section>
<script src="../js/modal-alerta.js"></script>

<script>
document.querySelectorAll('input[type="checkbox"]').forEach(input => {
    input.addEventListener('change', () => {
        fetch('../controllers/atualizar_notificacao.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                campo: input.name,
                valor: input.checked ? 1 : 0
            })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.sucesso) {
                mostrarAlerta("Erro ao salvar: " + (data.erro || ""));
            }
        })
        .catch(() => mostrarAlerta("Erro de comunicação com o servidor."));
    });
});
</script>

<?php include_once("contato.php"); ?>
<?php include '../includes/footer.php'; ?>
