<?php
include_once("../conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
    $confirmarSenha = isset($_POST['confirmar-senha']) ? $_POST['confirmar-senha'] : '';
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;
    $dataNascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : null;
    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : null;

    $rua = isset($_POST['rua']) ? $_POST['rua'] : null;
    $numero = isset($_POST['numero']) ? $_POST['numero'] : null;
    $complemento = isset($_POST['complemento']) ? $_POST['complemento'] : null;
    $bairro = isset($_POST['bairro']) ? $_POST['bairro'] : null;
    $cep = isset($_POST['cep']) ? $_POST['cep'] : '';

    // Validação do CEP obrigatório
    if (empty($cep)) {
        header("Location: ../view/cadastro.php?erro=cep-obrigatorio");
        exit;
    }

    // Validação senhas iguais
    if ($senha !== $confirmarSenha) {
        header("Location: ../view/cadastro.php?erro=senhas-diferentes");
        exit;
    }

    // Fallback de hash para versões antigas
    if (!function_exists('password_hash')) {
        function password_hash_custom($senha) {
            return md5($senha); // ⚠️ Inseguro, use só em desenvolvimento ou emergência
        }
        $senhaHash = password_hash_custom($senha);
    } else {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO Cliente 
            (nome, email, senha, cpf, data_nascimento, telefone, rua, numero, complemento, bairro, cep) 
            VALUES 
            (:nome, :email, :senha, :cpf, :data_nascimento, :telefone, :rua, :numero, :complemento, :bairro, :cep)");

        $stmt->execute(array(
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => $senhaHash,
            ':cpf' => $cpf,
            ':data_nascimento' => !empty($dataNascimento) ? $dataNascimento : null,
            ':telefone' => $telefone,
            ':rua' => $rua,
            ':numero' => $numero,
            ':complemento' => $complemento,
            ':bairro' => $bairro,
            ':cep' => $cep
        ));

        header("Location: ../view/login.php?sucesso=1");
        exit;
    } catch (PDOException $e) {
        // echo "Erro: " . $e->getMessage(); // Somente para debug
        header("Location: ../view/cadastro.php?erro=banco");
        exit;
    }
} else {
    header("Location: ../view/cadastro.php");
    exit;
}
