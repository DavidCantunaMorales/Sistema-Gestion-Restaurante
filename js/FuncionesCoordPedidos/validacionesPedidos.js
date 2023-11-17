function filtroTablaPedidos() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("buscarPedido-input");
    filter = input.value.toUpperCase();
    table = document.getElementById("tablaRegistroPedidos");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) { // Empieza desde 1 para omitir la fila de encabezado
        td = tr[i].getElementsByTagName("td")[1]; // Columna de Cliente (Cédula)
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



// Obtener el campo de entrada de fecha
var fechaInput = document.getElementById('fechaCreacionFactura');

// Obtener la fecha actual
var fechaActual = new Date();

// Ajustar la fecha según la zona horaria local
fechaActual.setMinutes(fechaActual.getMinutes() - fechaActual.getTimezoneOffset());

// Formatear la fecha en formato ISO sin la parte de la hora
var fechaActualISO = fechaActual.toISOString().split('T')[0];

// Establecer el valor del campo de entrada de fecha
fechaInput.value = fechaActualISO;


function eliminarProducto(fila) {
    var tablaProductos = document.getElementById("tablaProductos");
    tablaProductos.removeChild(fila);
}

function validarFormulario() {
    var numeroFactura = document.getElementById("numeroFactura").value;
    var fechaCreacionFactura = document.getElementById("fechaCreacionFactura").value;
    var fechaVencimientoFactura = document.getElementById("fechaVencimientoFactura").value;
    var nombresCliente = document.getElementById("nombresCliente").value;
    var cedulaCliente = document.getElementById("cedulaCliente").value;
    var numeroCliente = document.getElementById("numeroCliente").value;
    var correoCliente = document.getElementById("correoCliente").value;

    if (!validarNumeroFactura(numeroFactura)) {
        alert("Por favor ingresa un número de factura válido (número entero positivo).");
        return false;
    }

    if (!validarFechaCreacionFactura(fechaCreacionFactura)) {
        alert("Por favor ingresa una fecha de creación de factura válida.");
        return false;
    }

    if (!validarFechaVencimientoFactura(fechaVencimientoFactura)) {
        alert("Por favor ingresa una fecha de vencimiento de factura válida.");
        return false;
    }

    if (!validarNombresCliente(nombresCliente)) {
        alert("Por favor ingresar correctamente el nombre.");
        return false;
    }

    if (!validarCedulaCliente(cedulaCliente)) {
        alert("Por favor ingresa una cédula válida de 10 dígitos numéricos.");
        return false;
    }

    if (!validarNumeroCliente(numeroCliente)) {
        alert("Por favor ingresa un número de celular válido de 10 dígitos numéricos.");
        return false;
    }

    if (!validarCorreoCliente(correoCliente)) {
        alert("Por favor ingresa un correo electrónico válido.");
        return false;
    }

    mostrarDatosIngresados();

    return true;
}

function validarFechaCreacionFactura(fechaCreacionFactura) {
    return true;
}

function validarFechaVencimientoFactura(fechaVencimientoFactura) {
    var fechaSistema = new Date();
    var fechaVencimiento = new Date(fechaVencimientoFactura);

    // Comparamos las fechas
    if (fechaVencimiento < fechaSistema) {
        alert("La fecha de vencimiento de la factura no puede ser anterior a la fecha actual.");
        return false;
    }

    return true;
}

function validarNombresCliente(nombresCliente) {
    var regex = /^[A-Za-zñáéíóú]+\s[A-Za-zñáéíóú]+\s[A-Za-zñáéíóú]+\s[A-Za-zñáéíóú]+$/;
    return regex.test(nombresCliente);
}

function validarCedulaCliente(cedulaCliente) {
    var regex = /^\d{10}$/;
    return regex.test(cedulaCliente);
}

function validarNumeroCliente(numeroCliente) {
    var regex = /^\d{10}$/;
    return regex.test(numeroCliente);
}

function validarCorreoCliente(correoCliente) {
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(correoCliente);
}

