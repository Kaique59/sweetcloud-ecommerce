<?php
include_once 'conexao.php';
session_start();

function clean($input) {
    return htmlspecialchars(trim($input));
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if (!$id || !$token) {
    die('Parâmetros inválidos.');
}

// Consulta o cliente pelo token
$stmt = $pdo->prepare("SELECT c.id_cliente, c.email FROM Cliente c
  INNER JOIN recupera r ON c.id_cliente = r.id_cliente
  WHERE r.id_unico = :token AND r.status_recupera = 0");
$stmt->bindParam(':token', $token);
$stmt->execute();
$recupera = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recupera) {
    die('Token inválido ou expirado.');
}

$errors = array();
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha = isset($_POST['senha']) ? clean($_POST['senha']) : '';
    $confirma_senha = isset($_POST['confirma_senha']) ? clean($_POST['confirma_senha']) : '';

    if (empty($senha) || empty($confirma_senha)) {
        $errors[] = "Preencha ambos os campos de senha.";
    } elseif ($senha !== $confirma_senha) {
        $errors[] = "As senhas não conferem.";
    } elseif (strlen($senha) < 6) {
        $errors[] = "A senha deve ter pelo menos 6 caracteres.";
    }

    if (empty($errors)) {
        // Fallback para password_hash caso não exista
        if (!function_exists('password_hash')) {
            function password_hash_custom($senha) {
                return md5($senha); // ⚠️ Risco de segurança! Só use como último recurso!
            }
            $senha_hash = password_hash_custom($senha);
        } else {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        }

        $updateSenha = $pdo->prepare("UPDATE Cliente SET senha = :senha WHERE id_cliente = :id");
        $updateSenha->bindParam(':senha', $senha_hash);
        $updateSenha->bindParam(':id', $recupera['id_cliente']);
        $updateSenha->execute();

        $marcaToken = $pdo->prepare("UPDATE recupera SET status_recupera = 1, data_uso = NOW() WHERE id_cliente = :id AND id_unico = :token");
        $marcaToken->bindParam(':id', $recupera['id_cliente']);
        $marcaToken->bindParam(':token', $token);
        $marcaToken->execute();

        $success = true;
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Redefinir Senha</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f0f2f5;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }
  .container {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    max-width: 400px;
    width: 100%;
  }
  h2 {
    margin-bottom: 1rem;
    text-align: center;
    color: #333;
  }
  label {
    display: block;
    margin-bottom: .25rem;
    color: #555;
  }
  input[type=password] {
    width: 100%;
    padding: .5rem;
    margin-bottom: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
  button {
    width: 100%;
    padding: .75rem;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    font-size: 1rem;
  }
  button:hover {
    background: #0056b3;
  }
  .error {
    background: #f8d7da;
    color: #842029;
    padding: .75rem;
    margin-bottom: 1rem;
    border-radius: 4px;
  }
  .success {
    background: #d1e7dd;
    color: #0f5132;
    padding: .75rem;
    margin-bottom: 1rem;
    border-radius: 4px;
    text-align: center;
  }
</style>
</head>
<body>
  <div class="container">
    <h2>Redefinir Senha</h2>

    <?php if ($success): ?>
      <div class="success">Senha alterada com sucesso! Você já pode fazer login.</div>
    <?php else: ?>

      <?php if ($errors): ?>
        <?php foreach ($errors as $error): ?>
          <div class="error"><?= $error ?></div>
        <?php endforeach; ?>
      <?php endif; ?>

      <form method="post" novalidate>
        <label for="senha">Nova senha</label>
        <input type="password" name="senha" id="senha" required minlength="6" />

        <label for="confirma_senha">Confirme a nova senha</label>
        <input type="password" name="confirma_senha" id="confirma_senha" required minlength="6" />

        <button type="submit">Salvar</button>
      </form>

    <?php endif; ?>
  </div>
</body>
</html>
