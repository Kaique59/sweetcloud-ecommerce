<?php

// Remova os namespaces se for PHP 5.x
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

include_once("../conexao.php");
require_once __DIR__ . '/../PHPMailer-5.2.27/PHPMailerAutoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email_cpf = isset($_POST["email_cpf"]) ? trim($_POST["email_cpf"]) : '';

    if (empty($email_cpf)) {
        echo "Digite seu e-mail ou CPF.";
        exit;
    }

    // Buscar cliente no banco
    $stmt = $pdo->prepare("SELECT * FROM Cliente WHERE (email = :ec OR cpf = :ec) AND ativo = 'Ativo'");
    $stmt->bindParam(':ec', $email_cpf);
    $stmt->execute();
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        echo "Usuário não encontrado ou inativo.";
        exit;
    }

    // Gerar token único (usando md5 como alternativa ao random_bytes)
    $token = uniqid(md5(mt_rand()), true);

    // Montar link
    $link = "https://escolatito.com.br/cloud_sweet/reset_password.php?token=$token&id=" . $cliente['id_cliente'];

    // Salvar token
    $insert = $pdo->prepare("INSERT INTO recupera (id_cliente, id_unico, status_recupera) VALUES (:id_cliente, :token, 0)");
    $insert->bindParam(':id_cliente', $cliente['id_cliente']);
    $insert->bindParam(':token', $token);
    $insert->execute();

    // Corpo do e-mail (HTML)
    $nome = $cliente['nome'];
    ob_start();
    include '../view/template_recuperar_senha.php'; // Garanta que esse arquivo não use PHP moderno
    $body = ob_get_clean();

    // Enviar e-mail com PHPMailer
    $mail = new PHPMailer(); // Sem namespace
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'samira.v.souza20@gmail.com';
    $mail->Password = 'ipts viti knew uplq'; // 🔐 PERIGO: Remova isso em produção!
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('samira.v.souza20@gmail.com', 'SweetCloud');
    $mail->addAddress($cliente['email'], $cliente['nome']);
    $mail->isHTML(true);
    $mail->Subject = 'Recuperação de Senha - SweetCloud';
    $mail->Body    = $body;
    $mail->AltBody = "Olá {$cliente['nome']}, acesse o link para redefinir sua senha: $link";

    if ($mail->send()) {
        echo "Um link de recuperação foi enviado para seu e-mail.";
    } else {
        echo "Erro ao enviar e-mail: " . $mail->ErrorInfo;
    }

} else {
    // Exibe formulário simples caso não seja POST
    ?>
    <form method="post" action="">
        <label for="email_cpf">Email ou CPF:</label>
        <input type="text" id="email_cpf" name="email_cpf" required>
        <button type="submit">Enviar link de recuperação</button>
    </form>
    <?php
}
