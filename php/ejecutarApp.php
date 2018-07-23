<?php
    $conexion = mysqli_connect("localhost","root","") or die('Database Not Connected. Please Fix the Issue! ' . mysql_error());
	$query = "CREATE DATABASE IF NOT EXISTS apptiempo";
	$operacion = $_GET['operacion'];
	if(mysqli_query($conexion,$query)){
		mysqli_query($conexion,"USE apptiempo");
		
		if($operacion === "consulta"){
			require("consultas.php");
		}else{
			if(mysqli_num_rows(mysqli_query($conexion,"SHOW TABLES LIKE 'tiempo'"))== 1){
            require("actualizarDatos.php");	
			}else{

				$createTable = "CREATE TABLE IF NOT EXISTS `tiempo` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`fecha_hora` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
					`temperatura` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
					`presion` varchar(6) COLLATE utf8_spanish2_ci NOT NULL,
					`humedad` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
					`viento_dir` varchar(6) COLLATE utf8_spanish2_ci NOT NULL,
					`viento_vel` varchar(4) COLLATE utf8_spanish2_ci NOT NULL,
					`lluvia` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
					PRIMARY KEY (id),
					UNIQUE (fecha_hora)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
				if(mysqli_query($conexion,$createTable)){
					require("insertarDatos.php");
				}
			}	
		}
		
	}
    if($conexion){
		$BD = mysqli_select_db($conexion,"apptiempo");/*Si hay conexión se conectara a la BD apptiempo*/
		if(! $BD){
			exit('No se pudo seleccionar la base de datos.');
		}
    }else{
        exit('Error de conexión.');
    }
?>