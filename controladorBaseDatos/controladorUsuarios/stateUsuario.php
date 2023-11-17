<?php

    include('../dbconnection.php');
    session_start();
    
    if (isset($_GET['desactivarid'])) {
        $rid = intval($_GET['desactivarid']);
        $sql = mysqli_query($con, "UPDATE `usuarios` SET `ESTADO_USUARIO`= '0' where ID_USUARIO=$rid");
        echo "<script>window.location.href = '../../vistas/vistaAdministrador/tableUsuariosAdmin.php'</script>";
    }
    
    //Code for active user 
    if (isset($_GET['activacionid'])) {
        $rid = intval($_GET['activacionid']);
        $sql = mysqli_query($con, "UPDATE `usuarios` SET `ESTADO_USUARIO`= '1' where ID_USUARIO=$rid");
        echo "<script>window.location.href = '../../vistas/vistaAdministrador/tableUsuariosAdmin.php'</script>";
    }
?>