<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// if (!isset($_SESSION['usuario'])) {
//     header('Location: login.php');
//     exit;
// }

?>
<?php include '../includes/header.php'; ?>
<?php include 'carrossel.php'; ?>
<?php include 'section_produtos.php'; ?>
<?php include 'nossa_historia.php'; ?>
<?php include 'contato.php'; ?>
<?php include '../includes/footer.php'; ?>
