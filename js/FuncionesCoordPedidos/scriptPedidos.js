/* ---------------------------------------------------- USANDO JSCRIPT -------------------------------------------- */
function serchForDetalle(usuarioTemp) {

    var action = 'serchForDetallePedido';

    $.ajax({
        url: '../../controladorBaseDatos/ajax.php',
        type: 'POST',
        async: true,
        data: { action: action },

        success: function (response) {
            var infoDetalle = JSON.parse(response);
            console.log(infoDetalle);
            $('#detallePedido').html(infoDetalle.detallePedidoTemp);
            $('#detalle_totalesP').html(infoDetalle.detallePedidoTotales);
        }, error: function (error) {
            console.log(error);
        }

    });
}

function del_detallePedido_temp(ID_DETALLETEMPPE) {
    var action = 'delDetallePedidoTemp';
    var id_detalle = ID_DETALLETEMPPE;

    $.ajax({
        url: "../../controladorBaseDatos/ajax.php",
        type: "POST",
        async: true,
        data: { action: action, id_detalle: id_detalle },

        success: function (response) {
            if (response != 'error') {
                var infoDetalle = JSON.parse(response);
                $('#detallePedido').html(infoDetalle.detallePedidoTemp);
                $('#detalle_totalesP').html(infoDetalle.detallePedidoTotales);

                // Limpiar campos
                $('#txt_cod_receta').html('');
                $('#txt_descripcion_receta').val('');
                $('#txt_cant_receta').val('0');
                $('#txt_precio_receta').html('0.00');
                $('#txt_precio_total_receta').html('0.00');

                // Desactivar cantidad
                $('#txt_cant_receta').attr('disabled', 'disabled');

                // Ocultar botón agregar
                $('#add_receta_pedido').slideUp();

            } else {
                $('#detallePedido').html('');
                $('#detalle_totalesP').html('');
            }

        }, error: function (error) {
            console.log(error);
        }
    });
}

function generarPDFPedido(cliente, pedido) {
    var ancho = 1000;
    var alto = 800;

    // Calcular la posicion x, y para centrar la ventada
    var x = parseInt((window.screen.width / 2) - (ancho / 2));
    var y = parseInt((window.screen.height / 2) - (alto / 2));

    $url = '../../IncluesPedido/generaFactura.php?cliente=' + cliente + '&pedido=' + pedido;
    window.open($url, 'Factura', 'width=' + ancho + ',height=' + alto + ',left=' + x + ',top=' + y + ', scrollbars=si, location=no, menubar=no, resizable=si');
}

/* --------------------------------------------------- USANDO JQUERY ------------------------------------------- */

