<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>SweetCloud</title>
    <link rel="icon" href="../img/SweetCloud-logo.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/main.css">
</head>

<body>
    <header>
        <div class="container">
            <a href="../view/home.php">
                <div class="logo">
                    <img src="../img/SweetCloud_BTN.png" alt="Logo">
                </div>
            </a>

            <div class="menu-toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>

            <nav class="nav-menu"> <ul>
                    <li><a href="../view/home.php">Home</a></li>
                    <li><a href="../view/produtos.php">Produtos</a></li>
                    <li><a href="#contact-section">Contato</a></li>
                    <li><a href="../view/sobrenos.php">Sobre Nós</a></li>
                </ul>
            </nav>

            <div class="nav-right">
                <div class="user-section">
                    <?php
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['nome'])) :
                        $userName = $_SESSION['usuario']['nome'];
                        $nameParts = explode(' ', $userName);
                        $initials = strtoupper(substr($nameParts[0], 0, 1));
                        if (count($nameParts) > 1) {
                            $initials .= strtoupper(substr(end($nameParts), 0, 1));
                        }
                    ?>
                        <div id="userProfileToggle">
                            <div class="user-profile-logado" id="userProfileToggle">
                                <div class="user-profile-circle">
                                    <?php echo $initials; ?>
                                </div>
                                <p><?php echo htmlspecialchars($userName); ?></p>
                            </div>
                        </div>
                        <div class="dropdown-menu" id="userDropdownMenu">
                            <a href="../view/meusdados.php">Ver perfil</a>
                            <a href="../view/logout.php">Sair</a>
                        </div>
                    <?php else : ?>
                        <div class="user-icon" id="userProfileToggle">
                            <a href="../view/meusdados.php">
                                <img src="../img/LoginUser.png" alt="User Profile">
                                <p>Entrar</p>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="cart-icon">
                        <a href="../view/carrinho.php">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-count" id="cartCount">0</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <script src="../js/perfil.js"></script>
