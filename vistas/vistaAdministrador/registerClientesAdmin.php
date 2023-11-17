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
    <link rel="stylesheet" href="../../css-vistas/registroIngrediente.css" type="text/css">
    <title>Document</title>
</head>

<body>
    <!-- Aqui importamos la barra de navegacion de bodega -->
    <?php include 'indexAdministrador.php'; ?>

    <section class="home">
        <br>
        <div id="contenedor-principal">
            <p class="tituloRegistro">REGISTRO DE CLIENTES</p>
            <div id="formulario">
                <form class="form-inline" method="post" action="../../controladorBaseDatos/controladorCliente/insertClientes.php" onsubmit="return validarFormulario()">
                    <div class="input-wrapper">

                        <div class="familiaInputs">
                            <label for="nombresCliente">Nombres Completos</label>
                            <i class='bx bxs-user iconR'></i>
                            <input type="text" name="nombresCliente" id="nombresCliente" placeholder="Ej. Edwin David Cantuña Morales" required>
                        </div>

                        <div class="familiaInputs">
                            <label for="cedulaCliente">Cedula Identidad</label>
                            <i class='bx bxs-id-card iconR'></i>
                            <input type="number" name="cedulaCliente" id="cedulaCliente" placeholder="Ej. 1710391023" required>
                        </div>

                        <div class="familiaInputs">
                            <label for="tipoCliente">Tipo de Cliente</label>
                            <i class='bx bx-walk iconR'></i>
                            <select id="tipoCliente" name="tipoCliente" required>
                                <option value="" disabled selected>Selecciona una opción</option>
                                <option value="Personal">Personal</option>
                                <option value="Empresa">Empresa</option>
                            </select>

                        </div>
                    </div>

                    <div class="input-wrapper">
                        <div class="familiaInputs">
                            <label for="direccionCliente">Direccion Domicilio</label>
                            <i class='bx bxs-home-alt-2 iconR'></i>
                            <input type="text" name="direccionCliente" id="direccionCliente" placeholder="Direccion" required>
                        </div>

                        <div class="familiaInputs">
                            <label for="numeroCliente">Número Celular</label>
                            <i class='bx bxs-phone iconR'></i>
                            <input type="number" name="numeroCliente" id="numeroCliente" placeholder="Ej. 0921063832" required>

                        </div>

                        <div class="familiaInputs">
                            <label for="correoCliente">Correo Electronico</label>
                            <i class='bx bxs-envelope iconR'></i>
                            <input type="email" name="correoCliente" id="correoCliente" placeholder="Ej. david@gmail.com" required>
                        </div>
                    </div>

                    <div class="btnRegistrar">
                        <input type="submit" name="submitCliente" value="Registrar Cliente">
                    </div>
                </form>
            </div>
    </section>

    <script src="../../js/FuncionesAdmin/validacionesClientes.js"></script>
</body>

</html>