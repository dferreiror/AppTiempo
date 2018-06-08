<?php
    require("ConexionBasesDatos.php");
    $estado = $_GET['boton'];
	$fecha = $_GET['fecha'];
	switch ($estado) {
		case '4Semanas':
			$query = "SELECT * FROM `tiempo` ORDER by id DESC LIMIT 5000";
			break;
		case '6Meses': //144xdias * 30 dias * 6meses
			$query = "SELECT * FROM `tiempo` ORDER by id DESC LIMIT 27000";
			break;
		case 'anos':
			$query = "SELECT * FROM tiempo ORDER BY id DESC";
			break;
		case '24Horas': //'2018-01-04';
			$query = "SELECT * from tiempo where SUBSTRING(fecha_hora, 1, 10) = '$fecha'";
			break;
		default:
			echo "ERROR.";
			break;
        }

	$consulta = mysqli_query($conexion,$query);
	if ($consulta === FALSE) {
		echo 'Error de ejecución de la consulta.<br />';
	} 
	else 
	{
		$datos = "";
		while($fila = mysqli_fetch_assoc($consulta))
		{			
		   $fecha = $fila['fecha_hora'];
		   $temperatura = $fila['temperatura'];
		   $presion = $fila['presion'];
		   $humedad = $fila['humedad']; 
		   $viento_dir = $fila['viento_dir'];
		   $viento_vel = $fila['viento_vel'];
		   $lluvia = $fila['lluvia'];

		   $datos .= $fecha."=".$temperatura."=".$presion."=".$humedad."=".$viento_dir."=".$viento_vel."=".$lluvia.";";
		}
		echo $datos;
	}    
?>