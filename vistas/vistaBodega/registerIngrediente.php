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
    <link rel="stylesheet" href="../../css-vistas/registroIngrediente.css" type="text/css">
    <link type="text/css" rel="stylesheet" href="../../css-vistas/tablaIngrediente.css">
    <title>Añadir Ingrediente</title>
</head>

<body>
    <!-- Aqui importamos la barra de navegacion de bodega -->
    <?php include 'indexIngrediente.php'; ?>

    <section class="home">
        <br>
        <div id="contenedor-principal">
            <p class="tituloRegistro">REGISTRO DE INGREDIENTES</p>
            <div id="formulario">
                <form class="form-inline" method="post" action="../../controladorBaseDatos/controladorIngrediente/insertIngrediente.php" onsubmit="return validarFormulario()">
                    <div class="input-wrapper">

                        <div class="familiaInputs">
                            <label for="codigoProducto">Codigo</label>
                            <i class='bx bxs-color iconR'></i>
                            <input id="codigoProducto" type="number" name="codigoProducto" required placeholder="Ej. 1">
                        </div>

                        <div class="familiaInputs">
                            <label for="descripcionProducto">Descripcion</label>
                            <i class='bx bxs-notepad iconR'></i>
                            <input id="descripcionProducto" type="text" name="descripcionProducto" required placeholder="Ej. Cebolla">
                        </div>

                        <div class="familiaInputs">
                            <label for="stockProducto">Stock</label>
                            <i class='bx bx-cart-add iconR'></i>
                            <input id="stockProducto" type="number" name="stockProducto" required placeholder="Ej. 10">
                        </div>

                    </div>

                    <div class="input-wrapper">

                        <div class="familiaInputs">
                            <label for="unidadesProducto">Unidades</label>
                            <i class='bx bx-cart-add iconR'></i>
                            <select name="unidadesProducto" id="unidadesProducto" required>
                                <option value="" disabled selected>Selecciona una opción</option>
                                <option value="Gramos">Gramos</option>
                                <option value="Kilogramos">Kilogramos</option>
                                <option value="Litros">Litros</option>
                                <option value="Cucharadas">Cucharadas</option>
                                <option value="Libras">Libras</option>
                                <option value="Onzas">Onzas</option>
                                <option value="Quintal">Quintal</option>
                            </select>
                        </div>

                        <div class="familiaInputs">
                            <label for="costoUProducto">Precio Unitario</label>
                            <i class='bx bxs-color iconR'></i>
                            <input id="costoUProducto" type="number" name="costoUProducto" step="0.01" required placeholder="Ej. 1">
                        </div>

                        <div class="familiaInputs">
                            <label for="costoTProducto">Precio Total</label>
                            <i class='bx bxs-notepad iconR'></i>
                            <input id="costoTProducto" type="number" name="costoTProducto" readonly>
                        </div>

                    </div>

                    <div class="btnRegistrar">
                        <input type="submit" name="submitIngrediente" value="Registrar">
                    </div>
                </form>
            </div>
            <br>
        </div>
    </section>

    <script>
        function validarFormulario() {
            var codigoProducto = document.getElementById("codigoProducto").value;
            var stockProducto = document.getElementById("stockProducto").value;
            var costoUProducto = document.getElementById("costoUProducto").value;

            if (codigoProducto <= 0 || stockProducto <= 0 || costoUProducto <= 0) {
                alert("No se permiten números negativos en los campos numéricos");
                return false; // Evita que el formulario se envíe
            }

            return true; // Permite que el formulario se envíe si no hay números negativos
        }
    </script>

    <script src="../../js/FuncionesBodega/validacionesIngredientes.js"></script>

</body>

</html>