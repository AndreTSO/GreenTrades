<?php 
include 'includes/config.php';   

include 'classes/district.php';
$ctrldistrict=new handlerDistrict($db);


if (isset($_POST['distrito'] )) {
	
	$resultado=$ctrldistrict->getConcelhoByDistrictId($db, $_POST['distrito']);
	
	if (isset($_POST['registo'])){
		echo"<select name='concelho' id='conse' required class='form-control'>";
	}else{
		echo"<select name='concelho' id='conse' required >";
	}
	
	if ($resultado && $resultado->RecordCount()>0){
		echo "<option value=''  >Escolha o concelho</option>";			
		while ($linha=$resultado->FetchRow()){
			echo "<option value='".$linha['id']."'  >".$linha['name']."</option>";
		}
	}else{
		echo "<option value=''  >Erro - Selecione um distrito primeiro!</option>";
	}
	echo "</select>";	
	}



?>