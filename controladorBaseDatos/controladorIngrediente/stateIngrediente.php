<?php
    session_start();
    include('../dbconnection.php');

    if (isset($_GET['desactivarid'])) {
        $rid = intval($_GET['desactivarid']);
        $sql = mysqli_query($con, "UPDATE `ingredientes` SET `ESTADO_INGREDIENTE`= '0' where ID_INGREDIENTE=$rid");
        echo "<script>window.location.href = '../../vistas/vistaBodega/tableIngredientes.php'</script>";
    }
    
    //Code for active user 
    if (isset($_GET['activacionid'])) {
        $rid = intval($_GET['activacionid']);
        $sql = mysqli_query($con, "UPDATE `ingredientes` SET `ESTADO_INGREDIENTE`= '1' where ID_INGREDIENTE=$rid");
        echo "<script>window.location.href = '../../vistas/vistaBodega/tableIngredientes.php'</script>";
    }
?>