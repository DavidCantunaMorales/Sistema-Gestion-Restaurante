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
    <title>Facturas</title>

    <!-- ESTILOS -->
    <link rel="stylesheet" href="../../css-vistas/registroPedido.css" type="text/css">
    
    <!-- ICONOS Y LETRA -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e9c214fcb1.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Aqui importamos JQUERY -->
    <script src="../../js/jquery.min.js" type="text/javascript"></script>
    <link rel="icon" href="../img/LogoVerde.png">
</head>


<body>

    <?php include 'indexPedidos.php'; ?>

    <section class="home">

        <form onsubmit="return validarFormulario()">
            <div id="contenedor-principal">
                <br>
                <p class="tituloRegistro">DATOS DEL PEDIDO</p>

                <div class="contenido-datos">

                    <div class="cliente-info">

                        <div class="familiaInputsCliente">
                            <label for="cedulaCliente">Cedula Identidad:</label>
                            <input type="number" name="cedulaCliente" id="cedulaCliente" required>
                        </div>

                        <div class="familiaInputsCliente">
                            <label for="nombresCliente">Nombres Completos:</label>
                            <input type="text" name="nombresCliente" id="nombresCliente" disabled required>

                        </div>

                        <div class="familiaInputsCliente">
                            <label for="tipoCliente">Tipo de Cliente:</label>
                            <input type="text" name="tipoCliente" id="tipoCliente" disabled required>
                        </div>

                        <div class="familiaInputsCliente">
                            <label for="direccionCliente">Direccion Domicilio:</label>
                            <input type="text" name="direccionCliente" id="direccionCliente" disabled required>
                        </div>

                        <div class="familiaInputsCliente">
                            <label for="numeroCliente">Numero Celular:</label>
                            <input type="number" name="numeroCliente" id="numeroCliente" disabled required>

                        </div>

                        <div class="familiaInputsCliente">
                            <label for="correoCliente">Correo Electronico:</label>
                            <input type="email" name="correoCliente" id="correoCliente" disabled required>
                        </div>

                    </div>
                </div>

                <!--Aqui va la lista de los ingredientes que se encuentran disponibles en la base de datos-->
                <div class="wrapper">
                    <br>
                    <p class="tituloRegistro">TABLA DE REGISTROS DE RECETAS</p>
                    <br>
                    <table id="tablaRegistroRecetas" class="tbl_recetas">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Precio Total</th>
                                <th>Accion</th>
                            </tr>
                            <tr>
                                <td id="txt_cod_receta"> - </td>
                                <td>
                                    <input type="text" name="txt_descripcion_receta" id="txt_descripcion_receta">
                                </td>
                                <td>
                                    <input type="text" name="txt_cant_receta" id="txt_cant_receta" value="0" min="1" disabled>
                                </td>
                                <td id="txt_precio_receta">0.00</td>
                                <td id="txt_precio_total_receta">0.00</td>
                                <td>
                                    <a href="#" id="add_receta_pedido">
                                       <i class="fas fa-plus-circle" style="color: green; font-size: 20px;"></i>
                                    </a>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>

                <br>

                <div class="descripcion-info">
                    <p class="tituloRegistro">DETALLES DEL PEDIDO</p>
                    <table id="pedidos">
                        <thead>
                            <tr>
                                <th>Id Receta</th>
                                <th>Nombre Receta</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Precio Total</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="detallePedido">
                            <!-- Aqui se agrega Dinamicamente -->
                        </tbody>
                        <tfoot id="detalle_totalesP">
                            <!-- Contenido AJAX -->

                        </tfoot>
                    </table>
                </div>
                <br>
                <div class="btnRegistrar">
                    <input type="submit" name="register" id="btnRegistrarPedido" value="Registrar Pedido">
                </div>
            </div>
        </form>

    </section>

    <script type="text/javascript">
        $(document).ready(function() {
            //var usuarioId = '<?php echo $usuarioId['idUser'] ?>';
            var usuarioTemp = "1234313";
            serchForDetalle(usuarioTemp);
        });
    </script>

    <!-- SCRIPTS -->
    <script src="../../js/FuncionesCoordPedidos/scriptPedidos.js"></script>
    <script src="../../js/FuncionesCoordPedidos/validacionesPedidos.js"></script>

    <!-- script para los iconos-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>