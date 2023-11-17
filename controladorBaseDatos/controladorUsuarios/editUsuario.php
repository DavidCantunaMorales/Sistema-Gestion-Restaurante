<?php
session_start();
//Database Connection
include('../dbconnection.php');
if (isset($_POST['submitUsuario'])) {
	$idUser = $_GET['editid'];
	//Getting Post Values

	$nombre = $_POST['nombreUsuarios'];
	$correo = $_POST['correoUsuario'];
	$usuario = $_POST['usuario'];
	$clave = $_POST['clave'];
	$rol = $_POST['rolUsuario'];


    //Query for data updation
    $query = mysqli_query($con, "UPDATE usuarios SET 
                                                    NOMBRE_USUARIO='$nombre',
                                                    CORREO_USUARIO='$correo', 
                                                    USUARIO='$usuario', 
                                                    CLAVE='$clave',  
                                                    ROL='$rol' 
                                                    WHERE ID_USUARIO='$idUser'");

	if ($query) {
		echo "<script>alert('Los Datos han sido actualizados');</script>";
		echo "<script type='text/javascript'> document.location ='../../vistas/vistaAdministrador/tableUsuariosAdmin.php'; </script>";
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
                        $idUser = $_GET['editid'];
                        $ret = mysqli_query($con, "select * from usuarios where ID_USUARIO='$idUser'");
                        while ($row = mysqli_fetch_array($ret)) {
                        ?>
                            <div class="input-wrapper">

                                <div class="familiaInputs">
									<label for="nombreUsuarios">Nombre Usuario</label>
									<i class='bx bxs-color iconR'></i>
									<input id="nombreUsuarios" type="text" name="nombreUsuarios"
                                        value="<?php echo $row['NOMBRE_USUARIO']; ?>" required>
                                </div>

                                <div class="familiaInputs">
									<label for="correoUsuario">Correo Usuario</label>
									<i class='bx bxs-notepad iconR'></i>
									<input id="correoUsuario" type="text" name="correoUsuario" required
                                        value="<?php echo $row['CORREO_USUARIO']; ?>" required>
                                </div>

								<div class="familiaInputs">
									<label for="usuario">Usuario</label>
									<i class='bx bx-cart-add iconR'></i>
									<input id="usuario" type="text" name="usuario" 
										value="<?php echo $row['USUARIO']; ?>" required>
								</div>

                            </div>

                            <div class="input-wrapper">

								<div class="familiaInputs">
									<label for="clave">Clave</label>
									<i class='bx bxs-color iconR'></i>
									<input id="clave" type="text" name="clave" 
										value="<?php echo $row['CLAVE']; ?>" required>
								</div>

								<div class="familiaInputs">
									<label for="rolUsuario">Rol</label>
									<i class='bx bx-cart-add iconR'></i>
									
									<?php 
										$queryRol = mysqli_query($con, "SELECT * FROM rol");
										$resultRol = mysqli_num_rows($queryRol);
									?>
									
									<select id="rolUsuario" name="rolUsuario" required>
										<option value="" disabled selected>Selecciona una opción</option>
										<?php
											if ($resultRol > 0) {
												while ($rol = mysqli_fetch_array($queryRol)) {
													$selected = ($rol['ID_ROL'] == $row['ROL']) ? 'selected' : ''; // Verifica si este rol es el seleccionado previamente
										?>
													<option value="<?php echo $rol['ID_ROL']; ?>" <?php echo $selected; ?>><?php echo $rol['ROL']; ?></option>
										<?php
												}
											}
										?>
									</select>
								</div>

                            </div>

                        <?php
                        } ?>

                        <div class="btnRegistrar">
                            <input type="submit" name="submitUsuario" value="Actualizar">
                        </div>
                </form>
            </div>
    </section>
</body>
</html>