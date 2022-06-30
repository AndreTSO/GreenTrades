<?php 
include 'includes/config.php';   

include'classes/consumidor.php';
$ctrlconsumidor=new consumidor($db,1);


if (isset($_POST['distrito'])) {
	$resultado=$ctrldistrict->getConselho($db, $_POST['distrito']);
	
	echo"<select class='nice-select' name='concelho' id='conse' required>";
	
	
	if ($resultado && $resultado->RecordCount()>0){
		echo "<option value=''  >Escolha o concelho</option>";			
		while ($linha=$resultado->FetchRow()){
			echo "<option value='".$linha['id']."'  >".$linha['name']."</option>";
		}
	}else{
		echo "<option value=''  >Erro - Selecione um distrito primeiro!</option>";
	}
	echo "</select>";	
	echo "<br>";



}

$resultado = $ctrlconsumidor->remAllArtigosCesto(990);
echo $resultado;
die();
if ($resultado && $resultado->RecordCount()>0) {
    while ($linha=$resultado->FetchRow()){
        print_r($linha);
    } 
}else{
    echo "NAO ENCONTREI!!!";
}

?>