$(document).ready(function () {

    // Buscar la receta para añadir al pedido
    $('#txt_descripcion_receta').keyup(function (e) {
        e.preventDefault();

        var nombreReceta = $(this).val();
        var action = 'infoReceta';

        if (nombreReceta != '') {
            $.ajax({
                url: '../../controladorBaseDatos/ajax.php',
                type: 'POST',
                async: true,
                data: { action: action, nombreReceta: nombreReceta },
                success: function (response) {
                    if (response != '0') {
                        var info = JSON.parse(response);
                        $('#txt_cod_receta').html(info.ID_RECETA);
                        $('#txt_cant_receta').val(1);
                        $('#txt_precio_receta').html(info.COSTO_RECETA);
                        $('#txt_precio_total_receta').html(info.COSTO_RECETA);

                        // Activar cantidad
                        $('#txt_cant_receta').removeAttr('disabled');

                        // Mostrar botón agregar
                        $('#add_receta_pedido').slideDown();
                    } else {
                        $('#txt_cod_receta').html('');
                        $('#txt_cant_receta').val('0');
                        $('#txt_precio_receta').html('0.00');
                        $('#txt_precio_total_receta').html('0.00');

                        // Desactivar cantidad
                        $('#txt_cant_receta').attr('disabled', 'disabled');

                        // Ocultar botón agregar
                        $('#add_receta_pedido').slideUp();

                    }
                }, error: function (error) {
                    console.log(error);
                }
            });
        }
    });

    // Validaciones de cantidad para la receta a añadir al pedido
    $('#txt_cant_receta').keyup(function (e) {
        e.preventDefault();
        var precio_total = $(this).val() * parseFloat($('#txt_precio_receta').html()); // Utiliza parseFloat para obtener el precio como número decimal
        var existencia = parseInt($('#txt_cant_receta').attr('max')); // Obtiene el valor máximo permitido del atributo 'max' del input

        $('#txt_precio_total_receta').html(precio_total.toFixed(2)); // Asegura que el precio total tenga dos decimales

        // Ocultar el botón de agregar si la cantidad es menor que 1, mayor que la existencia o no es un número
        if (($(this).val() < 1 || isNaN($(this).val())) || ($(this).val() > existencia)) {
            $('#add_receta_pedido').slideUp();
        } else {
            $('#add_receta_pedido').slideDown();
        }
    });

    // Agregar la receta al pedido
    $('#add_receta_pedido').click(function (e) {
        e.preventDefault();
        if ($('#txt_cant_receta').val() > 0) {
            var idReceta = parseInt($('#txt_cod_receta').text());
            var cantidad = $('#txt_cant_receta').val();
            var action = 'addRecetaPedidos';

            $.ajax({
                url: '../../controladorBaseDatos/ajax.php',
                type: 'POST',
                async: true,
                data: { action: action, receta: idReceta, cantidad: cantidad },
                success: function (response) {
                    if (response != 'error') {
                        var infoPedido = JSON.parse(response);
                        $('#detallePedido').html(infoPedido.detallePedidoTemp);
                        $('#detalle_totalesP').html(infoPedido.detallePedidoTotales);

                        // Limpiar campos
                        $('#txt_cod_receta').html('');
                        $('#txt_descripcion_receta').val('');
                        $('#txt_cant_receta').val('0');
                        $('#txt_precio_receta').html('0.00');
                        $('#txt_precio_total_receta').html('0.00');

                        // Desactivar cantidad
                        $('#txt_cant_receta').attr('disabled', 'disabled');

                        // Ocultar botón agregar
                        $('#add_receta_pedido').slideUp();
                    }
                }, error: function (error) {
                    console.log(error);
                }
            });
        }

    });

    // Generar Pedido
    $('#btnRegistrarPedido').click(function (e) {
        e.preventDefault();
        var rows = $('#detallePedido tr').length;
        if (rows > 0) {
            var action = 'procesarPedido';

            // Obtener los datos del formulario
            var cedulaCliente = $('#cedulaCliente').val();

            $.ajax({
                url: '../../controladorBaseDatos/ajax.php',
                type: 'POST',
                async: true,
                data: {
                    action: action,
                    cedulaCliente: cedulaCliente
                },

                success: function (response) {
                    if (response != 'error') {

                        var info = JSON.parse(response);
                        //console.log(info);
                        generarPDFPedido(info.CEDULA_CLIENTE, info.ID_PEDIDO);
                        location.reload();
                    } else {
                        console.log('No Data');
                    }

                }, error: function (error) {
                    console.log(error);
                }
            });
        }
    });

    // Ver Pedido
    $('.view_pedido').click(function (e) {
        e.preventDefault();
        var codCliente = $(this).attr('cliente');
        var codPedido = $(this).attr('pedido');
        generarPDFPedido(codCliente, codPedido);
        console.log(codUsuario);
    });

    // Buscar cliente 
    $('#cedulaCliente').keyup(function (e) {
        e.preventDefault();
        var cl = $(this).val();
        var action = 'searchCliente';

        $.ajax({
            url: '../../controladorBaseDatos/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, cliente: cl },
            success: function (response) {
                console.log(response);
                if (response == 0) {
                    $('cedulaCliente').val('');
                    $('#nombresCliente').val('');
                    $('#tipoCliente').val('');
                    $('#direccionCliente').val('');
                    $('#numeroCliente').val('');
                    $('#correoCliente').val('');
                } else {
                    var data = $.parseJSON(response);
                    console.log(data);
                    $('cedulaCliente').val(data.CEDULA_CLIENTE);
                    $('#nombresCliente').val(data.NOMBRE_CLIENTE);
                    $('#tipoCliente').val(data.TIPO_CLIENTE);
                    $('#direccionCliente').val(data.DIRECCION_CLIENTE);
                    $('#numeroCliente').val(data.CELULAR_CLIENTE);
                    $('#correoCliente').val(data.DIRECCION_CLIENTE);
                }
            }, error: function (error) {
                console.log(error);
            }
        });
    });



});