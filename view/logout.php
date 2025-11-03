<?php
session_start();      // Inicia a sessão
session_destroy();    // Destrói todos os dados registrados em uma sessão
session_unset();      // Remove todas as variáveis de sessão

// Redireciona para o index.php na raiz do seu projeto ou para onde ele estiver
header('Location: ../index.php'); // Alterado de home.php para index.php
exit; // É crucial chamar exit; após um redirecionamento para garantir que o script pare de executar
?>
