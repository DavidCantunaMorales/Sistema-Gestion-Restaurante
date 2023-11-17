<?php

    session_start();

    if (empty($_SESSION['active']) || $_SESSION['rol'] != 1) {
        header('location: ../../index.php');
        exit();
    }

    include('../../controladorBaseDatos/dbconnection.php');
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css-vistas/registroIngrediente.css" type="text/css">
    <title>Document</title>
</head>

<body>
    <!-- Aqui importamos la barra de navegacion de bodega -->
    <?php include 'indexAdministrador.php'; ?>

    <section class="home">
        <br>
        <div id="contenedor-principal">
            <p class="tituloRegistro">REGISTRO DE USUARIOS</p>
            <div id="formulario">
                <form class="form-inline" method="post" action="../../controladorBaseDatos/controladorUsuarios/insertUsuarios.php" onsubmit="return validarFormulario()">
                    <div class="input-wrapper">

                        <div class="familiaInputs">
                            <label for="nombreUsuarios">Nombre Usuario</label>
                            <i class='bx bxs-color iconR'></i>
                            <input id="nombreUsuarios" type="text" name="nombreUsuarios" required placeholder="David">
                        </div>

                        <div class="familiaInputs">
                            <label for="correoUsuario">Correo Usuario</label>
                            <i class='bx bxs-notepad iconR'></i>
                            <input id="correoUsuario" type="text" name="correoUsuario" required placeholder="Ej. edcantuna@gmail.com">
                        </div>

                        <div class="familiaInputs">
                            <label for="usuario">Usuario</label>
                            <i class='bx bx-cart-add iconR'></i>
                            <input id="usuario" type="text" name="usuario" required placeholder="Ej. edcantuna">
                        </div>

                    </div>

                    <div class="input-wrapper">

                        <div class="familiaInputs">
                                <label for="clave">Clave</label>
                                <i class='bx bxs-color iconR'></i>
                                <input id="clave" type="text" name="clave" required placeholder="Ej. ****">
                        </div>

                        <div class="familiaInputs">
                            <label for="rolUsuario">Rol</label>
                            <i class='bx bx-cart-add iconR'></i>

                            <?php 
                                $queryRol = mysqli_query($con, "SELECT * FROM rol");
                                $result = mysqli_num_rows($queryRol);
                            ?>

                            <select name="rolUsuario" id="rolUsuario" required>
                                <option value="" disabled selected>Selecciona una opción</option>
                                <?php
                                    if ($result > 0) {
                                        while ($rol = mysqli_fetch_array($queryRol)) {
                                ?>
                                            <option value="<?php echo $rol['ID_ROL']; ?>"> <?php  echo $rol['ROL']; ?></option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                    </div>

                    <div class="btnRegistrar">
                        <input type="submit" name="submitUsuario" value="Registrar">
                    </div>
                </form>
            </div>
            <br>
        </div>
    </section>

</body>

</html>