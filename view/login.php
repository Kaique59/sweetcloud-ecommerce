<?php
include_once("../conexao.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM Cliente WHERE email = :email AND ativo = 'Ativo'");
    $stmt->execute([':email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = [
            'id' => $usuario['id_cliente'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email']
        ];
        header('Location: ./home.php');
        exit;
    } else {
        $erro = "Usuário ou senha inválidos, ou conta inativa.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SweetCloud - Login</title>
    <link rel="icon" href="../img/SweetCloud-logo.png" type="image/png">
    <link rel="stylesheet" href="../css/login.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
</head>

<body>
    <a href="../view/home.php">
        <header class="logo-container">
            <img src="../img/SweetCloud_BTN.png" alt="SweetCloud Logo" class="logo-main" />
            <p class="logo-slogan">Cake & Salty</p>
        </header>
    </a>

    <main class="login-page">
        <div class="login-container">
            <div class="login-header">
                <h1>Entrar</h1>
                <a href="./home.php" class="back-to-home-link">Voltar</a>
            </div>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email" class="sr-only">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="E-mail" required />
                </div>
                <div class="form-group">
                    <label for="password" class="sr-only">Senha</label>
                    <input type="password" id="password" name="senha" placeholder="Senha..." required />
                </div>
                <a href="#" class="forgot-password" style="color: #c14444; font-size: 0.9rem;">Esqueci a minha senha</a>
                <button type="submit" class="btn-primary">Logar</button>
                <?php if (isset($erro)) : ?>
                    <p style="color: red; margin-top: 10px;"><?= $erro ?></p>
                <?php endif; ?>
            </form>

            <p class="or-separator">OU</p>
            <p class="new-user">Novo na SweetCloud? <a href="../view/cadastro.php" class="create-account" style="color: #c14444;">Criar Conta</a></p>

            <div class="social-login">
                <button class="btn-social google">Fazer login com Google</button>
                <button class="btn-social apple">Iniciar Sessão com Apple</button>
            </div>
        </div>
    </main>

    <!-- Modal de Recuperação de Senha -->
    <div id="modalRecuperarSenha" class="modal">
        <div class="modal-content styled-modal">
            <span class="close-modal">&times;</span>
            <h2>Recuperar Senha</h2>
            <form id="form-recuperar-senha" method="POST">
                <input type="text" name="email_cpf" placeholder="E-mail ou CPF" required />
                <button type="submit" class="btn-primary">Enviar link de recuperação</button>
            </form>
            <p id="msg-recuperacao" style="color: green; margin-top: 10px;"></p>
            <p id="erro-senhas" style="color: red; margin-top: 5px;"></p>
        </div>
    </div>

    <footer class="footer">
        <p>&copy;1999-2025 SweetCloud. All Rights Reserved</p>
    </footer>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content.styled-modal {
            background-color: #f9f5e6;
            margin: 10% auto;
            padding: 25px 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            font-family: 'Roboto', sans-serif;
            position: relative;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.3s ease-in-out;
        }

        .modal-content.styled-modal h2 {
            color: #333;
            font-weight: 700;
            font-size: 22px;
            margin-bottom: 15px;
            text-align: center;
        }

        .modal-content.styled-modal form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .modal-content.styled-modal input {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f0f4ff;
            box-sizing: border-box;
            outline: none;
        }

        .modal-content.styled-modal input:focus {
            border-color: #833b14;
        }

        .modal-content .btn-primary {
            background-color: #833b14;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .modal-content .btn-primary:hover {
            background-color: #6e2f10;
        }

        .close-modal {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 22px;
            color: #999;
            cursor: pointer;
            transition: color 0.2s;
        }

        .close-modal:hover {
            color: #333;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @media screen and (max-width: 480px) {
            .modal-content.styled-modal {
                width: 80%;
                padding: 20px;
                margin: 20% auto;
            }

            .modal-content.styled-modal h2 {
                font-size: 18px;
            }

            .modal-content.styled-modal input,
            .modal-content .btn-primary {
                font-size: 14px;
                padding: 8px;
            }

            .close-modal {
                font-size: 20px;
                right: 10px;
                top: 8px;
            }
        }
    </style>

    <script>
        const modal = document.getElementById("modalRecuperarSenha");
        const linkEsqueci = document.querySelector(".forgot-password");
        const spanClose = document.querySelector(".close-modal");
        const formRecuperar = document.getElementById("form-recuperar-senha");
        const msgRecuperacao = document.getElementById("msg-recuperacao");

        // Abrir o modal
        linkEsqueci.addEventListener("click", (e) => {
            e.preventDefault();
            modal.style.display = "block";
        });

        // Fechar o modal
        spanClose.onclick = () => {
            modal.style.display = "none";
        };

        window.onclick = (event) => {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };

        // Submissão do formulário para envio do link por e-mail
        formRecuperar.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(formRecuperar);

            try {
                const response = await fetch("../controllers/recuperar_senha.php", {
                    method: "POST",
                    body: formData,
                });

                const result = await response.text();
                msgRecuperacao.style.color = "green";
                msgRecuperacao.textContent = result;
            } catch (error) {
                msgRecuperacao.style.color = "red";
                msgRecuperacao.textContent = "Erro ao enviar o e-mail de recuperação.";
            }


        });

        function fecharModal() {
            modal.style.display = "none";
            msgRecuperacao.textContent = ""; // limpa a mensagem
            msgRecuperacao.style.color = "green"; // volta pro verde padrão (opcional)
            formRecuperar.reset(); // reseta o formulário, limpa input
        }

        // Fechar o modal pelo "x"
        spanClose.onclick = () => {
            fecharModal();
        };

        // Fechar clicando fora do modal
        window.onclick = (event) => {
            if (event.target === modal) {
                fecharModal();
            }
        };
    </script>
</body>

</html>