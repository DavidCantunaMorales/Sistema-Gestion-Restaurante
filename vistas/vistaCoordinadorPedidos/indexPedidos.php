<?php 
    session_start();

    if (empty($_SESSION['active']) || $_SESSION['rol'] != 4) {
        header('location: ../../index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RECETAS</title>
    
    <link rel="stylesheet" href="../../css-vistas/navBodega.css" type="text/css">

    <!--script para los iconos-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Aqui importamos JQUERY -->
    <script src="../../js/jquery.min.js" type="text/javascript"></script>

    <!--script font awesome-->
    <script src="https://kit.fontawesome.com/e9c214fcb1.js" crossorigin="anonymous"></script>

    <!--script para el el logo-->
    <link rel="icon" href="../img/LogoVerde.png">
</head>

<body>

    <nav class="sidebar">

        <header>
            <div class="text logo">
                <span class="name">GRUPO 3</span>
                <span class="profe">Desarollador</span>
            </div>

            <i class="bx bx-menu toggle"></i>
        </header>

        <div class="menu-bar">

            <div id="fotoPerfil">
                <img class="text nav-text" src="../../img/fotoPerfil.png" alt="Foto de Perfil">
                <span class="text nav-text">Bienvenido David</span>
            </div>

            <div class="menu">

                <ul class="menu-links">

                    <li class="nav-link">
                        <a href="registerPedidos.php">
                            <i class='bx bx-body icon'></i>
                            <span class="text nav-text">Agregar Pedido</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="tablePedidos.php">
                            <i class='bx bx-package icon'></i>
                            <span class="text nav-text">Tabla Pedidos</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="clientesPedidos.php">
                            <i class='bx bx-package icon'></i>
                            <span class="text nav-text">Ver Clientes</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="recetasPedidos.php">
                            <i class='bx bx-package icon'></i>
                            <span class="text nav-text">Ver Recetas</span>
                        </a>
                    </li>
                    
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="../../html/salirSesion.php">
                        <i class="bx bx-log-out icon"></i>
                        <span class="text nav-text">Salir</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>

    <!-- Script para que el menu se encoja -->
    <script>
        const body = document.querySelector('body'),
            sidebar = body.querySelector('nav'),
            toggle = body.querySelector(".toggle"),
            searchBtn = body.querySelector(".search-box"),
            modeSwitch = body.querySelector(".toggle-switch"),
            modeText = body.querySelector(".mode-text");


        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });
    </script>

    <script src="../../js/FuncionesBodega/scriptIngredientes.js"></script>
    <!--script para los iconos-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>