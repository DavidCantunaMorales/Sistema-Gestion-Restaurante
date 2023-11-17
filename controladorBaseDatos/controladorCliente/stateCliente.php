<?php
    session_start();
    include('../dbconnection.php');

    if (isset($_GET['desactivarid'])) {
        $rid = intval($_GET['desactivarid']);
        $sql = mysqli_query($con, "UPDATE `clientes` SET `ESTADO_CLIENTE`= '0' where CEDULA_CLIENTE=$rid");
        echo "<script>window.location.href = '../../vistas/vistaAdministrador/tableClientesAdmin.php'</script>";
    }
    
    //Code for active user 
    if (isset($_GET['activacionid'])) {
        $rid = intval($_GET['activacionid']);
        $sql = mysqli_query($con, "UPDATE `clientes` SET `ESTADO_CLIENTE`= '1' where CEDULA_CLIENTE=$rid");
        echo "<script>window.location.href = '../../vistas/vistaAdministrador/tableClientesAdmin.php'</script>";
    }
?>