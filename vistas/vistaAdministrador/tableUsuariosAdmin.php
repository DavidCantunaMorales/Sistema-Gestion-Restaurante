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
                <h2 class="tituloRegistro" style="text-align: center;" >TABLA DE REGISTROS DE USUARIOS</h2>
                <div id="contenedor-busqueda">
                    <div id="busqueda">
                        <label for="">Buscar Registro:</label>
                        <i class='bx bxs-search-alt-2' style="left: 30%"></i>
                        <input type="text" id="buscarProducto-input" onkeyup="filtroTablaUsuarios()" placeholder="Ingrese el codigo del producto">
                    </div>
                </div>
                <br>
                <table id="tablaRegistroUsuarios">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Usuario</th>
                            <th>Clave</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('../../controladorBaseDatos/dbconnection.php');
                        $ret = mysqli_query($con, "select * from usuarios");
                        $cnt = 1;
                        $row = mysqli_num_rows($ret);
                        if ($row > 0) {
                            while ($row = mysqli_fetch_array($ret)) {

                        ?>
                                <tr class="row<?php echo $row['ID_USUARIO']; ?>" <?php if ($row['ESTADO_USUARIO'] == 0) echo 'style="background-color: rgb(255, 128, 0, 0.4);"'; ?>>
                                    <td> <?php echo $row['ID_USUARIO']; ?> </td>
                                    <td> <?php echo $row['NOMBRE_USUARIO']; ?> </td>
                                    <td> <?php echo $row['CORREO_USUARIO']; ?> </td>
                                    <td> <?php echo $row['USUARIO']; ?> </td>
                                    <td> <?php echo $row['CLAVE']; ?> </td>
                                    <td> <?php
                                            if ($row['ROL'] == 1) {
                                                echo 'Administrador';
                                            } elseif ($row['ROL'] == 2) {
                                                echo 'Bodeguero';
                                            } elseif ($row['ROL'] == 3) {
                                                echo 'Chef';
                                            } elseif ($row['ROL'] == 4) {
                                                echo 'Coordinador';
                                            } else {
                                                echo 'Rol desconocido';
                                            }
                                            ?>
                                    </td>
                                    <td> <?php
                                            if ($row['ESTADO_USUARIO'] == 0) {
                                                echo 'Inactivo';
                                            } elseif ($row['ESTADO_USUARIO'] == 1) {
                                                echo 'Activo';
                                            } else {
                                                echo 'Estado desconocido';
                                            }
                                            ?>
                                    </td>
                                    <td>
                                        <?php if ($row['ESTADO_USUARIO'] == 1) : ?>

                                            <a href="../../controladorBaseDatos/controladorUsuarios/editUsuario.php?editid=<?php echo htmlentities($row['ID_USUARIO']); ?>" class="edit" title="Editar" data-toggle="tooltip">
                                                <i class="material-icons">&#xE254;</i>
                                            </a>

                                            <a href="../../controladorBaseDatos/controladorUsuarios/stateUsuario.php?desactivarid=<?php echo ($row['ID_USUARIO']); ?>" class="delete" title="Desactivar" data-toggle="tooltip" onclick="return confirm('El Cliente sera Desactivado');">
                                                <i class="material-icons">&#xE5C9;</i>
                                            </a>

                                            <a href="../../controladorBaseDatos/controladorUsuarios/stateUsuario.php?activacionid=<?php echo ($row['ID_USUARIO']); ?>" lass="delete" title="Activar" data-toggle="tooltip" onclick="return confirm('El Cliente sera Activado');">
                                                <i class="material-icons">&#xE86C;</i>
                                            </a>

                                        <?php else : ?>

                                            <a href="../../controladorBaseDatos/controladorUsuarios/stateUsuario.php?activacionid=<?php echo ($row['ID_USUARIO']); ?>" lass="delete" title="Activar" data-toggle="tooltip" onclick="return confirm('El Cliente sera Activado');">
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