<?php
session_start();
include("cabecera.html");
include("funciones.php");
comprobar_ficheros();
$artistas=carpeta("../../musica");

if($artistas!=null){
	$artistas=ordenar_carpetas($artistas);	
}

for($y=0;$y<count($artistas);$y++){
	
	$grupo=carpeta("../../musica/$artistas[$y]"); 
	
	for($x=0;$x<=count($grupo);$x++){
	
		$canciones=mp3("../../musica/$artistas[$y]/".$grupo[$x]."/");
	
		$canciones=ordenar($canciones);

		$nuevonombre=comprobar_nombre($canciones);
		
		$ruta="../../musica/$artistas[$y]/".$grupo[$x]."/";

		for($z=0;$z<count($nuevonombre);$z++){

			if(is_int($canciones[$z][0]) && $canciones[$z][0]>=0 && is_int($canciones[$z][1]) && $canciones[$z][1]>=0 && $canciones[$z][2]=="." && $canciones[$z][3]!=" "){
				
				$nuevonombre[$z]=$canciones[$z][0].$canciones[$z][1].$canciones[$z][2]." ".substr($canciones[$z],3);
			
				rename($ruta.$canciones[$z],$ruta.$nuevonombre[$z]);
			}
		
			else{
				
				if($canciones[$z][0]<=9 && $canciones[$z][1]<=9 && $canciones[$z][2]=="." && $canciones[$z][3]==" "){
					$valido=true;
				}
				
				else{
					
				$nuevonombre[$x]=comprobar_caracteres_iniciales($nuevonombre[$x]);

				$nuevonombre[$z]=eliminar_numeros_espacios_y_primer_punto($nuevonombre[$z]);

				if($z>=0 && $z<9){
						if($nuevonombre[$z][0]=="."){
							$nuevonombre[$z]=substr($canciones[$z],5);
				
						}
						$nuevonombre[$z]="0".($z+1).". ".$nuevonombre[$z];
				
					}
			
					else{
	
						$nuevonombre[$z]=($z+1).". ".$nuevonombre[$z];
						
						$nuevonombre[$z]=str_replace("  "," ",$nuevonombre[$z]);
					}
		
					if($nuevonombre[$z]!=$canciones[$z]){
						if(ord($canciones[$z][0])<59 && ord($canciones[$z][0])>47 && $canciones[$z][1]=="." && $canciones[$z][2]==" " ||
							ord($canciones[$z][0])<59 && ord($canciones[$z][0])>47	&& $canciones[$z][1]=="-"	&& $canciones[$z][2]==" " ||
							ord($canciones[$z][0])<59 && ord($canciones[$z][0])>47	&&	$canciones[$z][1]==" " &&
							ord($canciones[$z][2])>64 && ord($canciones[$z][2])<123){
								$nuevonombre[$z]="0".$canciones[$z][0].substr($nuevonombre[$z],strpos($nuevonombre[$z], "."));
						}
						$nuevonombre[$z]=str_replace("-"," ",$nuevonombre[$z]);
						$nuevonombre[$z]=str_replace("_"," ",$nuevonombre[$z]);
						$nuevonombre[$z]=str_replace("  "," ",$nuevonombre[$z]);
						
						if(substr($nuevonombre[$z],strlen(substr($nuevonombre[$z],0,-6)),-4)=="  "){
							$nuevonombre[$z]=substr($nuevonombre[$z],0,-6).".mp3";
						}
						rename($ruta.$canciones[$z],$ruta.$nuevonombre[$z]);
					}
				}	 
			}	 
		}
	}
}

for($x=0;$x<count($artistas);$x++){
	print '
					<option value="'.$artistas[$x].'">'.$artistas[$x].' </option>
	';
}
?>
			</select>
		</td><td>		
				<input style="height:80px;width:80px;" name="enviar" type="submit"/>
		</form>		
		</div>
</td>
</tr>
<tr>
<td colspan="2">

<?php

if (isset($_POST['enviar'])){
	print '	<br/>	<div name="margen_1" style="font-size:30px;width:100%;height:150px;float:left;background-color:#F3F4F4;font-weight:bold;color:#3D4BF4;">';

	if(file_exists ("../../imagenes/".$_POST['artista'].".jpg")){
		$imagen="../../imagenes/".$_POST['artista'].".jpg";
	}
	
	else{
		$imagen="artista.jpg";
	}
	
	print '<img style="height:150px;width:150px;" src="'.$imagen.'"/>';
	
	print '
	</div>
	</td>
	<tr><td colspan="2">
			<div name="margen_2" style="width:100%;float:left;height:20%;">
	<br/>
		<select id="producto" onchange="ShowSelected();" >';

	$artista=$_POST['artista'];
	$artistas=ver_artistas("../../musica/".$artista."/");
	$artistas=ordenar($artistas);
	
	if (!in_array($_COOKIE["selected"], $artistas) || $_COOKIE["selected"]==null || $_COOKIE["selected"]=="") {
		$_COOKIE["selected"]="Elige un &aacute;lbum";
	}
	
	print '<option style="display:none;" value="playlist0">'.$_COOKIE["selected"].'</option>';
		
	for($x=1;$x<=count($artistas);$x++){
		print '<option value="playlist'.$x.'">'.$artistas[$x-1].'</option>';
	}

	$grupo=carpeta("../../musica/$artista");   
	$grupo=ordenar($grupo);     		
	print '</select>';
	
	print '<script>function ShowSelected(){
	var combo = document.getElementById("producto");
	var selected = combo.options[combo.selectedIndex].text;';
	print "
	document.cookie ='selected='+selected;
	document.location.reload();
	}
	</script>";
 
