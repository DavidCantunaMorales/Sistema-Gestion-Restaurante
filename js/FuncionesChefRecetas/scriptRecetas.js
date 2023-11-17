
/* --------------------------------------------------- USANDO JSCRIPT ------------------------------------------- */

function serchForDetalle(usuarioTemp) {

    var action = 'serchForDetalle';
    //var user = id;

    $.ajax({
        url: '../../controladorBaseDatos/ajax.php',
        type: 'POST',
        async: true,
        data: { action: action },

        success: function (response) {
            var infoDetalle = JSON.parse(response);
            console.log(infoDetalle);
            $('#detalleReceta').html(infoDetalle.detalleRecetaTemp);
            $('#detalle_totalesR').html(infoDetalle.detalleRecetaTotales);
        }, error: function (error) {
            console.log(error);
        }

    });
}


function del_detalleReceta_temp(ID_DETALLETEMPR) {
    var action = 'delDetalleRecetaTemp';
    var id_detalle = ID_DETALLETEMPR;

    $.ajax({
        url: "../../controladorBaseDatos/ajax.php",
        type: "POST",
        async: true,
        data: { action: action, id_detalle: id_detalle },

        success: function (response) {
            if (response != 'error') {
                var infoDetalle = JSON.parse(response);
                $('#detalleReceta').html(infoDetalle.detalleRecetaTemp);
                $('#detalle_totalesR').html(infoDetalle.detalleRecetaTotales);

                // Limpiar campos
                $('#txt_cod_ingrediente').val('');
                $('#txt_descripcion').html('');
                $('#txt_existencia').html('');
                $('#txt_cant_ingrediente').val('0');
                $('#txt_precio').html('0.00');
                $('#txt_precio_total').html('0.00');

                // Desactivar cantidad
                $('#txt_cant_ingrediente').attr('disabled', 'disabled');

                // Ocultar botón agregar
                $('#add_ingrediente_receta').slideUp();

            } else {
                $('#detalleReceta').html('');
                $('#detalle_totalesR').html('');
            }
        }, error: function (error) {
            console.log(error);
        }
    });
}

function generarPDF (usuario, receta) {
    var ancho = 1000;
    var alto = 800;

    // Calcular la posicion x, y para centrar la ventada
    var x = parseInt((window.screen.width / 2) - (ancho / 2));
    var y = parseInt((window.screen.height / 2) - (alto / 2));

    $url = '../../Includes/factura/generaFactura.php?usuario='+usuario+'&receta='+receta;
    window.open($url, 'Factura', 'width=' + ancho + ',height=' + alto + ',left=' + x + ',top=' + y + ', scrollbars=si, location=no, menubar=no, resizable=si');
}


/* --------------------------------------------------- USANDO JQUERY ------------------------------------------- */

$(document).ready(function () {

    /* Buscar producto */
    $('#txt_cod_ingrediente').keyup(function (e) {
        e.preventDefault();

        var ingrediente = $(this).val();
        var action = 'infoIngrediente';

        if (ingrediente != '') {
            $.ajax({
                url: '../../controladorBaseDatos/ajax.php',
                type: 'POST',
                async: true,
                data: { action: action, ingrediente: ingrediente },
                success: function (response) {
                    if (response != 'error') {
                        var info = JSON.parse(response);
                        $('#txt_descripcion').html(info.DESCRIPCION_INGREDIENTE);
                        $('#txt_existencia').html(info.STOCK_INGREDIENTE);
                        $('#txt_cant_ingrediente').val(1);
                        $('#txt_precio').html(info.PRECIOU_INGREDIENTE);
                        $('#txt_precio_total').html(info.PRECIOU_INGREDIENTE);

                        // Activar cantidad
                        $('#txt_cant_ingrediente').removeAttr('disabled');

                        // Mostrar botón agregar
                        $('#add_ingrediente_receta').slideDown();
                    } else {
                        $('#txt_descripcion').html('');
                        $('#txt_existencia').html('');
                        $('#txt_cant_ingrediente').val('0');
                        $('#txt_precio').html('0.00');
                        $('#txt_precio_total').html('0.00');

                        // Desactivar cantidad
                        $('#txt_cant_ingrediente').attr('disabled', 'disabled');

                        // Ocultar botón agregar
                        $('#add_ingrediente_receta').slideUp();

                    }
                }, error: function (error) {
                    console.log(error);
                }
            });
        }

    });

    /* Validar cantidad del producto antes de agregar */
    $('#txt_cant_ingrediente').keyup(function (e) {
        e.preventDefault();
        var precio_total = $(this).val() * $('#txt_precio').html();
        var existencia = parseInt($('#txt_existencia').html());
        $('#txt_precio_total').html(precio_total);

        // Ocultar el boton de agregar si la cantidad es menor que 1
        if (($(this).val() < 1 || isNaN($(this).val())) || ($(this).val() > existencia)) {
            $('#add_ingrediente_receta').slideUp();
        } else {
            $('#add_ingrediente_receta').slideDown();
        }
    });

    // Agregar el producto al detalle
    $('#add_ingrediente_receta').click(function (e) {
        e.preventDefault();
        if ($('#txt_cant_ingrediente').val() > 0) {
            var idProducto = $('#txt_cod_ingrediente').val();
            var cantidad = $('#txt_cant_ingrediente').val();
            var action = 'addIngredienteReceta';

            $.ajax({
                url: '../../controladorBaseDatos/ajax.php',
                type: 'POST',
                async: true,
                data: { action: action, producto: idProducto, cantidad: cantidad },

                success: function (response) {
                    if (response != 'error') {

                        var infoDetalle = JSON.parse(response);
                        console.log(infoDetalle);
                        $('#detalleReceta').html(infoDetalle.detalleRecetaTemp);
                        $('#detalle_totalesR').html(infoDetalle.detalleRecetaTotales);

                        // Limpiar campos
                        $('#txt_cod_ingrediente').val('');
                        $('#txt_descripcion').html('');
                        $('#txt_existencia').html('');
                        $('#txt_cant_ingrediente').val('0');
                        $('#txt_precio').html('0.00');
                        $('#txt_precio_total').html('0.00');

                        // Desactivar cantidad
                        $('#txt_cant_ingrediente').attr('disabled', 'disabled');

                        // Ocultar botón agregar
                        $('#add_ingrediente_receta').slideUp();
                    }
                }, error: function (error) {
                    console.log(error);
                }
            });
        }
    });

    // Generar Receta 
    $('#btnRegistrarReceta').click(function (e) {
        e.preventDefault();
        var rows = $('#detalleReceta tr').length;
        if (rows > 0) {
            var action = 'procesarReceta';

            // Obtener los datos del formulario
            var nombreReceta = $('#nombreReceta').val();
            var tipoReceta = $('#tipoComida').val();
            var tiempoPreparacion = $('#tiempoPreparacion').val();

            $.ajax({
                url: '../../controladorBaseDatos/ajax.php',
                type: 'POST',
                async: true,
                data: {
                    action: action,
                    nombreReceta: nombreReceta,
                    tipoReceta: tipoReceta,
                    tiempoPreparacion: tiempoPreparacion
                },

                success: function (response) {
                    if (response != 'error') {
                        
                        var info = JSON.parse(response);
                        //console.log(info);
                        
                        generarPDF(info.ID_USUARIO, info.ID_RECETA);
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

    // Ver Factura 
    $('.view_receta').click(function(e) {
        e.preventDefault();
        var codUsuario = $(this).attr('usuario');
        var codReceta = $(this).attr('receta');
        generarPDF(1, codReceta);
        console.log(codUsuario);
    });
});

