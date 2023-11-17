/* --------------------------------------------------- USANDO JQUERY ------------------------------------------- */

$(document).ready(function () {
    // Modal Fomr agregar stock producto
    $(".add_product").click(function (e) {
        e.preventDefault();
        var producto = $(this).attr('producto');
        var action = 'infoProducto';
        
        $.ajax({
            url: '../../controladorBaseDatos/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, producto: producto },

            success: function (response) {
                console.log(response);
                if(response != 'error') {
                    var info = JSON.parse(response);
                    $('#producto_id').val(info.ID_INGREDIENTE);
                    $('.nameProducto').html(info.DESCRIPCION_INGREDIENTE);
                } 
            },

            error: function (error) {
                console.log(error);
            }
        });
        

        $('.modal').fadeIn();
    }
    );
});

/* --------------------------------------------------- USANDO JSCRIPT ------------------------------------------- */

// Para agregar stock al producto
function sendDataProduct() {
    $('.alertAddProduct').html('');

    $.ajax({
        url: '../../controladorBaseDatos/ajax.php',
        type: 'POST',
        async: true,
        data: $('#form_add_product').serialize(),

        success: function (response) {
            console.log(response);
            if(response != 'error') {
                if (response == 'error') {
                    $('.alertAddProduct').html('<p style="z-index:1;  color: red;">Error al agregar stock</p>');
                } else {
                    var info = JSON.parse(response);
                    console.log(info);
                    $('.row' + info.producto_id + ' .celStock').html(info.nueva_existencia);
                    $('.row' + info.producto_id + ' .celPrecio').html(info.nuevo_precio);
                    $('#txtCantidad').val('');
                    $('#txtPrecio').val('');
                    $('#producto_id').val('');
                    $('.alertAddProduct').html('<p style="z-index:1;">Stock agregado correctamente</p>');
                }
            }
        },

        error: function (error) {
            console.log("error");
        }
    });
}

// Para cerrar el modal
function closeModal(){
    $('#txtCantidad').val('');
    $('#txtPrecio').val('');
    $('.alertAddProduct').html('');
    $('.modal').fadeOut();
}

/* ----------- Filtrado de ingredientes por el nombre del ingrediente */
function filtroTablaProductos() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("buscarProducto-input");
    filter = input.value.toUpperCase();
    table = document.getElementById("tablaRegistroProductos");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1]; // Columna de descripción
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}