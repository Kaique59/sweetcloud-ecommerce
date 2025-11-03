<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    // Se não está logado, redireciona pro login
    // header('Location: view/login.php');
    header('Location: view/home.php');
     exit;
}

// Se está logado, redireciona pra home
// header('Location: view/home.php');
exit;