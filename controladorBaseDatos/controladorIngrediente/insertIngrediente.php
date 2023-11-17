<?php
    session_start();
    include('../dbconnection.php');

    if (isset($_POST['submitIngrediente'])) {

        $codigo = $_POST['codigoProducto'];
        $descripcion = $_POST['descripcionProducto'];
        $stock = $_POST['stockProducto'];
        $unidades = $_POST['unidadesProducto'];
        $precioUnitario = $_POST['costoUProducto'];
        $precioTotal = $_POST['costoTProducto'];

    
        $queryIngredientes = mysqli_query($con, "INSERT INTO ingredientes 
        (ID_INGREDIENTE, DESCRIPCION_INGREDIENTE, STOCK_INGREDIENTE, UNIDADES_INGREDIENTE, PRECIOU_INGREDIENTE, PRECIOT_INGREDIENTE, DATE_ADD_INGREDIENTE) 
        VALUES ('$codigo', '$descripcion', '$stock', '$unidades', '$precioUnitario', '$precioTotal', NOW())");
     
        if($queryIngredientes){
            echo "<script>alert('Ingrediente registrado exitosamente')</script>";
            echo "<script type='text/javascript'> document.location ='../../vistas/vistaBodega/tableIngredientes.php'; </script>";
        } else {
            echo "<script>alert('Error al registrar el ingrediente')</script>";
        }
    }
?>
