<?php

function eliminar_numeros_espacios_y_primer_punto($cadena){
	
	$cortar=0;
	
		for($x=0;$x<strlen($cadena);$x++){
			
			$punto=strpos($cadena, ".");
			
			for($z=0;$z<$punto;$z++){
				
				if(ord($cadena[$punto-1])<59 && ord($cadena[$punto-1])>47 || $cadena[$punto-1]==" "){
					$cortar++;
				}
			}
			
			if($cortar>0){
				
				$cortar++;
				$cadena=substr($cadena,$cortar);
			}
			$cortar=0;
		}
		return $cadena;	
}

function comprobar_caracteres_iniciales($cadena){
	$cadena=str_replace("  "," ",$cadena);
	if($cadena[0]==" " || $cadena[0]=="." ){
		$cadena=substr($cadena,1);
	}
	return $cadena;
}

function ordenar(array $array){
	$salida=array();
	asort($array);
	foreach ($array as $key => $val) {
		$salida[] = $val;
	}
	return $salida;
}

function comprobar_nombre(array $canciones){
	
	for($x=0;$x<count($canciones);$x++){
				
		if($canciones[$x][0]<=9 && $canciones[$x][1]<=9 && $canciones[$x][2]=="-" && $canciones[$x][3]!=" " ){

			$canciones[$x]=substr($canciones[$x],-(strlen(($canciones[$x]))-3));
		}
		
		if($canciones[$x][0]<=9 && $canciones[$x][1]<=9 && $canciones[$x][2]=="." && $canciones[$x][3]=="-" && $canciones[$x][4]==" "){

			$canciones[$x]=substr($canciones[$x],-(strlen(($canciones[$x]))-2));
		}
	
		if($canciones[$x][0]<=9 && $canciones[$x][1]<=9 && $canciones[$x][2]=="." && $canciones[$x][3]==" " || $canciones[$x][0]<=9 && $canciones[$x][1]<=9 && $canciones[$x][2]==" " && $canciones[$x][3]=="_"){
			
			$canciones[$x]=substr($canciones[$x],-(strlen(($canciones[$x]))-4));
		
		}
		
		else{
			$comprobacion=substr($canciones[$x],0,5);
			if(substr($canciones[$x],0,1)<=9 || substr($canciones[$x],0,1)==" " || substr($comprobacion,-1)==" " ||	substr($comprobacion,-2,1)==" " && substr($comprobacion,-3,1)=="." || $canciones[$x][0]<=9 && substr($comprobacion,-4,1)=="." || $canciones[$x][0]<=9 && substr($comprobacion,-4,1)<=9){
				if($canciones[$x][0]<=9 && $canciones[$x][2]==" " && $canciones[$x][1]==" "){
					$canciones[$x]=substr($canciones[$x],2);
				}
				else{
					if($canciones[$x][0]<=9 && $canciones[$x][1]<=9 && $canciones[$x][2]==" " && $canciones[$x][3]=="-"||
						$canciones[$x][0]<=9 && $canciones[$x][1]<=9 && $canciones[$x][2]==" " && $canciones[$x][3]=="."){
						$canciones[$x]=substr($canciones[$x],4);
					}
					else{
						if($canciones[$x][0]<=9 && $canciones[$x][1]>=9 && $canciones[$x][1]!="-" ){

							$canciones[$x]=substr($canciones[$x],3);
						}
						else{
						
							if($canciones[$x][0]<=9 && ord($canciones[$x][0])<65 && ord($canciones[$x][1])>=65 ){
							
								$canciones[$x]=substr($canciones[$x],1);
							}
							else{

								if($canciones[$x][0]<=9 && ord($canciones[$x][0])<65 && ord($canciones[$x][0])>32 && $canciones[$x][1]<=9 && ord($canciones[$x][1])<65 && ord($canciones[$x][1])>32 && $canciones[$x][3]!="." ){
										$canciones[$x]=substr($canciones[$x],3);
								}
									else{
										if($canciones[$x][0]<=9 && ord($canciones[$x][0])<58 && $canciones[$x][1]<=9 && ord($canciones[$x][1])<58){
											$canciones[$x]=substr($canciones[$x],2);		
										}
									}
							}
						}
					}
				}
			}
			if(substr($canciones[$x],-8,1)=="."){
				$canciones[$x]=substr($canciones[$x],0,-8).".mp3";
			}
		}
		if($canciones[$x][0]==" " || $canciones[$x][0]=="-"|| $canciones[$x][0]=="."){
			$canciones[$x]=substr($canciones[$x],1);
		}
		
		$canciones[$x]=str_replace("(240p_H.263-MP3)","_",$canciones[$x]);
		$canciones[$x]=str_replace("(240p_H.264-AAC)","_",$canciones[$x]);
		$canciones[$x]=str_replace("(360p_H.264-AAC)","_",$canciones[$x]);
		$canciones[$x]=str_replace("(480p_H.264-AAC)","_",$canciones[$x]);
		$canciones[$x]=str_replace("(128kbit_AAC)","_",$canciones[$x]);
		$canciones[$x]=str_replace("(WwW.FlowMP3.Com)","_",$canciones[$x]);
		$canciones[$x]=str_replace("(128kbitAAC)","_",$canciones[$x]);
		$canciones[$x]=str_replace("(192kbitAAC)","_",$canciones[$x]);
		$canciones[$x]=str_replace("  "," ",$canciones[$x]);
		$canciones[$x]=str_replace(".-",". ",$canciones[$x]);
		
		$canciones[$x][0]=strtoupper ($canciones[$x][0]);
	}
	return $canciones;
}

function ordenar_carpetas(array $array){
	$salida=array();
	sort($array);
	foreach ($array as $clave => $valor) {
		$salida[]=$valor;
	}
	return $salida;	
}

function carpeta($ruta){
	$directorio = opendir($ruta); 
	$archivos=array();
	while ($archivo = readdir($directorio)){
		if($archivo!="." && $archivo!=".."){
			$archivos[]=$archivo;
		}
   	}
	return $archivos;
}

function mp3($path) {
    $dir = opendir($path);
    $files = array();
    while ($current = readdir($dir)) {
        if ($current != "." && $current != "..") {
            if (is_dir($path . $current)) {
                showFiles($path . $current . '/');
            } 
			else {
				if(substr($current,-4)==".mp3"){
					$files[] = $current;
				}
            }
        }
    }
    return $files;
}

function playlist(array $musica, $artistas){
	for($x=0;$x<count($musica);$x++){
		print '<li class= "playlistItem" data-type="local"
		data-mp3="../musica/'.$artistas."/".$musica[$x].'"';
		print ' data-download="../musica/'.$artistas."/".$musica[$x]."\">";
		print '<a class="playlistNonSelected" href="#">';
		print substr($musica[$x],0,-4)."</a></li>";
	}
}

function comprobar_ficheros() {
    if (!file_exists("../../musica")) {
        mkdir("../../musica", 0777, true);
    }
	if (!file_exists("../../imagenes")) {
        mkdir("../../imagenes", 0777, true);
    }
}

function ver_artistas($path) {
    $dir = opendir($path);
    $files = array();
    while ($current = readdir($dir)) {
       if ($current != "." && $current != "..") {
                $files[] = $current;
        }
    }
    return $files;
}

function showFiles($path) {
    $dir = opendir($path);
    $files = array();
    while ($current = readdir($dir)) {
        if ($current != "." && $current != "..") {
            if (is_dir($path . $current)) {
                showFiles($path . $current . '/');
            } 
			else {
                $files[] = $current;
            }
        }
    }
    return $files;
}

?>