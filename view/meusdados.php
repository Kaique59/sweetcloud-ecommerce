<?php
session_start();
require_once '../conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$id_cliente = $_SESSION['usuario']['id'];

// Atualiza dados do cliente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['salvar'])) {
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $telefone = $_POST['telefone'];
        $data_nascimento = $_POST['data_nascimento'];
        $email = $_POST['email'];
        $cep = $_POST['cep'];
        $rua = $_POST['rua'];
        $numero = $_POST['numero'];
        $complemento = $_POST['complemento'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];

        $sql = "UPDATE Cliente 
                SET nome = :nome, cpf = :cpf, telefone = :telefone, data_nascimento = :data_nascimento, 
                    email = :email, cep = :cep, rua = :rua, numero = :numero, complemento = :complemento, bairro = :bairro,
                    cidade = :cidade, estado = :estado
                WHERE id_cliente = :id_cliente";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':cpf' => $cpf,
            ':telefone' => $telefone,
            ':data_nascimento' => $data_nascimento,
            ':email' => $email,
            ':cep' => $cep,
            ':rua' => $rua,
            ':numero' => $numero,
            ':complemento' => $complemento,
            ':bairro' => $bairro,
            ':cidade' => $cidade,
            ':estado' => $estado,
            ':id_cliente' => $id_cliente
        ]);

        $_SESSION['usuario']['nome'] = $nome;
    } elseif (isset($_POST['excluir'])) {
        $sql = "UPDATE Cliente SET ativo = 'Inativo' WHERE id_cliente = :id_cliente";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_cliente' => $id_cliente]);

        session_destroy();
        header("Location: ../view/home.php");
        exit;
    }
}

$sql = "SELECT nome, cpf, telefone, data_nascimento, email, cep, rua, numero, complemento, bairro, cidade, estado
        FROM Cliente 
        WHERE id_cliente = :id_cliente";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_cliente' => $id_cliente]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php include_once("../includes/header.php"); ?>

<section class="painel-usuario">
    <div class="menu-lateral">
        <h2>Olá <?= htmlspecialchars($cliente['nome']) ?></h2>
        <ul>
            <li><strong>Meus Dados</strong></li>
            <li><a href="historico.php">Histórico</a></li>
            <li><a href="notificacoes.php">Notificações</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </div>

    <div class="conteudo">
        <br>
        <div class="card-dados">
            <form method="POST" id="formDados">
                <p><strong>Suas informações:</strong></p>
                <br>
                <div class="grid-campos">
                    <label>Nome:
                        <input type="text" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" readonly>
                    </label>
                    <label>CPF:
                        <input type="text" name="cpf" value="<?= htmlspecialchars($cliente['cpf']) ?>" readonly>
                    </label>
                    <label>Telefone:
                        <input type="text" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>" readonly>
                    </label>
                    <label>Data/Nascimento:
                        <input type="date" name="data_nascimento" value="<?= htmlspecialchars($cliente['data_nascimento']) ?>" readonly>
                    </label>
                    <label>E-mail:
                        <input type="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" readonly>
                    </label>
                    <label>CEP:
                        <input type="text" id="cep" name="cep" value="<?= htmlspecialchars($cliente['cep']) ?>" readonly maxlength="9">
                    </label>
                    <label>Rua:
                        <input type="text" id="rua" name="rua" value="<?= htmlspecialchars($cliente['rua']) ?>" readonly>
                    </label>
                    <label>Número:
                        <input type="text" id="numero" name="numero" value="<?= htmlspecialchars($cliente['numero']) ?>" readonly>
                    </label>
                    <label>Complemento:
                        <input type="text" id="complemento" name="complemento" value="<?= htmlspecialchars($cliente['complemento']) ?>" readonly>
                    </label>
                    <label>Bairro:
                        <input type="text" id="bairro" name="bairro" value="<?= htmlspecialchars($cliente['bairro']) ?>" readonly>
                    </label>
                    <label>Cidade:
                        <input type="text" id="cidade" name="cidade" value="<?= htmlspecialchars($cliente['cidade']) ?>" readonly>
                    </label>
                    <label>Estado (UF):
                        <input type="text" id="estado" name="estado" value="<?= htmlspecialchars($cliente['estado']) ?>" readonly>
                    </label>
                </div>

                <button type="button" id="btnEditar">Editar</button>
                <button type="submit" name="salvar" id="btnSalvar" style="display: none;">Salvar</button>
                <button type="button" id="btnCancelar" style="display: none;">Cancelar</button>
                <button type="button" id="btnAbrirModal">Excluir Conta</button>
            </form>
        </div>
    </div>
</section>

<!-- Modal de Confirmação -->
<div id="modalConfirmacao" role="dialog" aria-modal="true" aria-labelledby="modalTitulo" aria-describedby="modalDescricao">
    <div class="modal-content">
        <img src="../img/bolodo-adeus.jpg" alt="Aviso" />
        <p id="modalDescricao">Você tem certeza que quer desativar a sua conta? Você é um cliente valioso.</p>
        <div class="modal-buttons">
            <button type="button" class="btn-cancel" id="btnCancelarModal">Cancelar</button>
            <button type="submit" form="formDados" name="excluir" class="btn-confirm">Confirmar</button>
        </div>
    </div>
</div>

<script>
    const btnEditar = document.getElementById('btnEditar');
    const btnSalvar = document.getElementById('btnSalvar');
    const btnCancelarEdicao = document.getElementById('btnCancelar');
    const btnAbrirModal = document.getElementById('btnAbrirModal');
    const btnCancelarModal = document.getElementById('btnCancelarModal');
    const formInputs = document.querySelectorAll('#formDados input');
    const modal = document.getElementById('modalConfirmacao');

    function setInitialState() {
        formInputs.forEach(input => {
            input.setAttribute('readonly', 'readonly');
        });
        btnEditar.style.display = 'inline-block';
        btnAbrirModal.style.display = 'inline-block';
        btnSalvar.style.display = 'none';
        btnCancelarEdicao.style.display = 'none';
    }

    btnEditar.addEventListener('click', () => {
        formInputs.forEach(input => {
            if (input.name !== 'cpf') {
                input.removeAttribute('readonly');
            }
        });
        btnSalvar.style.display = 'inline-block';
        btnCancelarEdicao.style.display = 'inline-block';
        btnAbrirModal.style.display = 'none';
        btnEditar.style.display = 'none';
    });

    btnCancelarEdicao.addEventListener('click', () => {
        location.reload();
    });

    btnAbrirModal.addEventListener('click', () => {
        modal.classList.add('show');
    });

    btnCancelarModal.addEventListener('click', () => {
        modal.classList.remove('show');
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('show');
        }
    });

    setInitialState();
</script>

<script src="../js/cep.js"></script>

<?php include_once("contato.php"); ?>
<?php include_once("../includes/footer.php"); ?>
