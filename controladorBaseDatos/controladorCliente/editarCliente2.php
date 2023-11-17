<?php
    session_start();
//Database Connection
include('../dbconnection.php');
if (isset($_POST['submitCliente'])) {
	$cedula = $_GET['editid'];
	//Getting Post Values

	$nombre = $_POST['nombresCliente'];
	$tipo = $_POST['tipoCliente'];
	$direccion = $_POST['direccionCliente'];
	$celular = $_POST['numeroCliente'];
	$correo = $_POST['correoCliente'];

    //Query for data updation
    $query = mysqli_query($con, "UPDATE clientes SET 
                                                    NOMBRE_CLIENTE='$nombre',
                                                    TIPO_CLIENTE='$tipo', 
                                                    DIRECCION_CLIENTE='$direccion', 
                                                    CELULAR_CLIENTE=$celular,  
                                                    CORREO_CLIENTE='$correo' 
                                                    WHERE CEDULA_CLIENTE=$cedula");

	if ($query) {
		echo "<script>alert('Los Datos han sido actualizados');</script>";
		echo "<script type='text/javascript'> document.location ='../../vistas/vistaCoordinadorPedidos/clientesPedidos.php'; </script>";
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
    <link rel="stylesheet" href="../../css/EdicionIngrediente/estiloEdicionIngrediente.css" type="text/css">
    <title>Document</title>
</head>
<body>
<section class="home">
        <br>
        <div id="contenedor-principal">
            <p class="tituloRegistro">EDITAR INFORMACION DEL CLIENTE</p>
            <div id="formulario">
                <form class="form-inline" method="post" action=" " onsubmit="return validarFormulario()">
                    <?php
                        $cedula = $_GET['editid'];
                        $ret = mysqli_query($con, "select * from clientes where CEDULA_CLIENTE='$cedula'");
                        while ($row = mysqli_fetch_array($ret)) {
                        ?>
                            <div class="input-wrapper">

                                <div class="familiaInputs">
                                    <label for="nombresCliente">Nombres Completos</label>
                                    <i class='bx bxs-user iconR'></i>
                                    <input type="text" name="nombresCliente" id="nombresCliente" 
                                        value="<?php echo $row['NOMBRE_CLIENTE']; ?>" required>
                                </div>

                                <div class="familiaInputs">
                                    <label for="cedulaCliente">Cedula Identidad</label>
                                    <i class='bx bxs-id-card iconR'></i>
                                    <input type="number" name="cedulaCliente" id="cedulaCliente" 
                                        value="<?php echo $row['CEDULA_CLIENTE']; ?>" disabled>
                                </div>

                                <div class="familiaInputs">
                                    <label for="tipoCliente">Tipo de Cliente</label>
                                    <i class='bx bx-walk iconR'></i>
                                    <select id="tipoCliente" name="tipoCliente" required>
                                        <option value="" disabled selected>Selecciona una opción</option>
                                        <option value="Personal" <?php if ($row['TIPO_CLIENTE'] === 'Personal') echo 'selected'; ?>>Personal</option>
                                        <option value="Empresa" <?php if ($row['TIPO_CLIENTE'] === 'Empresa') echo 'selected'; ?>>Empresa</option>
                                    </select>
                                </div>
                            </div>

                            <div class="input-wrapper">
                                <div class="familiaInputs">
                                    <label for="direccionCliente">Direccion Domicilio</label>
                                    <i class='bx bxs-home-alt-2 iconR'></i>
                                    <input type="text" name="direccionCliente" id="direccionCliente" 
                                        value="<?php echo $row['DIRECCION_CLIENTE']; ?>" required>
                                </div>

                                <div class="familiaInputs">
                                    <label for="numeroCliente">Número Celular</label>
                                    <i class='bx bxs-phone iconR'></i>
                                    <input type="number" name="numeroCliente" id="numeroCliente" 
                                        value="<?php echo $row['CELULAR_CLIENTE']; ?>" required>
                                </div>

                                <div class="familiaInputs">
                                    <label for="correoCliente">Correo Electronico</label>
                                    <i class='bx bxs-envelope iconR'></i>
                                    <input type="email" name="correoCliente" id="correoCliente" 
                                        value="<?php echo $row['CORREO_CLIENTE']; ?>" required>
                                </div>
                            </div>

                        <?php
                        } ?>

                        <div class="btnRegistrar">
                            <input type="submit" name="submitCliente" value="Actualizar">
                        </div>
                </form>
            </div>
    </section>
</body>
</html>