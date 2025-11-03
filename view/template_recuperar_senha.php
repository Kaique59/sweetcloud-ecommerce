<?php
// $nome e $link devem ser definidos antes de incluir este arquivo
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Recuperação de Senha - SweetCloud</title>
</head>
<body style="font-family: 'Roboto', sans-serif; background-color: #f9f5e6; padding: 30px; margin: 0;">
  <div style="max-width: 600px; margin: auto; background: #fff; border-radius: 12px; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <h2 style="color: #833b14; text-align: center;">Olá, <?= htmlspecialchars($nome) ?>!</h2>

    <p style="font-size: 16px; color: #333;">
      Recebemos uma solicitação para redefinir sua senha na plataforma <strong>SweetCloud</strong>.
    </p>

    <p style="font-size: 16px; color: #333;">
      Para redefinir sua senha, clique no botão abaixo:
    </p>

    <p style="text-align: center; margin: 30px 0;">
      <a href="<?= htmlspecialchars($link) ?>" 
         style="background-color: #833b14; color: #fff; padding: 12px 24px; text-decoration: none; font-size: 16px; border-radius: 8px; display: inline-block;">
        Redefinir Senha
      </a>
    </p>

    <p style="font-size: 14px; color: #666;">
      Se você não solicitou essa alteração, ignore este e-mail. Nenhuma ação será tomada.
    </p>

    <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">

    <p style="font-size: 12px; color: #999; text-align: center;">
      &copy; <?= date('Y') ?> SweetCloud. Todos os direitos reservados.
    </p>
  </div>
</body>
</html>
