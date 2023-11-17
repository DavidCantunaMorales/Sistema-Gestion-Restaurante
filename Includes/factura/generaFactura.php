<?php

	//print_r($_REQUEST);
	//exit;
	//echo base64_encode('2');
	//exit;
	//session_start();
	//if(empty($_SESSION['active']))
	//{
	//	header('location: ../');
	//}

	include "../../controladorBaseDatos/dbconnection.php";
	require_once '../pdf/vendor/autoload.php';
	use Dompdf\Dompdf;

	if(empty($_REQUEST['usuario']) || empty($_REQUEST['receta']))
	{
		echo "No es posible generar la receta.";
	}else{
		$codUsuario = $_REQUEST['usuario'];
		$noReceta = $_REQUEST['receta'];
		$anulada = '';

		/* Consulta para obtener los datos de la empresa */
		$query_config   = mysqli_query($con,"SELECT * FROM configuracion");
		$result_config  = mysqli_num_rows($query_config);
		if($result_config > 0){
			$configuracion = mysqli_fetch_assoc($query_config);
		}
		

		/*
		$query = mysqli_query($con,"SELECT f.nofactura, DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha, 
														DATE_FORMAT(f.fecha,'%H:%i:%s') as  hora, 
														f.codcliente, f.estatus,
												 		v.nombre as vendedor,
												 		cl.nit, cl.nombre, cl.telefono,cl.direccion
											FROM factura f
											INNER JOIN usuario v
											ON f.usuario = v.idusuario
											INNER JOIN cliente cl
											ON f.codcliente = cl.idcliente
											WHERE f.nofactura = $noReceta AND f.codcliente = $codUsuario  AND f.estatus != 10 ");
		*/
	
		$query = mysqli_query($con,"SELECT f.ID_RECETA, DATE_FORMAT(f.FECHA_RECETA, '%d/%m/%Y') as fecha, 
														DATE_FORMAT(f.FECHA_RECETA,'%H:%i:%s') as  hora, 
														f.ID_USUARIO, f.ESTADO_RECETA,
														v.NOMBRE_USUARIO as vendedor,
														f.NOMBRE_RECETA, f.TIPO_RECETA, f.TIEMPO_PRECETA
											FROM recetas f
											INNER JOIN usuarios v
											ON f.ID_USUARIO = v.ID_USUARIO
											WHERE f.ID_RECETA = $noReceta AND f.ID_USUARIO = $codUsuario  AND f.ESTADO_RECETA != 10 ");

		$result = mysqli_num_rows($query);
		if($result > 0){

			$receta = mysqli_fetch_assoc($query);
			$no_receta = $receta['ID_RECETA'];

			if($receta['ESTADO_RECETA'] == 2){
				$anulada = '<img class="anulada" src="img/anulado.png" alt="Anulada">';
			}

			$query_productos = mysqli_query($con,"SELECT p.DESCRIPCION_INGREDIENTE,
															   dt.CANTIDAD_INGREDIENTE,dt.PRECIO_VENTA,(dt.CANTIDAD_INGREDIENTE * dt.PRECIO_VENTA) as precio_total
														FROM recetas f
														INNER JOIN detalle_receta dt
														ON f.ID_RECETA = dt.ID_RECETA
														INNER JOIN ingredientes p
														ON dt.ID_INGREDIENTE = p.ID_INGREDIENTE
														WHERE f.ID_RECETA = $no_receta ");
			$result_detalle = mysqli_num_rows($query_productos);

			ob_start();
		    include(dirname('__FILE__').'/factura.php');
		    $html = ob_get_clean();

			// instantiate and use the dompdf class
			$dompdf = new Dompdf();

			$dompdf->loadHtml($html);
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('letter', 'portrait');
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream('factura_'.$noReceta.'.pdf',array('Attachment'=>0));
			exit;
		}
	}

?>