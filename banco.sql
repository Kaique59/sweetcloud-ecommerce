CREATE DATABASE IF NOT EXISTS sweetcloud;
USE sweetcloud;
 
 CREATE TABLE IF NOT EXISTS Cliente (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    data_nascimento DATE,
    telefone VARCHAR(20),
    rua VARCHAR(200),
    numero VARCHAR(10),
    complemento VARCHAR(100),
    cidade VARCHAR(100),
    estado VARCHAR(100),
    bairro VARCHAR(100),
    cep VARCHAR(10),
    ativo ENUM('Ativo', 'Inativo') DEFAULT 'Ativo'
);

CREATE TABLE IF NOT EXISTS Produto (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    imagem VARCHAR(255),       -- faltava vírgula no final dessa linha
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DOUBLE NOT NULL,
    categoria VARCHAR(50),
    estoque INT NOT NULL DEFAULT 0
);
 
CREATE TABLE IF NOT EXISTS Pedido (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    data_pedido DATE NOT NULL,
    status VARCHAR(50),
    id_cliente INT,
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente),
    observacao VARCHAR(100)
);
 
CREATE TABLE IF NOT EXISTS ItemPedido (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    quantidade INT NOT NULL,
    preco_unitario DOUBLE NOT NULL,
    subtotal DOUBLE NOT NULL,
    id_pedido INT,
    id_produto INT,
    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido),
    FOREIGN KEY (id_produto) REFERENCES Produto(id_produto)
);
 
CREATE TABLE IF NOT EXISTS Pagamento (
    id_pagamento INT AUTO_INCREMENT PRIMARY KEY,
    data DATE NOT NULL,
    valor DOUBLE NOT NULL,
    metodo VARCHAR(50) NOT NULL,
    status VARCHAR(50),
    id_pedido INT,
    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido)
);
 
CREATE TABLE IF NOT EXISTS SuporteAtendimento (
    id_suporte INT AUTO_INCREMENT PRIMARY KEY,
    mensagem TEXT NOT NULL,
    resposta TEXT,
    status VARCHAR(50),
    id_cliente INT,
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente)
);
 
CREATE TABLE IF NOT EXISTS NotificacaoCliente (
    id_notificacao INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    promocoes TINYINT(1) DEFAULT 0,
    novos_sabores TINYINT(1) DEFAULT 0,
    datas_comemorativas TINYINT(1) DEFAULT 0,
    pedido_em_producao TINYINT(1) DEFAULT 0,
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente)
);

CREATE TABLE recupera (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_cliente INT NOT NULL,
  id_unico VARCHAR(255) NOT NULL UNIQUE,
  data_solicitacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  status_recupera TINYINT(1) NOT NULL DEFAULT 0,
  data_uso DATETIME DEFAULT NULL,
  FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);


