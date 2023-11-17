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
    <title>Recetas</title>
    <link type="text/css" rel="stylesheet" href="../../css-vistas/tablaIngrediente.css">
    <script src="../../js/jquery.min.js" type="text/javascript"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <!--script font awesome-->
    <script src="https://kit.fontawesome.com/e9c214fcb1.js" crossorigin="anonymous"></script>
</head>

<body>

    <!-- Aqui importamos la barra de navegacion de bodega -->
    <?php include 'indexPedidos.php'; ?>

    <section class="home">
            <!-- Aqui ponemos ya el contenido que tendra -->
            <br>
            <br>
            <div class="wrapper">
                <h2 class="tituloRegistro" style="text-align: center;" >TABLA DE REGISTROS DE PEDIDOS</h2>
                <br>
                <table id="tablaRegistroPedidos">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Costo</th>
                            <th>Estado</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('../../controladorBaseDatos/dbconnection.php');
                        $ret = mysqli_query($con, "select * from pedido");
                        $cnt = 1;
                        $row = mysqli_num_rows($ret);
                        if ($row > 0) {
                            while ($row = mysqli_fetch_array($ret)) {

                        ?>
                                <tr class="row<?php echo $row['ID_PEDIDO']; ?>" <?php if ($row['ESTADO_PEDIDO'] == 0) echo 'style="background-color: rgb(255, 128, 0, 0.4);"'; ?>>
                                    <td> <?php echo $row['ID_PEDIDO']; ?> </td>
                                    <td> <?php echo $row['CEDULA_CLIENTE']; ?> </td>
                                    <td> <?php echo $row['FECHA_PEDIDO']; ?> </td>
                                    <td> <?php echo $row['COSTO_PEDIDO']; ?> </td>
                                    <td> <?php
                                            if ($row['ESTADO_PEDIDO'] == 0) {
                                                echo 'Inactivo';
                                            } elseif ($row['ESTADO_PEDIDO'] == 1) {
                                                echo 'Activo';
                                            } else {
                                                echo 'Estado desconocido';
                                            }
                                            ?></td>
                                    <td>
                                        <?php if ($row['ESTADO_PEDIDO'] == 1) : ?>

                                            <button class="btn_view view_pedido" type="button" cliente="<?php echo $row['CEDULA_CLIENTE'];?>" pedido="<?php echo $row['ID_PEDIDO'];?>"
                                                style="background-color: white; border: 0">
                                                <i class="material-icons">&#xE417;</i>
                                            </button> 

                                        <?php else : ?>

                                            <a href="php/read.php?viewid=<?php echo htmlentities($row['ID_PEDIDO']); ?>" class="view" title="Ver" data-toggle="tooltip">
                                                <i class="material-icons">&#xE417;</i>
                                            </a>

                                            <a href="../../controladorBaseDatos/?php echo ($row['ID_PEDIDO']); ?>" lass="delete" title="Activar" data-toggle="tooltip" onclick="return confirm('El Cliente sera Activado');">
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

    <script src="../../js/FuncionesCoordPedidos/scriptPedidos.js"></script>
    <script src="../../js/FuncionesCoordPedidos/validacionesPedidos.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>