print '</div>
	</td></tr>

	</table>
			<div class="pc" name="reproductor"  id="componentWrapper">
	
				<div class="playerHolder">
				
					<div class="player_mediaName_Mask">
						<div class="player_mediaName"></div>
					</div>
					
					<div class="player_mediaTime">
						<div class="player_mediaTime_current">0:00</div><div class="player_mediaTime_total">0:00</div>
					</div>
				
					 <div class="player_controls">
                
                      <div class="controls_prev"><img src="media/data/icons/set1/prev.png" /></div>
                   
                      <div class="controls_toggle"><img src="media/data/icons/set1/play.png" /></div>
                   
                      <div class="controls_next"><img src="media/data/icons/set1/next.png" /></div>
                      
                      <div class="player_volume"><img src="media/data/icons/set1/volume.png"/></div>
                      <div class="volume_seekbar">
                         <div class="volume_bg"></div>
                         <div class="volume_level"></div>
                       
                  		 <div class="player_volume_tooltip"><p></p></div>
                      </div>';

print'          </div>
					
					<div class="player_progress">
						<div class="progress_bg"></div>
						<div class="load_progress"></div>
						<div class="play_progress"></div>
	
						<div class="player_progress_tooltip"><p></p></div>
					</div>
					
				</div>
				
				<div>
					<div class="componentPlaylist">
						<div class="playlist_inner">
					
						</div>
					</div>
			
					<div class="preloader"></div>
				</div>
			
			</div>  ';
		
	print '<div stlye="height:100%;" id="playlist_list">';

	print '	<ul id="playlist1">';
	$canciones=mp3("../../musica/$artista/".$_COOKIE["selected"]."/");
	$canciones=ordenar($canciones);

	for($y=0;$y<count($canciones);$y++){
		
		print '<li class= "playlistItem" data-type="local"
		data-mp3="../../musica/'.$artista."/".$_COOKIE["selected"]."/".$canciones[$y].'"';
		
		print ' data-download="../../musica/'.$artista."/".$_COOKIE["selected"]."/".$canciones[$y].'">';
		print '<a class="playlistNonSelected" href="#">';
		print substr($canciones[$y],3,-4).'</a>';
		print '<a href="../../musica/'.$artista."/".$_COOKIE["selected"]."/".$canciones[$y].'" download="'.$canciones[$y].'"><img src="media/data/dlink.png"/></a>
		</li>';
	}	
	print "</ul>";

}
else{
		print '
			 <div style="height:100%;" id="componentWrapper">
        
       		 <div class="playerHolder">
             
                  <div class="player_mediaName_Mask">
                 	  <div class="player_mediaName"></div>
                  </div>
                  
                  <div class="player_mediaTime">
                  	  <div class="player_mediaTime_current">0:00</div><div class="player_mediaTime_total">0:00</div>
                  </div>
             
                  <div class="player_controls">
         
                      <div class="controls_prev"><img src="media/data/icons/set1/prev.png" alt="controls_prev"/></div>
                      
                      <div class="controls_toggle"><img src="media/data/icons/set1/play.png" alt="controls_toggle"/></div>
           
                      <div class="controls_next"><img src="media/data/icons/set1/next.png" alt="controls_next"/></div>
                      
                      <div class="player_volume"><img src="media/data/icons/set1/volume.png" alt="player_volume"/></div>
                      <div class="volume_seekbar">
                         <div class="volume_bg"></div>
                         <div class="volume_level"></div>
 
                  		 <div class="player_volume_tooltip"></div>
                      </div>
                     
                  </div>
                  
                  <div class="player_progress">
                      <div class="progress_bg"></div>
                      <div class="load_progress"></div>
                      <div class="play_progress"></div>
   
                  	  <div class="player_progress_tooltip"><p></p></div>
                  </div>
                  
             </div>
              
             <div>
                 <div class="componentPlaylist">
                     <div class="playlist_inner">
                 
                     </div>
                 </div>
        
                 <div class="preloader"></div>
             </div>
        
        </div>';
		print '<div id="playlist_list">';
        print '  
             <ul id="playlist1"></ul>';
		} 
?>

</div>
</body>
</html>