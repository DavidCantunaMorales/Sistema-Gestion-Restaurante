<?php
    session_start();
    include('../dbconnection.php');

    if (isset($_POST['submitCliente'])) {
        $nombre = $_POST['nombresCliente'];
        $cedula = $_POST['cedulaCliente'];
        $tipo = $_POST['tipoCliente'];
        $direccion = $_POST['direccionCliente'];
        $celular = $_POST['numeroCliente'];
        $email = $_POST['correoCliente'];
    
        $queryClientes = mysqli_query($con, "INSERT INTO clientes 
        (CEDULA_CLIENTE, NOMBRE_CLIENTE, TIPO_CLIENTE, DIRECCION_CLIENTE, CELULAR_CLIENTE, CORREO_CLIENTE) 
        VALUES 
        ('$cedula', '$nombre', '$tipo', '$direccion', '$celular', '$email')");
    
        if($queryClientes){
            echo "<script>alert('Cliente registrado exitosamente')</script>";
            echo "<script type='text/javascript'> document.location ='../../vistas/vistaAdministrador/tableClientesAdmin.php'; </script>";
        } else {
            echo "<script>alert('Error al registrar el cliente')</script>";
        }
    }
?>

