<?php 
include 'includes/config.php';   

include 'classes/lib.php';
$ctrlLib=new lib($db);


if (isset($_POST['categoriaPAI'])) {
	if ($_POST['categoriaPAI'] == ""){
		echo "Sub Categoria
				<select>
					<option value='' >Todas</option>
				</select>";
	}else {
		$resultado=$ctrlLib->getSubCategoriaByCategoriaId($db, $_POST['categoriaPAI']);
		if (isset($_POST['pesquisa'])){
			echo" Sub Categoria: <select name='conse' id='conse' required onmouseup='serchAutomatic()'>";
		}else {
			echo"<br>SubCategoria: <select name='tags' id='conse' required >";
		}
		
		
		
		if ($resultado && $resultado->RecordCount()>0){
			
			echo "<option value=''>".(isset($_POST['pesquisa'])?"Todas":"Escolha a subCategoria")."</option>";			
			while ($linha=$resultado->FetchRow()){
				echo "<option value='".$linha['idsubcategoria']."'>".$linha['subcategoria']."</option>";
			}
		}else{
			echo "<option value=''  >Erro - Selecione uma categoria primeiro!</option>";
		}

		if (isset($_POST['pesquisa'])){
			echo "</select>";
		}else {
			echo "</select><br>";
		}
		
	}
}



?>