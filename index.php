<?php
$alert = '';

session_start();

if (!empty($_SESSION['active'])) {
    header('location: index.php');
} else {
    if (!empty($_POST)) {
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = "El usuario y la contraseña son obligatorios";
        } else {
            require_once "controladorBaseDatos/dbconnection.php";

            $user = mysqli_real_escape_string($con, $_POST['usuario']);
            $pass = (mysqli_real_escape_string($con, $_POST['clave']));

            $query = mysqli_query($con, "SELECT * FROM usuarios WHERE USUARIO = '$user' AND CLAVE = '$pass'");
            $result = mysqli_num_rows($query);

            if ($result > 0) {
                $data = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['id_usuario'] = $data['ID_USUARIO'];
                $_SESSION['nombre'] = $data['NOMBRE_USUARIO'];
                $_SESSION['email'] = $data['CORREO_USUARIO'];
                $_SESSION['user'] = $data['USUARIO'];
                $_SESSION['rol'] = $data['ROL'];

                if ($_SESSION['rol'] == 1) {
                    header('location: vistas/vistaAdministrador/indexAdministrador.php');
                } else if ($_SESSION['rol'] == 2) {
                    header('location: vistas/vistaBodega/indexIngrediente.php');
                } else if ($_SESSION['rol'] == 3) {
                    header('location: vistas/vistaChefRecetas/indexRecetas.php');
                } else if ($_SESSION['rol'] == 4) {
                    header('location: vistas/vistaCoordinadorPedidos/indexPedidos.php');
                } else {
                    header('location: index.php');
                }
                exit(); // Importante: agregar esta línea para evitar que el código siga ejecutándose
            } else {
                $alert = "El usuario o la contraseña son incorrectos";
                session_destroy();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/estiloLogin.css" type="text/css">
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <link rel="icon" href="img/LogoVerde.png">
</head>

<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="" method="post">
                    <h2>Iniciar Sesion</h2>
                    <div class="input-box">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input id="email" name="usuario" type="text" required>
                        <label for="">Usuario</label>
                    </div>
                    <div class="input-box">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input id="password" name="clave" type="password" required>
                        <label for="">Contraseña</label>
                    </div>
                    <div class="alert">
                        <?php echo isset($alert) ? $alert : ''; ?>
                    </div>
                    <input type="submit" value="Iniciar Sesion" id="login-btn">
                </form>
            </div>
        </div>
    </section>

    <!--scripts-->

    <!--script para los iconos-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>