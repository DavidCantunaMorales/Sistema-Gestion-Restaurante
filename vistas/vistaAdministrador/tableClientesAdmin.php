<?php
session_start();

if (empty($_SESSION['active']) || $_SESSION['rol'] != 1) {
    header('location: ../../index.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../../css-vistas/tablaIngrediente.css">
    <title>Document</title>
</head>

<body>
    <!-- Aqui importamos la barra de navegacion de bodega -->
    <?php include 'indexAdministrador.php'; ?>

    <section class="home">
            <!-- Aqui ponemos ya el contenido que tendra -->
            <br>
            <br>
            <div class="wrapper">
                <h2 class="tituloRegistro" style="text-align: center;" >TABLA DE REGISTROS DE PEDIDOS</h2>
                <div id="contenedor-busqueda">
                <br>
                    <div id="busqueda">
                        <label for="">Buscar Registro:</label>
                        <i class='bx bxs-search-alt-2'style="left: 30%" ></i>
                        <input type="text" id="buscarProducto-input" onkeyup="filtroTablaProductos()" placeholder="Ingrese el nombre">
                    </div>
                </div>
                <br>
                <table id="tablaRegistroPedidos">
                    <thead>
                        <tr>
                            <th>Cedula</th>
                            <th>Nombre Cliente</th>
                            <th>Tipo</th>
                            <th>Direccion</th>
                            <th>Celular</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('../../controladorBaseDatos/dbconnection.php');
                        $ret = mysqli_query($con, "select * from clientes");
                        $cnt = 1;
                        $row = mysqli_num_rows($ret);
                        if ($row > 0) {
                            while ($row = mysqli_fetch_array($ret)) {

                        ?>
                                <tr <?php if ($row['ESTADO_CLIENTE'] == 0) echo 'style="background-color: rgb(255, 128, 0, 0.4);;"'; ?>>
                                    <td> <?php echo $row['CEDULA_CLIENTE']; ?> </td>
                                    <td> <?php echo $row['NOMBRE_CLIENTE']; ?> </td>
                                    <td> <?php echo $row['TIPO_CLIENTE']; ?> </td>
                                    <td> <?php echo $row['DIRECCION_CLIENTE']; ?> </td>
                                    <td> <?php echo $row['CELULAR_CLIENTE']; ?> </td>
                                    <td> <?php echo $row['CORREO_CLIENTE']; ?> </td>
                                    <td> <?php
                                            if ($row['ESTADO_CLIENTE'] == 0) {
                                                echo 'Inactivo';
                                            } elseif ($row['ESTADO_CLIENTE'] == 1) {
                                                echo 'Activo';
                                            } else {
                                                echo 'Estado desconocido';
                                            }
                                         ?></td>
                                    <td>
                                        <?php if ($row['ESTADO_CLIENTE'] == 1) : ?>
                                                                                        
                                            <a href="../../controladorBaseDatos/controladorCliente/editarCliente.php?editid=<?php echo htmlentities($row['CEDULA_CLIENTE']); ?>" 
                                                class="edit" title="Editar" data-toggle="tooltip">
                                                <i class="material-icons">&#xE254;</i>
                                            </a>
                                            
                                            <a href="../../controladorBaseDatos/controladorCliente/stateCliente.php?desactivarid=<?php echo ($row['CEDULA_CLIENTE']); ?>" 
                                                class="delete" title="Desactivar" data-toggle="tooltip" 
                                                onclick="return confirm('El Cliente sera Desactivado');">
                                                <i class="material-icons">&#xE5C9;</i>
                                            </a>

                                            <a href="../../controladorBaseDatos/controladorCliente/stateCliente.php?activacionid=<?php echo ($row['CEDULA_CLIENTE']); ?>" 
                                                lass="delete" title="Activar" data-toggle="tooltip" 
                                                onclick="return confirm('El Cliente sera Activado');">
                                                <i class="material-icons">&#xE86C;</i>
                                            </a>

                                        <?php else : ?>
                                            
                                            <a href="../../controladorBaseDatos/controladorCliente/stateCliente.php?activacionid=<?php echo ($row['CEDULA_CLIENTE']); ?>" 
                                                lass="delete" title="Activar" data-toggle="tooltip" 
                                                onclick="return confirm('El Cliente sera Activado');">
                                                <i class="material-icons">&#xE86C;</i>
                                            </a>

                                        <?php endif; ?>
                                    </td>
                                </tr>

                            <?php
                                $cnt = $cnt + 1;
                            }
                        } else { ?>
                            <tr>
                                <th style="text-align:center; color:white;" colspan="8">Registros no Existentes</th>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
                <br>
            </div>
        </div>

    </section>

    <script src="../../js/FuncionesAdmin/validacionesClientes.js"></script>
</body>


</html>