<?php
    $con = mysqli_connect("localhost", "root", "rootroot", "nube"); 
        if (mysqli_connect_errno()) {
            echo "Error de conexion" . mysqli_connect_error();
        }
