<?php
session_start();
//Database Connection
include('../dbconnection.php');
if (isset($_POST['submitIngrediente'])) {
	$idIngrediente = $_GET['editid'];
	//Getting Post Values

	$descripcion = $_POST['descripcionProducto'];
	$stock = $_POST['stockProducto'];
	$unidades = $_POST['unidadesProducto'];
	$precioU = $_POST['costoUProducto'];
	$precioT = $_POST['costoTProducto'];

    $fechaRegistro = date('Y-m-d H:i:s');

    //Query for data updation
    $query = mysqli_query($con, "UPDATE ingredientes SET   ID_INGREDIENTE=$idIngrediente,
                                                       DESCRIPCION_INGREDIENTE='$descripcion',
                                                       STOCK_INGREDIENTE=$stock, 
                                                       UNIDADES_INGREDIENTE='$unidades', 
                                                       PRECIOU_INGREDIENTE=$precioU,  
                                                       PRECIOT_INGREDIENTE=$precioT
                                                 WHERE ID_INGREDIENTE=$idIngrediente");

	if ($query) {
		echo "<script>alert('Los Datos han sido actualizados');</script>";
		echo "<script type='text/javascript'> document.location ='../../vistas/vistaBodega/tableIngredientes.php'; </script>";
	} else {
		echo "<script>alert('Algo salio mal. Por favor intente de nuevo');</script>";
	}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Productos</title>
    <link rel="stylesheet" href="../../css/EdicionIngrediente/estiloEdicionIngrediente.css" type="text/css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="icon" href="../../img/LogoVerde.png">
</head>


<body>

    <section class="home">
        <br>
        <div id="contenedor-principal">
            <p class="tituloRegistro">EDITAR INGREDIENTE</p>
            <div id="formulario">
                <form class="form-inline" method="post" action="" onsubmit="return validarFormulario()">
                    <?php
                        $cedula = $_GET['editid'];
                        $ret = mysqli_query($con, "select * from ingredientes where ID_INGREDIENTE='$cedula'");
                        while ($row = mysqli_fetch_array($ret)) {
                        ?>
                            <div class="input-wrapper">

                                <div class="familiaInputs">
                                    <label for="codigoProducto">Codigo</label>
                                    <i class='bx bxs-color iconR'></i>
                                    <input id="codigoProducto" type="number" name="codigoProducto" 
                                       value="<?php echo $row['ID_INGREDIENTE']; ?>" required>
                                </div>

                                <div class="familiaInputs">
                                    <label for="descripcionProducto">Descripcion</label>
                                    <i class='bx bxs-notepad iconR'></i>
                                    <input id="descripcionProducto" type="text" name="descripcionProducto" 
                                        value="<?php echo $row['DESCRIPCION_INGREDIENTE']; ?>" required>
                                </div>

                                <div class="familiaInputs">
                                    <label for="stockProducto">Stock</label>
                                    <i class='bx bx-cart-add iconR'></i>
                                    <input id="stockProducto" type="number" name="stockProducto" 
                                        value="<?php echo $row['STOCK_INGREDIENTE']; ?>" required>
                                </div>

                            </div>

                            <div class="input-wrapper">

                                <div class="familiaInputs">
                                    <label for="unidadesProducto">Unidades</label>
                                    <i class='bx bx-cart-add iconR'></i>
                                    <select name="unidadesProducto" id="unidadesProducto" required>
                                        <option value="" disabled selected>Selecciona una opción</option>
                                        <option value="Gramos"  <?php if ($row['UNIDADES_INGREDIENTE'] === 'Gramos') echo 'selected'; ?> >Gramos</option>
                                        <option value="Kilogramos"  <?php if ($row['UNIDADES_INGREDIENTE'] === 'Kilogramos') echo 'selected'; ?> >Kilogramos</option>
                                        <option value="Litros"  <?php if ($row['UNIDADES_INGREDIENTE'] === 'Litros') echo 'selected'; ?> >Litros</option>
                                        <option value="Cucharadas  <?php if ($row['UNIDADES_INGREDIENTE'] === 'Cucharadas') echo 'selected'; ?> ">Cucharadas</option>
                                        <option value="Libras"  <?php if ($row['UNIDADES_INGREDIENTE'] === 'Libras') echo 'selected'; ?> >Libras</option>
                                        <option value="Onzas"  <?php if ($row['UNIDADES_INGREDIENTE'] === 'Onzas') echo 'selected'; ?> >Onzas</option>
                                        <option value="Quintal"  <?php if ($row['UNIDADES_INGREDIENTE'] === 'Quintal') echo 'selected'; ?> >Quintal</option>
                                    </select>
                                </div>

                                <div class="familiaInputs">
                                    <label for="costoUProducto">Precio Unitario</label>
                                    <i class='bx bxs-color iconR'></i>
                                    <input id="costoUProducto" type="number" name="costoUProducto" 
                                        value="<?php echo $row['PRECIOU_INGREDIENTE']; ?>" step="0.01" required placeholder="Ej. 1">
                                </div>

                                <div class="familiaInputs">
                                    <label for="costoTProducto">Precio Total</label>
                                    <i class='bx bxs-notepad iconR'></i>
                                    <input id="costoTProducto" type="number" name="costoTProducto" 
                                        value="<?php echo $row['PRECIOT_INGREDIENTE']; ?>" readonly>
                                </div>
                            </div>

                            <?php
                        } ?>

                    <div class="btnRegistrar">
                        <input type="submit" name="submitIngrediente" value="Actualizar" >
                    </div>
                </form>
            </div>

            <br>
        </div>

    </section>

    <!--cript para los iconos-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>