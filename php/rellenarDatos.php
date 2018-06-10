 <?php 
    require("ConexionBasesDatos.php");/*include incluye y evalúa el archivo especificado y da un warning si no lo encuentra*/
    
	/*como la inserción a la tabla puede durar varios minutos se le da un buen margen de tiempo para que dé error ya que por defecto 
	max_execution_time es de 30 segundos*/
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
    for ($j = 95; $j >= 0; $j--) { /*Detrás hacia delante*/
       $jsonCont = file_get_contents(url($j)); //Transmite el contenido de la ruta a una cadena
       $content = json_decode($jsonCont, true);//Pone al JSON y lo convierte a un array de PHP 
    
		for ($i = (count($content['items'])-1); $i >= 0 ; $i--) {/*Debe empezar detrás hacia delante*/
			
			$fecha = $content['items'][$i]['reading_timestamp'];
			//Los json tiene valores con fecha 1970 y solo se van a insertar aquellos que no sean de este año 
			if(substr($fecha, 0, 4) !== '1970'){ 
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
					echo "Fila inserta!!!";
				}
			}
		}
	}  
?>