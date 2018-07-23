<?php 
    $seguir = true;
    $arrayAsociativo = [];
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
    for ($j = 0; $j < 96 && $seguir; $j++) { 
       $jsonCont = file_get_contents(url($j)); //Transmite el contenido de la ruta a una cadena
       $content = json_decode($jsonCont, true);//Pone al JSON y lo convierte a un array de PHP 
       
        for ($i = 0; $i <= (count($content['items'])-1) && $seguir; $i++) {
            $fecha = $content['items'][$i]['reading_timestamp'];
            $temperatura = $content['items'][$i]['ambient_temp'];
            $presion = $content['items'][$i]['air_pressure'];
            $humedad = $content['items'][$i]['humidity'];
            $viento_dir = $content['items'][$i]['wind_direction'];
            $viento_vel = $content['items'][$i]['wind_speed'];
            $lluvia = $content['items'][$i]['rainfall'];

            $resultado = mysqli_query($conexion,"SELECT * FROM tiempo WHERE fecha_hora = '$fecha'");
            $numResultado = mysqli_num_rows($resultado);
            
            if($numResultado == 0){  
                $array = array($fecha, $temperatura, $presion, $humedad, $viento_dir, $viento_vel, $lluvia);
                array_push($arrayAsociativo, $array);
            }else{
                $seguir = false;
               
                for($k = (count($arrayAsociativo)-1); $k >= 0; $k--){
                    //INSERT de los valores a la tabla tiempo 
                    $valFecha = $arrayAsociativo[$k][0];$valTemp = $arrayAsociativo[$k][1];$valPres = $arrayAsociativo[$k][2];
                    $valHum = $arrayAsociativo[$k][3];$valVientDir = $arrayAsociativo[$k][4];$valVientVel = $arrayAsociativo[$k][5];$valLluvia = $arrayAsociativo[$k][6];
                    $query = "INSERT INTO tiempo (fecha_hora,temperatura,presion,humedad,viento_dir,viento_vel,lluvia)
                    VALUES ('$valFecha','$valTemp','$valPres','$valHum','$valVientDir','$valVientVel','$valLluvia')";

                    mysqli_query($conexion,$query);
                }
				//Devolver el número total de páginas 
				$result=mysqli_query($conexion,"SELECT count(*) as total from tiempo");
				$data=mysqli_fetch_assoc($result);
				echo round(($data['total']/500)-1, 0, PHP_ROUND_HALF_DOWN);
            }
        }
    }
?>