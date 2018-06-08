 <?php 
    require("ConexionBasesDatos.php");
    
    ini_set('max_execution_time', 5000);
    function url($valor){
	   $ruta = 'https://apex.oracle.com/pls/apex/raspberrypi/weatherstation/getallmeasurements/2339720';
	   if($valor === 0){
			$resultado = $ruta;
	   }else{
		   $resultado = $ruta . "?page="  .$valor; 
	   }
		return $resultado;
    }
    for ($j = 95; $j >= 0; $j--) { /*Debe empezar detrás hacia delante*/
        $jsonCont = file_get_contents(url($j));
       //decode JSON data to PHP array 
       $content = json_decode($jsonCont, true);
    
		for ($i = (count($content['items'])-1); $i >= 0 ; $i--) {/*Debe empezar detrás hacia delante*/
			
			$fecha = $content['items'][$i]['reading_timestamp'];
			if(substr($fecha, 0, 4) !== '1970'){
				$temperatura = $content['items'][$i]['ambient_temp'];
				$presion = $content['items'][$i]['air_pressure'];
				$humedad = $content['items'][$i]['humidity'];
				$viento_dir = $content['items'][$i]['wind_direction'];
				$viento_vel = $content['items'][$i]['wind_speed'];
				$lluvia = $content['items'][$i]['rainfall'];

				$query = "INSERT INTO tiempo
				(fecha_hora,temperatura,presion,humedad,viento_dir,viento_vel,lluvia)
				VALUES ('$fecha','$temperatura','$presion','$humedad','$viento_dir','$viento_vel','$lluvia')";
				if(mysqli_query($conexion,$query)){  
					echo "Fila inserta!!!";
				}
			}
		}
	}
	
    
?>