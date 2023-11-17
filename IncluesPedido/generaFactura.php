<?php

	include "../controladorBaseDatos/dbconnection.php";
	require_once '../Includes/pdf/vendor/autoload.php';
	use Dompdf\Dompdf;

	if(empty($_REQUEST['cliente']) || empty($_REQUEST['pedido']))
	{
		echo "No es posible generar la factura.";
	}else{

		$codCliente = $_REQUEST['cliente'];
		$noFactura = $_REQUEST['pedido'];
		$anulada = '';


		$query = mysqli_query($con,"SELECT f.ID_PEDIDO, DATE_FORMAT(f.FECHA_PEDIDO, '%d/%m/%Y') as fecha, 
												DATE_FORMAT(f.FECHA_PEDIDO,'%H:%i:%s') as  hora, 
												f.CEDULA_CLIENTE, f.ESTADO_PEDIDO,
												cl.CEDULA_CLIENTE, cl.NOMBRE_CLIENTE, cl.CELULAR_CLIENTE,cl.CORREO_CLIENTE, cl.DIRECCION_CLIENTE
											FROM pedido f
											INNER JOIN clientes cl
											ON f.CEDULA_CLIENTE = cl.CEDULA_CLIENTE
											WHERE f.ID_PEDIDO = $noFactura AND f.CEDULA_CLIENTE = $codCliente  AND f.ESTADO_PEDIDO != 10 ");

		$result = mysqli_num_rows($query);
		echo $result;
		
		if($result > 0){

		
			$factura = mysqli_fetch_assoc($query);
			$no_factura = $factura['ID_PEDIDO'];

			
			if($factura['ESTADO_PEDIDO'] == 2){
				$anulada = '<img class="anulada" src="img/anulado.png" alt="Anulada">';
			}


			$query_productos = mysqli_query($con,"SELECT p.NOMBRE_RECETA,dt.CANTIDAD_RECETA,dt.PRECIO_VENTAPE,(dt.CANTIDAD_RECETA * dt.PRECIO_VENTAPE) as precio_total
														FROM pedido f
														INNER JOIN detalle_pedido dt
														ON f.ID_PEDIDO = dt.ID_PEDIDO
														INNER JOIN recetas p
														ON dt.ID_RECETA = p.ID_RECETA
														WHERE f.ID_PEDIDO = $no_factura ");
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
			$dompdf->stream('factura_'.$noFactura.'.pdf',array('Attachment'=>0));

			exit;
		}
	}

?>