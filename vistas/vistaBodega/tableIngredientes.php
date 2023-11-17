<?php 
    session_start();

    if (empty($_SESSION['active']) || $_SESSION['rol'] != 2) {
        header('location: ../../index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link type="text/css" rel="stylesheet" href="../../css-vistas/tablaIngrediente.css">
    <script src="../../js/jquery.min.js" type="text/javascript"></script>
</head>

<body>

    <!-- Aqui importamos la barra de navegacion de bodega -->
    <?php include 'indexIngrediente.php'; ?>

    <section class="home">
            <!-- Aqui ponemos ya el contenido que tendra -->

            <br>
            <br>
            <div class="wrapper">
                <h2 class="tituloRegistro" style="text-align: center;"> 
                    TABLA DE REGISTROS DE INGREDIENTES
                </h2>
                <br>
                <div id="contenedor-busqueda">
                    <div id="busqueda">
                        <label for="">Buscar Ingrediente</label>
                        <i class='bx bxs-search-alt-2'></i>
                        <input type="text" id="buscarProducto-input" onkeyup="filtroTablaProductos()" placeholder="Ingrese el nombre del ingrediente">
                    </div>
                </div>
                <br>
                <table id="tablaRegistroProductos">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Descripcion</th>
                            <th>Stock</th>
                            <th>Unidades</th>
                            <th>Precion Unitario</th>
                            <th>Precio Total</th>
                            <th>Estado</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('../../controladorBaseDatos/dbconnection.php');
                        $ret = mysqli_query($con, "select * from ingredientes");
                        $cnt = 1;
                        $row = mysqli_num_rows($ret);
                        if ($row > 0) {
                            while ($row = mysqli_fetch_array($ret)) {

                        ?>
                                <tr class="row<?php echo $row['ID_INGREDIENTE']; ?>" <?php if ($row['ESTADO_INGREDIENTE'] == 0) echo 'style="background-color: rgb(255, 128, 0, 0.4);"'; ?>>
                                    <td> <?php echo $row['ID_INGREDIENTE']; ?> </td>
                                    <td> <?php echo $row['DESCRIPCION_INGREDIENTE']; ?> </td>
                                    <td class="celStock"> <?php echo $row['STOCK_INGREDIENTE']; ?> </td>
                                    <td> <?php echo $row['UNIDADES_INGREDIENTE']; ?> </td>
                                    <td> <?php echo $row['PRECIOU_INGREDIENTE']; ?> </td>
                                    <td class="celPrecio"> <?php echo $row['PRECIOT_INGREDIENTE']; ?> </td>
                                    <td> <?php
                                            if ($row['ESTADO_INGREDIENTE'] == 0) {
                                                echo 'Inactivo';
                                            } elseif ($row['ESTADO_INGREDIENTE'] == 1) {
                                                echo 'Activo';
                                            } else {
                                                echo 'Estado desconocido';
                                            }
                                            ?></td>
                                    <td>
                                        <?php if ($row['ESTADO_INGREDIENTE'] == 1) : ?>

                                            <a class="link_add add_product" producto="<?php echo $row['ID_INGREDIENTE']; ?>" href="#">
                                                <i class="material-icons">&#xE147;</i>
                             
                                            </a>

                                            <a href="../../controladorBaseDatos/controladorIngrediente/editarIngrediente.php?editid=<?php echo htmlentities($row['ID_INGREDIENTE']); ?>" class="edit" title="Editar" data-toggle="tooltip">
                                                <i class="material-icons">&#xE254;</i>
                                            </a>

                                            <a href="../../controladorBaseDatos/controladorIngrediente/stateIngrediente.php?desactivarid=<?php echo ($row['ID_INGREDIENTE']); ?>" class="delete" title="Desactivar" data-toggle="tooltip" onclick="return confirm('El Cliente sera Desactivado');">
                                                <i class="material-icons">&#xE5C9;</i>
                                            </a>

                                            <a href="../../controladorBaseDatos/controladorIngrediente/stateIngrediente.php?activacionid=<?php echo ($row['ID_INGREDIENTE']); ?>" lass="delete" title="Activar" data-toggle="tooltip" onclick="return confirm('El Cliente sera Activado');">
                                                <i class="material-icons">&#xE86C;</i>
                                            </a>

                                        <?php else : ?>

                                            <a href="../../controladorBaseDatos/controladorIngrediente/stateIngrediente.php?activacionid=<?php echo ($row['ID_INGREDIENTE']); ?>" lass="delete" title="Activar" data-toggle="tooltip" onclick="return confirm('El Cliente sera Activado');">
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

    <script src="../../js/FuncionesBodega/scriptIngredientes.js"></script>
    <script src="../../js/FuncionesBodega/validacionesIngredientes.js"></script>

</body>
</html>