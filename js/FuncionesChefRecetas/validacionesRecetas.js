
// Para filtrar la tabla de productos 
function filtroTablaProductos() {
    var input = document.getElementById("buscarProducto-input");
    var filter = input.value.toUpperCase();
    var table = document.getElementById("tablaRegistroProductos");
    var rows = table.getElementsByTagName("tr");

    for (var i = 1; i < rows.length; i++) {
        var cedulaCol = rows[i].querySelector("[data-cell='Nombre Producto']");
        if (cedulaCol) {
            var productoValue = cedulaCol.textContent || cedulaCol.innerText;
            if (productoValue.toUpperCase().indexOf(filter) > -1) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
}


function esEnteroPositivo(numero) {
    return /^[1-9]\d*$/.test(numero);
}

function noContieneNumeros(cadena) {
    return /^[^\d]+$/.test(cadena);
}

// Validar el formulario de recetas
function validarFormulario() {
    const idReceta = document.getElementById('idReceta').value;
    const nombreReceta = document.getElementById('nombreReceta').value;
    const tipoComida = document.getElementById('tipoComida').value;

    if (!esEnteroPositivo(idReceta)) {
        alert('El Id de la receta debe ser un número entero positivo.');
        return false;
    }

    if (!noContieneNumeros(nombreReceta)) {
        alert('El nombre de la receta no debe contener números.');
        return false;
    }

    if (tipoComida === '') {
        alert('Debes seleccionar una opción para el tipo de comida.');
        return false;
    }

    mostrarReceta();
    return true;
}