/* Inserir produtos – tabela Produto */
INSERT INTO Produto (imagem, nome, descricao, preco, categoria) VALUES
  -- Bolos
  ('../img/produtos/bolos/produto1.bolo.png',
   'Chocolate Cake with Strawberries',
   'Este é um bolo de chocolate úmido e macio, com uma rica cobertura brilhante de chocolate (provavelmente brigadeiro ou ganache). É decorado com morangos frescos cortados, que adicionam acidez e frescor, e finalizado com açúcar de confeiteiro. Uma sobremesa clássica e reconfortante, ideal para amantes de chocolate e frutas vermelhas.',
   50.00, 'bolo'),

  ('../img/produtos/bolos/produto2.bolo.png',
   'Bolo de Amêndoa',
   'Ingredientes: Massa de chocolate (farinha de trigo enriquecida com ferro e ácido fólico, açúcar, chocolate em pó 50 % cacau, ovos, óleo vegetal, leite integral, fermento químico, bicarbonato de sódio, sal), recheio de ganache (chocolate meio‑amargo premium, creme de leite, manteiga), geleia artesanal de framboesa e framboesas frescas selecionadas.',
   75.00, 'bolo'),

  ('../img/produtos/bolos/produto3.bolo.png',
   'Chocolat Rouge',
   'Massa de chocolate, ganache de chocolate meio‑amargo (chocolate nobre, creme de leite, manteiga, essência de baunilha) e morangos frescos selecionados.',
   45.00, 'bolo'),

  ('../img/produtos/bolos/produto4.bolo.png',
   'Naked Cake de Chocolate',
   'Elegante Naked Cake de chocolate com três camadas, recheado com morangos frescos e possivelmente geleia de morango; coberto com calda de chocolate brilhante escorrendo pelas laterais e decorado com morangos no topo.',
   189.90, 'bolo'),

  ('../img/produtos/bolos/produto5.bolo.png',
   'Bolo Medovik',
   'Bolo retangular de múltiplas camadas finas, alternando massa crocante de mel com creme branco suave (geralmente creme azedo ou doce de leite). Laterais e topo cobertos por migalhas de massa; pequena decoração de chocolate branco.',
   149.90, 'bolo'),

  ('../img/produtos/bolos/produto6.bolo.png',
   'Bolo de Coco Gelado',
   'Massa clara e fofinha; topo com camada generosa de coco ralado em flocos, aroma de coco intenso; base levemente dourada indicando ótimo ponto de forno.',
   79.00, 'bolo'),

  -- Brownies
  ('../img/produtos/brownie/produto7.brownie.png',
   'Brownie Clássico',
   'Brownie de chocolate intenso com casquinha crocante por fora e miolo denso e úmido. Perfeito para acompanhar um café fresco.',
   12.00, 'brownie'),

  ('../img/produtos/brownie/produto8.brownie.png',
   'Brownie de Nozes',
   'Brownie de chocolate meio‑amargo com pedaços generosos de noz‑pecã torrada, equilibrando textura macia e crocante.',
   14.00, 'brownie'),

  ('../img/produtos/brownie/produto9.brownie.png',
   'Brownie de Doce de Leite',
   'Massa de cacau 50 % com swirl de doce de leite artesanal — combinação irresistível de chocolate e caramelo.',
   15.00, 'brownie'),

  ('../img/produtos/brownie/produto10.brownie.bolo.png',
   'Brownie Trufado',
   'Brownie duplo de cacau recheado com ganache trufada e finalizado com raspas de chocolate belga.',
   16.50, 'brownie'),

  -- Salgados
  ('../img/produtos/salgados/produto11.salgado.png',
   'Coxinha de Frango com Catupiry',
   'Clássica coxinha brasileira de massa leve e crocante, recheada com frango desfiado temperado e cremoso catupiry.',
   8.00, 'salgado'),

  ('../img/produtos/salgados/produto12.salgado.png',
   'Esfiha de Carne',
   'Esfiha macia em formato triangular, recheada com carne moída suculenta aromatizada com especiarias árabes.',
   7.50, 'salgado'),

  ('../img/produtos/salgados/produto13.salgado.png',
   'Empada de Palmito',
   'Empada amanteigada, massa que derrete na boca, recheada com creme de palmito, azeitonas verdes e ervas frescas.',
   9.00, 'salgado'),

  ('../img/produtos/salgados/produto14.salgado.png',
   'Pastel de Queijo',
   'Pastel frito de massa fina super crocante, recheado com queijo muçarela derretido e tempero leve de orégano.',
   7.00, 'salgado'),

  -- Sorvetes
  ('../img/produtos/sorvetes/produto15.sorvete.png',
   'Sorvete de Chocolate Belga',
   'Sorvete cremoso preparado com cacau 70 %, sabor intenso e textura aveludada — ideal para chocólatras.',
   10.00, 'sorvete'),

  ('../img/produtos/sorvetes/produto16.sorvete.png',
   'Sorvete de Morango Artesanal',
   'Feito com morangos frescos selecionados, sem corantes artificiais, resultando em cor natural e sabor autêntico.',
   8.50, 'sorvete'),

  ('../img/produtos/sorvetes/produto17.sorvete.png',
   'Sorvete de Creme Baunilha',
   'Clássico sorvete de creme à base de baunilha de Madagascar, textura suave e perfume delicado.',
   8.00, 'sorvete');
