<?php 
    session_start();

    if (empty($_SESSION['active']) || $_SESSION['rol'] != 3) {
        header('location: ../../index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetas</title>

    <!-- ESTILOS -->
    <link rel="stylesheet" href="../../css-vistas/registroReceta.css" type="text/css">

    <!-- ICONOS Y LETRA -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e9c214fcb1.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Aqui importamos JQUERY -->
    <script src="../../js/jquery.min.js" type="text/javascript"></script>
    <!-- Aqui esta la imgen del logo -->
    <link rel="icon" href="../img/LogoVerde.png">
</head>

<body>
    <?php include 'indexRecetas.php'; ?>

    <section class="home">
        <br>
        <div id="contenedor-principal">
            <p class="tituloRegistro">REGISTRO DE RECETAS</p>
            <div id="formulario">
                <form class="form-inline" action="" method="post">
                    <div class="input-wrapper">

                        <div class="familiaInputs">
                            <label for="tipoCliente">Nombre Receta</label>
                            <i class='bx bxs-bowl-hot iconR'></i>
                            <input type="text" name="nombreReceta" id="nombreReceta" placeholder="Ej. Sopa de Tomate" required>
                        </div>

                        <div class="familiaInputs">
                            <label for="tipoComida">Tipo de Comida</label>
                            <i class='bx bxs-food-menu iconR'></i>
                            <select id="tipoComida" name="tipoComida" required>
                                <option value="" disabled selected>Selecciona una opción</option>
                                <option value="Sopas">Sopas</option>
                                <option value="Platos Fuertes">Platos Fuertes</option>
                                <option value="Postres">Postres</option>
                                <option value="Bebidas">Bebidas</option>
                            </select>
                        </div>

                        <div class="familiaInputs">
                            <label for="tiempoPreparacion">Tiempo de Preparación</label>
                            <i class='bx bxs-bowl-hot iconR'></i>
                            <input type="text" name="tiempoPreparacion" id="tiempoPreparacion" placeholder="Ej. 30 minutos" required>
                        </div>

                    </div>
                    <!--Aqui va la lista de los ingredientes que se encuentran disponibles en la base de datos-->
                    <div class="wrapper">
                        <br>
                        <p class="tituloRegistro">TABLA DE REGISTROS DE INGREDIENTES</p>
                        <br>
                        <table id="tablaRegistroProductos" class="tbl_ingredientes">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Descripcion</th>
                                    <th>Stock</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Precio Total</th>
                                    <th>Accion</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="txt_cod_ingrediente" id="txt_cod_ingrediente">
                                    </td>
                                    <td id="txt_descripcion"> - </td>
                                    <td id="txt_existencia"> - </td>
                                    <td>
                                        <input type="text" name="txt_cant_ingrediente" id="txt_cant_ingrediente" value="0" min="1" step="0.01" disabled>
                                    </td>
                                    <td id="txt_precio">0.00</td>
                                    <td id="txt_precio_total">0.00</td>
                                    <td>
                                        <a href="#" id="add_ingrediente_receta">
                                            <i class="fas fa-plus-circle" style="color: green; font-size: 20px;"></i>
                                        </a>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <br>
                    <!--Aqui va la lista de los ingredientes que se encuentran disponibles en la base de datos-->
                    <div class="wrapper">
                        <p class="tituloRegistro">TABLA DE PRODUCTOS REGISTRADOS CON LA RECETA</p>
                        <br>
                        <table id="receta">
                            <thead>
                                <tr>
                                    <th>Id Producto</th>
                                    <th>Descripcion</th>
                                    <th>Cantidad Requerida</th>
                                    <th>Precio</th>
                                    <th>Precio Total</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody id="detalleReceta">
                                <!-- Contenido AJAX -->

                            </tbody>
                            <tfoot id="detalle_totalesR">
                                <!-- Contenido AJAX -->

                            </tfoot>
                        </table>
                    </div>

                    <div class="btnRegistrar">
                        <input type="submit" name="submitReceta" id="btnRegistrarReceta" value="Registrar">
                    </div>
                </form>
            </div>
            <br>
        </div>

    </section>

    <!-- Mantener los datos en la pantalla -->
    <script type="text/javascript">
        $(document).ready(function() {
            //var usuarioId = '<?php echo $usuarioId['idUser'] ?>';
            var usuarioTemp = "1234312";
            serchForDetalle(usuarioTemp);
        });
    </script>


    <!-- SCRIPTS -->
    <script src="../../js/FuncionesChefRecetas/scriptRecetas.js"></script>


    <!--cript para los iconos-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>