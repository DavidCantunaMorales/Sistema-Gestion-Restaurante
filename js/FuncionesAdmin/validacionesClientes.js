function filtroTablaProductos() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("buscarProducto-input");
    filter = input.value.toUpperCase();
    table = document.getElementById("tablaRegistroPedidos");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) { // Empieza desde 1 para omitir la fila de encabezado
        td = tr[i].getElementsByTagName("td")[1]; // Columna de Nombre Cliente
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


function filtroTablaUsuarios() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("buscarProducto-input");
    filter = input.value.toUpperCase();
    table = document.getElementById("tablaRegistroUsuarios");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) { // Empieza desde 1 para omitir la fila de encabezado
        td = tr[i].getElementsByTagName("td")[1]; // Columna de Nombre
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


/* MOSTRAR LOS DATOS DEL CLIENTE */
function mostrarDatosIngresados() {
    var nombresCliente = document.getElementById("nombresCliente").value;
    var cedulaCliente = document.getElementById("cedulaCliente").value;
    var tipoCliente = document.getElementById("tipoCliente").value;
    var direccionCliente = document.getElementById("direccionCliente").value;
    var numeroCliente = document.getElementById("numeroCliente").value;
    var correoCliente = document.getElementById("correoCliente").value;

    var mensaje = "Datos ingresados:\n\n";
    mensaje += "Nombres Completos: " + nombresCliente + "\n";
    mensaje += "Cedula Identidad: " + cedulaCliente + "\n";
    mensaje += "Tipo de Cliente: " + tipoCliente + "\n";
    mensaje += "Direccion Domicilio: " + direccionCliente + "\n";
    mensaje += "Numero Celular: " + numeroCliente + "\n";
    mensaje += "Correo Electronico: " + correoCliente + "\n";

    alert(mensaje);
}

/* FUNCIONES QUE VALIDAN LOS DATOS DEL CLIENTE */
function validarNombresCliente(nombresCliente) {
    var regex = /^[A-ZÑÁÉÍÓÚ][a-zñáéíóú]+\s[A-ZÑÁÉÍÓÚ][a-zñáéíóú]+\s[A-ZÑÁÉÍÓÚ][a-zñáéíóú]+\s[A-ZÑÁÉÍÓÚ][a-zñáéíóú]+$/;
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



/* VALIDAR LOS DATOS DEL CLIENTE QUE SE ESTE INGRESANDO */
function validarFormulario() {
    var nombresCliente = document.getElementById("nombresCliente").value;
    var cedulaCliente = document.getElementById("cedulaCliente").value;
    var numeroCliente = document.getElementById("numeroCliente").value;
    var correoCliente = document.getElementById("correoCliente").value;

    if (!validarNombresCliente(nombresCliente)) {
        alert("Por favor Ingresar dos nombres y dos apellidos, cada uno empezando con mayúscula.");
        return false;
    }

    if (!validarCedulaCliente(cedulaCliente)) {
        alert("Por favor ingresa una cédula válida de 10 dígitos.");
        return false;
    }

    if (!validarNumeroCliente(numeroCliente)) {
        alert("Por favor ingresa un número de celular válido de 10 dígitos.");
        return false;
    }

    if (!validarCorreoCliente(correoCliente)) {
        alert("Por favor ingresa un correo electrónico válido.");
        return false;
    }

    return true;
}
