<?php

include('dbconnection.php');


/* --------------------------------- RECETA ----------------------------------- */

// Mostrar el nombre del Ingrediente para aumentar cantidad
if (!empty($_POST)) {
    if ($_POST['action'] == 'infoProducto') {
        $producto_id = $_POST['producto'];
        $query = mysqli_query($con, "SELECT ID_INGREDIENTE, DESCRIPCION_INGREDIENTE FROM ingredientes 
                                        WHERE ID_INGREDIENTE = $producto_id AND ESTADO_INGREDIENTE = 1");
        mysqli_close($con);

        $result = mysqli_num_rows($query);
        if ($result > 0) {
            $data = mysqli_fetch_assoc($query);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
        }
        echo 'error';
        exit;
    }

        // Agregar productos a entrada
    if ($_POST['action'] == 'addProduct') {
        if (!empty($_POST['cantidad']) || !empty($_POST['producto_id']) || !empty($_POST['precio'])) {
            //print_r($_POST);
            $precio = $_POST['precio'];
            $cantidad = $_POST['cantidad'];
            $producto_id = $_POST['producto_id'];
            $query_insert = mysqli_query($con, "INSERT INTO entrada(ID_INGREDIENTE, CANTIDAD, PRECIO)
                                                    VALUES($producto_id, $cantidad, $precio)");
            if ($query_insert) {
                $query_upd = mysqli_query($con, "CALL actualizar_precio_ingrediente($producto_id, $cantidad, $precio)");
                $result_pro = mysqli_num_rows($query_upd);
                if ($result_pro > 0) {
                    $data = mysqli_fetch_assoc($query_upd);
                    $data['producto_id'] = $producto_id;
                    echo json_encode($data, JSON_UNESCAPED_UNICODE);
                    exit;
                }
            } else {
                echo "error";
            }
            mysqli_close($con);
        } else {
            echo "error";
        }
        exit;
    }
}

// Agragar los ingredientes al detalle
if (!empty($_POST)) {
    if ($_POST['action'] == 'infoIngrediente') {
        $ingrediente_id = $_POST['ingrediente'];
        $query = mysqli_query($con, "SELECT ID_INGREDIENTE, DESCRIPCION_INGREDIENTE, STOCK_INGREDIENTE, PRECIOU_INGREDIENTE FROM ingredientes 
                                        WHERE ID_INGREDIENTE = $ingrediente_id AND ESTADO_INGREDIENTE = 1 AND STOCK_INGREDIENTE > 0");
        mysqli_close($con);

        $result = mysqli_num_rows($query);

        if ($result > 0) {
            $data = mysqli_fetch_assoc($query);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
        }
        echo 'error';
        exit;
    }
}

// Agregar a la tabla de detalles temporal
if ($_POST['action'] == 'addIngredienteReceta') {

    if (empty($_POST['producto']) || empty($_POST['cantidad'])) {
        echo 'error';
    } else {
        $codigo_ingrediente = $_POST['producto'];
        $cantidad_ingrediente = $_POST['cantidad'];

        $queryDetalleRecetaTemp = mysqli_query($con, "CALL add_detalleReceta_temp($codigo_ingrediente, $cantidad_ingrediente)");
        $result = mysqli_num_rows($queryDetalleRecetaTemp);

        $detalleRecetaTemp = '';
        $detalleRecetaTotales = '';
        $sub_total = 0;
        $iva = 0;
        $total = 0;
        $arrayData = array();

        if ($result > 0) {
            while ($data = mysqli_fetch_assoc($queryDetalleRecetaTemp)) {
                $precioTotal = round($data['CANTIDAD_INGREDIENTE'] * $data['PRECIO_VENTA'], 2);
                $sub_total = round($sub_total + $precioTotal, 2);
                $total = round($total + $precioTotal, 2);

                // Aqui es donde ponemos en una tabla los datos
                $detalleRecetaTemp .= '
                                        <tr>
                                            <td>' . $data['ID_INGREDIENTE'] . '</td>
                                            <td>' . $data['DESCRIPCION_INGREDIENTE'] . '</td>
                                            <td>' . $data['CANTIDAD_INGREDIENTE'] . '</td>
                                            <td>' . $data['PRECIO_VENTA'] . '</td>
                                            <td>' . $precioTotal . '</td>
                                            <td>
                                                <a class="link_delete" href="#" onclick="event.preventDefault(); del_detalleReceta_temp(' . $data['ID_DETALLETEMPR'] . ');">
                                                    <i class="fas fa-trash-alt" style="color: green";></i>
                                                </a>
                                            </td>
                                        </tr>';
            }

            $impuesto = round($sub_total * 0.12, 2);
            $tl_sniva = round($sub_total - $impuesto, 2);
            $total = round($tl_sniva + $impuesto, 2);

            $detalleRecetaTotales = '
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Sub Total</td>
                                                <td id="subTotal">' . $tl_sniva . '</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Iva(12%)</td>
                                                <td id="iva">' . $impuesto . '</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Total</td>
                                                <td id="total">' . $total . '</td>
                                            </tr>
                                        ';
            $arrayData['detalleRecetaTemp'] = $detalleRecetaTemp;
            $arrayData['detalleRecetaTotales'] = $detalleRecetaTotales;
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
        } else {
            echo 'error';
        }
        mysqli_close($con);
    }
    
    exit;
}

// Manter la pantalla, extraer datos del detalle temporal
if ($_POST['action'] == 'serchForDetalle') {

    if (!(empty($_POST['user']))) {
        echo 'error';
    } else {

        $obtenerDatosReceta = mysqli_query($con, "SELECT tmp.ID_DETALLETEMPR,
                                                             tmp.CANTIDAD_INGREDIENTE,
                                                             tmp.PRECIO_VENTA,
                                                             p.ID_INGREDIENTE,
                                                             p.DESCRIPCION_INGREDIENTE
                                                      FROM detalle_tempr tmp
                                                      INNER JOIN ingredientes p
                                                      ON tmp.ID_INGREDIENTE = p.ID_INGREDIENTE");
        $result = mysqli_num_rows($obtenerDatosReceta);

        $detalleRecetaTemp = '';
        $detalleRecetaTotales = '';
        $sub_total = 0;
        $iva = 0;
        $total = 0;
        $arrayData = array();

        if ($result > 0) {
            while ($data = mysqli_fetch_assoc($obtenerDatosReceta)) {
                $precioTotal = round($data['CANTIDAD_INGREDIENTE'] * $data['PRECIO_VENTA'], 2);
                $sub_total = round($sub_total + $precioTotal, 2);
                $total = round($total + $precioTotal, 2);

                // Aqui es donde ponemos en una tabla los datos
                $detalleRecetaTemp .= '
                                        <tr>
                                            <td>' . $data['ID_INGREDIENTE'] . '</td>
                                            <td>' . $data['DESCRIPCION_INGREDIENTE'] . '</td>
                                            <td>' . $data['CANTIDAD_INGREDIENTE'] . '</td>
                                            <td>' . $data['PRECIO_VENTA'] . '</td>
                                            <td>' . $precioTotal . '</td>
                                            <td>
                                                <a class="link_delete" href="#" onclick="event.preventDefault(); del_detalleReceta_temp(' . $data['ID_DETALLETEMPR'] . ');">
                                                    <i class="fas fa-trash-alt" style="color: green";></i>
                                                </a>
                                            </td>
                                        </tr>';
            }

            $impuesto = round($sub_total * 0.12, 2);
            $tl_sniva = round($sub_total - $impuesto, 2);
            $total = round($tl_sniva + $impuesto, 2);

            $detalleRecetaTotales = '
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Sub Total</td>
                                                <td id="subTotal">' . $tl_sniva . '</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Iva(12%)</td>
                                                <td id="iva">' . $impuesto . '</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Total</td>
                                                <td id="total">' . $total . '</td>
                                            </tr>
                                        ';
            $arrayData['detalleRecetaTemp'] = $detalleRecetaTemp;
            $arrayData['detalleRecetaTotales'] = $detalleRecetaTotales;
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
        } else {
            echo 'error';
        }
        mysqli_close($con);
    }
    exit;
}

// Eliminar detalle temporal
if ($_POST['action'] == 'delDetalleRecetaTemp') {

    if (empty($_POST['id_detalle'])) {
        echo 'error';
    } else {
        $id_detalle = $_POST['id_detalle'];

        $queryEliminarDetalleRecetaTemp = mysqli_query($con, "CALL del_detalleReceta_temp($id_detalle)");
        $result = mysqli_num_rows($queryEliminarDetalleRecetaTemp);

        $detalleRecetaTemp = '';
        $detalleRecetaTotales = '';
        $sub_total = 0;
        $iva = 0;
        $total = 0;
        $arrayData = array();

        if ($result > 0) {
            while ($data = mysqli_fetch_assoc($queryEliminarDetalleRecetaTemp)) {
                $precioTotal = round($data['CANTIDAD_INGREDIENTE'] * $data['PRECIO_VENTA'], 2);
                $sub_total = round($sub_total + $precioTotal, 2);
                $total = round($total + $precioTotal, 2);

                // Aqui es donde ponemos en una tabla los datos
                $detalleRecetaTemp .= '
                                        <tr>
                                            <td>' . $data['ID_INGREDIENTE'] . '</td>
                                            <td>' . $data['DESCRIPCION_INGREDIENTE'] . '</td>
                                            <td>' . $data['CANTIDAD_INGREDIENTE'] . '</td>
                                            <td>' . $data['PRECIO_VENTA'] . '</td>
                                            <td>' . $precioTotal . '</td>
                                            <td>
                                                <a class="link_delete" href="#" onclick="event.preventDefault(); del_detalleReceta_temp(' . $data['ID_DETALLETEMPR'] . ');">
                                                    <i class="fas fa-trash-alt" style="color: green";></i>
                                                </a>
                                            </td>
                                        </tr>';
            }

            $impuesto = round($sub_total * 0.12, 2);
            $tl_sniva = round($sub_total - $impuesto, 2);
            $total = round($tl_sniva + $impuesto, 2);

            $detalleRecetaTotales = '
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Sub Total</td>
                                                <td id="subTotal">' . $tl_sniva . '</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Iva(12%)</td>
                                                <td id="iva">' . $impuesto . '</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Total</td>
                                                <td id="total">' . $total . '</td>
                                            </tr>
                                        ';
            $arrayData['detalleRecetaTemp'] = $detalleRecetaTemp;
            $arrayData['detalleRecetaTotales'] = $detalleRecetaTotales;
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
        } else {
            echo 'error';
        }
        mysqli_close($con);
    }
    exit;
}

// Aqui me falta la parte de anular venta 

// Registrar Receta 
if ($_POST['action'] == 'procesarReceta') {

    $usuario = 1;
    $nombreReceta = $_POST['nombreReceta'];
    $tipoReceta = $_POST['tipoReceta'];
    $tiempoPreparacion = $_POST['tiempoPreparacion'];

    $query_procesar = mysqli_query($con, "SELECT * FROM detalle_tempr");
    $result = mysqli_num_rows($query_procesar);

    if ($result > 0) {
        $query_procesarReceta = mysqli_query($con, "CALL procesar_receta($usuario, '$nombreReceta', '$tipoReceta', '$tiempoPreparacion')");
        $result_detalle = mysqli_num_rows($query_procesarReceta);

        if ($result_detalle > 0) {
            $data = mysqli_fetch_assoc($query_procesarReceta);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }

    mysqli_close($con);
    exit;
}


/* --------------------------------- PEDIDOS ----------------------------------- */

// Agragar las recetas al detalle
if (!empty($_POST)) {
    if ($_POST['action'] == 'infoReceta') {
        $receta_id = $_POST['nombreReceta'];
        $query = mysqli_query($con, "SELECT ID_RECETA, NOMBRE_RECETA, COSTO_RECETA FROM recetas 
                                        WHERE NOMBRE_RECETA LIKE '$receta_id' AND ESTADO_RECETA = 1");
        mysqli_close($con);

        $result = mysqli_num_rows($query);

        $data = '';

        if ($result > 0) {
            $data = mysqli_fetch_assoc($query);
        } else {
            $data = 0;
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}

// Agregar a las recetas de detalles temporalS
if ($_POST['action'] == 'addRecetaPedidos') {
    if (!empty($_POST['cantidad']) || !empty($_POST['receta'])) {

        $cantidad_receta = $_POST['cantidad'];
        $codigo_receta = $_POST['receta'];

        $queryDetallePedidoTemp = mysqli_query($con, "CALL add_detallePedido_temp($codigo_receta, $cantidad_receta)");
        $result = mysqli_num_rows($queryDetallePedidoTemp);
        
        $detallePedidoTemp = '';
        $detallePedidoTotales = '';
        $sub_total = 0;
        $iva = 0;
        $total = 0;
        $arrayData = array();
        if ($result > 0) {
            while ($data = mysqli_fetch_assoc($queryDetallePedidoTemp)) {
                $precioTotal = round($data['CANTIDAD_RECETA'] * $data['PRECIO_VENTAPE'], 2);
                $sub_total = round($sub_total + $precioTotal, 2);
                $total = round($total + $precioTotal, 2);
                // Aqui es donde ponemos en una tabla los datos
                $detallePedidoTemp .= '
                                        <tr>
                                            <td>' . $data['ID_RECETA'] . '</td>
                                            <td>' . $data['NOMBRE_RECETA'] . '</td>
                                            <td>' . $data['CANTIDAD_RECETA'] . '</td>
                                            <td>' . $data['PRECIO_VENTAPE'] . '</td>
                                            <td>' . $precioTotal . '</td>
                                            <td>
                                                <a class="link_delete" href="#" onclick="event.preventDefault(); del_detallePedido_temp('. $data['ID_DETALLETEMPPE'] . ');">
                                                    <i class="fas fa-trash-alt" style="color: green";></i>
                                                </a>
                                            </td>
                                        </tr>';
            }
            $impuesto = round($sub_total * 0.12, 2);
            $tl_sniva = round($sub_total - $impuesto, 2);
            $total = round($tl_sniva + $impuesto, 2);
            $detallePedidoTotales = '
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Sub Total</td>
                                                <td id="subTotal">' . $tl_sniva . '</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Iva(12%)</td>
                                                <td id="iva">' . $impuesto . '</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Total</td>
                                                <td id="total">' . $total . '</td>
                                            </tr>
                                        ';
            $arrayData['detallePedidoTemp'] = $detallePedidoTemp;
            $arrayData['detallePedidoTotales'] = $detallePedidoTotales;
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
        }
    }
    exit;
}

// Manter la pantalla, extraer datos del detalle temporal
if ($_POST['action'] == 'serchForDetallePedido') {

    if (!(empty($_POST['user']))) {
        echo 'error';
    } else {

        $obtenerDatosPedido = mysqli_query($con, "SELECT tmp.ID_DETALLETEMPPE,
                                                             tmp.CANTIDAD_RECETA,
                                                             tmp.PRECIO_VENTAPE,
                                                             p.ID_RECETA,
                                                             p.NOMBRE_RECETA
                                                      FROM detalle_temppe tmp
                                                      INNER JOIN recetas p
                                                      ON tmp.ID_RECETA = p.ID_RECETA");
        $result = mysqli_num_rows($obtenerDatosPedido);

        $detallePedidoTemp = '';
        $detallePedidoTotales = '';
        $sub_total = 0;
        $iva = 0;
        $total = 0;
        $arrayData = array();

        if ($result > 0) {
            while ($data = mysqli_fetch_assoc($obtenerDatosPedido)) {
                $precioTotal = round($data['CANTIDAD_RECETA'] * $data['PRECIO_VENTAPE'], 2);
                $sub_total = round($sub_total + $precioTotal, 2);
                $total = round($total + $precioTotal, 2);

                // Aqui es donde ponemos en una tabla los datos
                $detallePedidoTemp .= '
                                        <tr>
                                            <td>' . $data['ID_RECETA'] . '</td>
                                            <td>' . $data['NOMBRE_RECETA'] . '</td>
                                            <td>' . $data['CANTIDAD_RECETA'] . '</td>
                                            <td>' . $data['PRECIO_VENTAPE'] . '</td>
                                            <td>' . $precioTotal . '</td>
                                            <td>
                                                <a class="link_delete" href="#" onclick="event.preventDefault(); del_detallePedido_temp(' . $data['ID_DETALLETEMPPE'] . ');">
                                                    <i class="fas fa-trash-alt" style="color: green";></i>
                                                </a>
                                            </td>
                                        </tr>';
            }

            $impuesto = round($sub_total * 0.12, 2);
            $tl_sniva = round($sub_total - $impuesto, 2);
            $total = round($tl_sniva + $impuesto, 2);

            $detallePedidoTotales = '
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Sub Total</td>
                                                <td id="subTotal">' . $tl_sniva . '</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Iva(12%)</td>
                                                <td id="iva">' . $impuesto . '</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Total</td>
                                                <td id="total">' . $total . '</td>
                                            </tr>
                                        ';
            $arrayData['detallePedidoTemp'] = $detallePedidoTemp;
            $arrayData['detallePedidoTotales'] = $detallePedidoTotales;
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
        } else {
            echo 'error';
        }
        mysqli_close($con);
    }
    exit;
}

// Eliminar detalle temporal
if ($_POST['action'] == 'delDetallePedidoTemp') {
    if (empty($_POST['id_detalle'])) {
        echo 'error';
    } else {
        $id_detalle = $_POST['id_detalle'];

        $queryEliminarDetallePedidoTemp = mysqli_query($con, "CALL del_detallePedido_temp($id_detalle)");
        $result = mysqli_num_rows($queryEliminarDetallePedidoTemp);

        $detallePedidoTemp = '';
        $detallePedidoTotales = '';
        $sub_total = 0;
        $iva = 0;
        $total = 0;

        $arrayData = array();
        if ($result > 0) {
            while ($data = mysqli_fetch_assoc($queryEliminarDetallePedidoTemp)) {
                $precioTotal = round($data['CANTIDAD_RECETA'] * $data['PRECIO_VENTAPE'], 2);
                $sub_total = round($sub_total + $precioTotal, 2);
                $total = round($total + $precioTotal, 2);
                // Aqui es donde ponemos en una tabla los datos
                $detallePedidoTemp .= '
                                        <tr>
                                            <td>' . $data['ID_RECETA'] . '</td>
                                            <td>' . $data['NOMBRE_RECETA'] . '</td>
                                            <td>' . $data['CANTIDAD_RECETA'] . '</td>
                                            <td>' . $data['PRECIO_VENTAPE'] . '</td>
                                            <td>' . $precioTotal . '</td>
                                            <td>
                                                <a class="link_delete" href="#" onclick="event.preventDefault(); del_detallePedido_temp(' . $data['ID_DETALLETEMPPE'] . ');">
                                                    <i class="fas fa-trash-alt" style="color: green";></i>
                                                </a>
                                            </td>
                                        </tr>';
            }
            $impuesto = round($sub_total * 0.12, 2);
            $tl_sniva = round($sub_total - $impuesto, 2);
            $total = round($tl_sniva + $impuesto, 2);
            $detallePedidoTotales = '
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Sub Total</td>
                                                <td id="subTotal">' . $tl_sniva . '</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Iva(12%)</td>
                                                <td id="iva">' . $impuesto . '</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Total</td>
                                                <td id="total">' . $total . '</td>
                                            </tr>
                                        ';
            $arrayData['detallePedidoTemp'] = $detallePedidoTemp;
            $arrayData['detallePedidoTotales'] = $detallePedidoTotales;
            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
        } else {
            echo 'error';
        }
        mysqli_close($con);
    }
    exit;
}

// Registrar Pedido 
if ($_POST['action'] == 'procesarPedido') {

    $usuario = 1;
    $cedulaCliente = $_POST['cedulaCliente'];

    $query_procesar = mysqli_query($con, "SELECT * FROM detalle_temppe");
    $result = mysqli_num_rows($query_procesar);

    if ($result > 0) {
        $query_procesarPedido = mysqli_query($con, "CALL procesar_pedido($cedulaCliente)");
        $result_detalle = mysqli_num_rows($query_procesarPedido);

        if ($result_detalle > 0) {
            $data = mysqli_fetch_assoc($query_procesarPedido);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }

    mysqli_close($con);
    exit;
}

// Buscar cliente 
if($_POST['action'] == 'searchCliente') {
    if (!empty($_POST['cliente'])) {
        $cedula = $_POST['cliente'];
        $query = mysqli_query($con, "SELECT * FROM clientes WHERE CEDULA_CLIENTE LIKE '$cedula' AND ESTADO_CLIENTE = 1");
        mysqli_close($con);
        $result = mysqli_num_rows($query);
        $data = '';
        if ($result > 0) {
            $data = mysqli_fetch_assoc($query);
        } else {
            $data = 0;
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    exit;
}


?>
