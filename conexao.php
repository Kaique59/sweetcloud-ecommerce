<?php
// Ajusta os dados conforme seu ambiente
$host = 'localhost';
$db   = 'senactito_db_sweetcloud';
$user = 'senactito_cloud_sweet';
$pass = '!@turma10sweetcloud';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro de conexão: ' . $e->getMessage()]);
    exit;
}