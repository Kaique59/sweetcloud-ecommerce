<?php
header('Content-Type: application/json');

// OBS.: use caminhos válidos para o seu servidor.
// Se os ficheiros estiverem em /img/bolos/, mantenha a barra inicial “/”.
$produtos = [
  [
    "imgProduto"  => "../img/produtos/bolos/produto1.bolo.png.png",                 
    "NomeProduto" => "Chocolate Cake with Strawberries",
    "descricao"   => "Este é um bolo de chocolate úmido e macio, com uma rica cobertura brilhante de chocolate (provavelmente brigadeiro ou ganache). É decorado com morangos frescos cortados, que adicionam acidez e frescor, e finalizado com açúcar de confeiteiro. Uma sobremesa clássica e reconfortante, ideal para amantes de chocolate e frutas vermelhas.",
    "preco"       => "50,00",
    "categoria"   => "bolo"
  ],
  [
    "imgProduto"  => "../img/produtos/bolos/produto2.bolo.png.png",
    "NomeProduto" => "Bolo de amêndoa",
    "descricao"   => "Ingredientes: Massa de chocolate (farinha de trigo enriquecida com ferro e ácido fólico, açúcar, chocolate em pó 50% cacau, ovos, óleo vegetal, leite integral, fermento químico, bicarbonato de sódio, sal), Recheio de ganache (chocolate meio amargo premium, creme de leite, manteiga), Geleia artesanal de framboesa, Framboesas frescas selecionadas.",
    "preco"       => "75,00",
    "categoria"   => "bolo"
  ],
  [
    "imgProduto"  => "../img/produtos/bolos/produto3.bolo.png.png",
    "NomeProduto" => "Chocolat Rouge",
    "descricao"   => "Massa de chocolate (farinha de trigo enriquecida com ferro e ácido fólico, açúcar, chocolate em pó 50% cacau, ovos, óleo vegetal, leite integral, fermento químico, bicarbonato de sódio, sal), ganache de chocolate meio amargo (chocolate nobre meio amargo, creme de leite, manteiga, essência de baunilha), morangos frescos selecionados.",
    "preco"       => "45,00",
    "categoria"   => "bolo"
  ],
  [
    "imgProduto"  => "../img/produtos/bolos/produto4.bolo.png.png",
    "NomeProduto" => "Naked Cake de Chocolate",
    "descricao"   => "Este é um elegante Naked Cake de chocolate com três camadas, recheado com morangos frescos e uma possível geleia de morango. O bolo é coberto por uma calda de chocolate brilhante que escorre pelas laterais e abundantemente decorado com morangos frescos no topo.",
    "preco"       => "189,90",
    "categoria"   => "bolo"
  ],
  [
    "imgProduto"  => "../img/produtos/bolos/produto5.bolo.png.png",
    "NomeProduto" => "Bolo Medovik",
    "descricao"   => "Este é um bolo retangular de múltiplas camadas finas, alternando biscoito ou massa crocante de mel com um creme branco e suave (geralmente creme azedo ou doce de leite). As laterais e o topo são cobertos por migalhas de biscoito ou massa, e há uma pequena decoração de chocolate branco no topo.",
    "preco"       => "149,90",
    "categoria"   => "bolo"
  ],
  [
    "imgProduto"  => "../img/produtos/bolos/produto6.bolo.png.png",
    "NomeProduto" => "Bolo de Coco Gelado ",
    "descricao"   => "Bolo de Coco Gelado, massa clara e fofinha, com uma textura visivelmente macia. O topo é coberto com uma generosa camada de coco ralado em flocos, o que sugere um sabor e aroma de coco intensos. A base do bolo apresenta uma crosta levemente dourada, indicando que foi bem assado. ",
    "preco"       => "79.00",
    "categoria"   => "bolo"
  ],

];

echo json_encode($produtos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);