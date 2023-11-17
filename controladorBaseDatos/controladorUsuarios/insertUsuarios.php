<?php
session_start();
    include('../dbconnection.php');

    if (isset($_POST['submitUsuario'])) {
        $nombreUsuario = $_POST['nombreUsuarios'];
        $correoUsuario = $_POST['correoUsuario'];
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];
        $rol = $_POST['rolUsuario'];

        /* Verificar que no existan usuarios con el mismo usuario o correo */
        $queryExistencia = mysqli_query($con, "SELECT * FROM usuarios WHERE USUARIO = '$usuario' OR CORREO_USUARIO = '$correoUsuario'");
        $resultExistencia = mysqli_fetch_array($queryExistencia);
        

        if ($resultExistencia > 0) {
            echo "<script>alert('El usuario o correo ya existe')</script>";
            echo "<script type='text/javascript'> document.location ='../../vistas/vistaAdministrador/registerUsuariosAdmin.php'; </script>";
        } else {
            $queryClientes = mysqli_query($con, "INSERT INTO usuarios 
            (NOMBRE_USUARIO, CORREO_USUARIO, USUARIO, CLAVE, ROL) 
            VALUES 
            ('$nombreUsuario', '$correoUsuario', '$usuario', '$clave', '$rol')");
            if ($queryClientes) {
                echo "<script>alert('Usuario registrado exitosamente')</script>";
                echo "<script type='text/javascript'> document.location ='../../vistas/vistaAdministrador/tableUsuariosAdmin.php'; </script>";
            } else {
                echo "<script>alert('Error al registrar el usuario')</script>";
            }
        }
    }
?>
