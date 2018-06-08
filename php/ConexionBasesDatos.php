<?php
    $conexion = mysqli_connect("localhost","root","") or die('Database Not Connected. Please Fix the Issue! ' . mysql_error());
    if($conexion){
            $BD = mysqli_select_db($conexion,"apptiempo");
            if(! $BD){
                    exit('No se pudo seleccionar la base de datos.');
            }
    }else{
            exit('Error de conexión.');
    }
?>