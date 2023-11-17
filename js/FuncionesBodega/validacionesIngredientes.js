// Calcular el valor total del producto ingresado 
function calcularPrecioTotal() {
    var stock = parseFloat(document.getElementById("stockProducto").value);
    var costoUnitario = parseFloat(document.getElementById("costoUProducto").value);

    if (!isNaN(stock) && !isNaN(costoUnitario)) {
        var precioTotal = stock * costoUnitario;
        document.getElementById("costoTProducto").value = precioTotal.toFixed(2);
    }
}

document.getElementById("costoUProducto").addEventListener("input", calcularPrecioTotal);
/* -------------------------------------------------------------------------- */

function validarFormulario() {
    var codigoProducto = document.getElementById("codigoProducto").value;
    var unidadesProducto = document.getElementById("unidadesProducto").value;
    var precioProducto = document.getElementById("precioProducto").value;

    if (!validarCodigoProducto(codigoProducto)) {
        alert("Por favor ingresa un código de producto válido (número entero positivo).");
        return false;
    }

    if (!validarUnidadesProducto(unidadesProducto)) {
        alert("Por favor ingresa una cantidad de unidades válida (número entero positivo).");
        return false;
    }

    if (!validarPrecioProducto(precioProducto)) {
        alert("Por favor ingresa un precio válido (número positivo).");
        return false;
    }

    return true;
}

function validarCodigoProducto(codigoProducto) {
    var regex = /^\d+$/;
    return regex.test(codigoProducto);
}

function validarUnidadesProducto(unidadesProducto) {
    var regex = /^\d+$/;
    return regex.test(unidadesProducto);
}

function validarPrecioProducto(precioProducto) {
    var regex = /^\d+(\.\d+)?$/;
    return regex.test(precioProducto);
}