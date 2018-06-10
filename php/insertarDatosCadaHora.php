<?php 
	//47556  pcntl_fork()
    require("ConexionBasesDatos.php");/*include incluye y evalúa el archivo especificado y da un warning si no lo encuentra*/
    
	$ruta = 'https://apex.oracle.com/pls/apex/raspberrypi/weatherstation/getallmeasurements/2339720';
	$seguir = true;
	$i = 0;
    
   $jsonCont = file_get_contents($ruta); //Transmite el contenido de la ruta a una cadena
   $content = json_decode($jsonCont, true);//Pone al JSON y lo convierte a un array de PHP 

	while($seguir){
		$fecha = $content['items'][$i]['reading_timestamp'];
		$temperatura = $content['items'][$i]['ambient_temp'];
		$presion = $content['items'][$i]['air_pressure'];
		$humedad = $content['items'][$i]['humidity'];
		$viento_dir = $content['items'][$i]['wind_direction'];
		$viento_vel = $content['items'][$i]['wind_speed'];
		$lluvia = $content['items'][$i]['rainfall'];

		//INSERT de los valores a la tabla tiempo 
		$query = "INSERT INTO tiempo (fecha_hora,temperatura,presion,humedad,viento_dir,viento_vel,lluvia)
		VALUES ('$fecha','$temperatura','$presion','$humedad','$viento_dir','$viento_vel','$lluvia')";
		if(mysqli_query($conexion,$query)){  
			echo "FILA INSERTADA";
		}else{
			$seguir = false;
		}
		$i++;
	}
?>