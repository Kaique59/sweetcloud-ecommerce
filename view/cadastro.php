<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cadastro - SweetCloud</title>
    <link rel="icon" href="../img/SweetCloud-logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/main.css" />
</head>

<body class="body-cadastro">

    <div class="container-cadastro">
        <header class="header">
            <a href="../view/home.php"> <!-- Adicionei um link no logo para voltar para home -->
                <img src="../img/SweetCloud_BTN.png" alt="SweetCloud Logo" class="logo" />
            </a>
        </header>

        <main class="main-content">
            <div class="card-cadastro">
                <h2>Cadastrar</h2>
                <form method="POST" action="../controllers/cadastrar_usuario.php">
                    <div class="cadastro-form">


                        <div class="input-group">
                            <label for="nome">Nome Completo</label>
                            <input type="text" id="nome" name="nome" placeholder="Seu nome" required />
                        </div>

                        <div class="input-group">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" placeholder="Seu e-mail" required />
                        </div>

                        <div class="group-inputs1">

                            <div class="input-group">
                                <label for="cpf">CPF</label>
                                <input type="text" id="cpf" name="cpf" placeholder="Seu CPF" required />
                            </div>

                            <div class="input-group">
                                <label for="telefone">Telefone (Opcional)</label>
                                <input type="tel" id="telefone" name="telefone" placeholder="(XX) XXXX-XXXX" />
                            </div>
                        </div>


                        <div class="input-group">
                            <label for="cep">CEP</label>
                            <input type="text" id="cep" name="cep" placeholder="99999-999" required maxlength="9" /> <!-- Adicionado maxlength -->
                        </div>

                        <div class="input-group">
                            <label for="rua">Rua</label>
                            <input type="text" id="rua" name="rua" placeholder="Nome da rua" readonly /> <!-- Readonly -->
                        </div>

                        <div class="group-inputs1">

                            <div class="input-group">
                                <label for="numero">Número</label>
                                <input type="text" id="numero" name="numero" placeholder="Número" />
                            </div>

                            <div class="input-group">
                                <label for="complemento">Complemento</label>
                                <input type="text" id="complemento" name="complemento" placeholder="Apartamento, bloco, etc." />
                            </div>

                        </div>

                        <div class="group-inputs">

                            <div class="input-group">
                                <label for="bairro">Bairro</label>
                                <input type="text" id="bairro" name="bairro" placeholder="Bairro" readonly /> <!-- Readonly -->
                            </div>

                            <!-- NOVOS CAMPOS PARA CIDADE E ESTADO -->
                            <div class="input-group">
                                <label for="cidade">Cidade</label>
                                <input type="text" id="cidade" name="cidade" placeholder="Cidade" readonly /> <!-- Readonly -->
                            </div>

                            <div class="input-group">
                                <label for="estado">Estado (UF)</label>
                                <input type="text" id="estado" name="estado" placeholder="Estado (UF)" readonly /> <!-- Readonly -->
                            </div>
                        </div>



                        <div class="input-group">
                            <label for="senha">Senha</label>
                            <input type="password" id="senha" name="senha" placeholder="Sua senha" required />
                        </div>

                        <div class="input-group">
                            <label for="confirmar-senha">Confirmar Senha</label>
                            <input type="password" id="confirmar-senha" name="confirmar-senha" placeholder="Confirme sua senha" required />
                        </div>


                    </div>

                    <?php if (isset($_GET['erro'])): ?>
                        <div style="color: black; margin: 20px 0 20px 0;">
                            <?php
                            if ($_GET['erro'] === 'cep-obrigatorio') echo "Por favor, preencha o campo CEP.";
                            else if ($_GET['erro'] === 'senhas-diferentes') echo "As senhas não coincidem.";
                            else if ($_GET['erro'] === 'banco') echo "Erro ao cadastrar. Tente novamente.";
                            else echo "Erro desconhecido.";
                            ?>
                        </div>
                    <?php else: ?>
                        <div style="display: none; margin: 20px 0 20px 0;"></div>
                    <?php endif; ?>

                    <button type="submit" class="btn-cadastrar">Cadastrar</button>
                </form>

                <div class="separator">OU</div>

                <div class="social-login">
                    <button class="btn-social google">
                        <i class="fa-brands fa-google"></i> Fazer login com Google
                    </button>
                    <button class="btn-social apple">
                        <i class="fa-brands fa-apple"></i> Iniciar sessão com Apple
                    </button>
                </div>

                <p class="ja-tem-conta">Já tem uma conta? <a href="../view/login.php">Entrar</a></p>
            </div>
        </main>

        <footer class="footer">
            <p>&copy;1999-2025 SweetCloud. All Rights Reserved</p>
        </footer>
    </div>
    <script src="../js/cep.js"></script>
</body>

</html>