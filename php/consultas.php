<?php
    require("conexionBasesDatos.php");
    $estado = $_GET['boton'];/*Recibe la identificación del botón que se ha clickado en la página*/
	$fecha = $_GET['fecha'];/*Fecha con el formato '2018-01-04' por si se consulta un día en concreto*/
	switch ($estado) {
		case '4Semanas'://144xdias * 28 dias = 4032 se pide 5000 por si acaso 
			$query = "SELECT * FROM `tiempo` ORDER by id DESC LIMIT 5000";
			break;
		case '6Meses': //144xdias * 30 dias * 6meses = 25920 se pide 27000 por si acaso
			$query = "SELECT * FROM `tiempo` ORDER by id DESC LIMIT 27000";
			break;
		case 'anos':
			$query = "SELECT * FROM tiempo ORDER BY id DESC";
			break;
		case '24Horas': 
			$query = "SELECT * from tiempo where SUBSTRING(fecha_hora, 1, 10) = '$fecha'";
			break;
		default:
			echo "ERROR.";
			break;
        }

	$consulta = mysqli_query($conexion,$query);
	if ($consulta === FALSE) {
		echo 'Error de ejecución de la consulta.<br />';
	} else { //SI TODO HA IDO BIEN
		$datos = "";
		while($fila = mysqli_fetch_assoc($consulta)){			
		   $fecha = $fila['fecha_hora'];
		   $temperatura = $fila['temperatura'];
		   $presion = $fila['presion'];
		   $humedad = $fila['humedad']; 
		   $viento_dir = $fila['viento_dir'];
		   $viento_vel = $fila['viento_vel'];
		   $lluvia = $fila['lluvia'];

		   /*Se rellena el array datos con los valores de los campos de la tabla tiempo
		   cada posición del array es una fila de la tabla y se separa con ";" y los valores de cada fila con "="*/
		   $datos .= $fecha."=".$temperatura."=".$presion."=".$humedad."=".$viento_dir."=".$viento_vel."=".$lluvia.";";
		}
		echo $datos;
	}    
?>