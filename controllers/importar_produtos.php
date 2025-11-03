<?php
// importa_produtos.php
// Incluir o array $produtos do arquivo dados.php
include 'dados.php';
include '../conexao.php'; // Incluir a configuração do banco de dados

// Preparar a query de inserção (usando prepared statement para segurança)
$sql = "INSERT INTO Produto (imagem, nome, descricao, preco, categoria) VALUES (:imagem, :nome, :descricao, :preco, :categoria)";
$stmt = $pdo->prepare($sql);

foreach ($produtos as $produto) {
    // Converter preço para número: remover "R$ ", trocar vírgula por ponto e converter para float
    $preco_str = str_replace(['', ','], ['', '.'], $produto['preco']);
    $preco = floatval($preco_str);

    $stmt->execute([
        ':imagem'    => $produto['imgProduto'],
        ':nome'      => $produto['NomeProduto'],
        ':descricao' => $produto['descricao'],
        ':preco'     => $preco,
        ':categoria' => $produto['categoria']
    ]);
}

echo "Produtos importados com sucesso!";
