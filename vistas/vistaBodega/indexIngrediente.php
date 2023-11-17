<?php 
    session_start();

    if (empty($_SESSION['active']) || $_SESSION['rol'] != 2) {
        header('location: indexIngredientes.php');
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BODEGA</title>
    
    <link rel="stylesheet" href="../../css-vistas/navBodega.css" type="text/css">

    <!--script para los iconos-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Aqui importamos JQUERY -->
    <script src="../../js/jquery.min.js" type="text/javascript"></script>

    <!--script font awesome-->
    <script src="https://kit.fontawesome.com/e9c214fcb1.js" crossorigin="anonymous"></script>

    <!--script para el el logo-->
    <link rel="icon" href="../img/LogoVerde.png">
</head>

<body>
    <!-- Modal para el aumento del ingrediente -->
    <div class="modal">
        <div class="bodyModal">
            <form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); sendDataProduct();">
                <h1><i class="fas fa-cubes" style="font-size: 45px;"></i> <br> Agregar Ingrediente </h1>
                <h2 class="nameProducto"></h2><br>
                <input type="number" name="cantidad" id="txtCantidad" placeholder="Cantidad del ingrediente" required> <br>
                <input type="text" name="precio" id="txtPrecio" placeholder="Precio del ingrediente"> <br>
                <input type="hidden" name="producto_id" id="producto_id" required>
                <input type="hidden" name="action" value="addProduct" required>
                <div class="alert alertAddProduct"></div>
                <button type="submit" class="btn_new"><i class="fas fas-plus"></i>Agregar</button>
                <button class="btn_new"><a class="btn_ok closeModal" onclick="closeModal();"><i class="fas fas-ban" style="color:white;"><p>Cerrar</p></i></a></button>
                
            </form>

        </div>
    </div>

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
                        <a href="registerIngrediente.php">
                            <i class='bx bx-body icon'></i>
                            <span class="text nav-text">Registrar</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="tableIngredientes.php">
                            <i class='bx bx-package icon'></i>
                            <span class="text nav-text">Ver</span>
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