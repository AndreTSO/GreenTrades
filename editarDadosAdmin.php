<!DOCTYPE html>
<html lang="pt">
<head>

	<?php 
		include("includes/config.php");
		
		

		include'classes/district.php';
		$ctrldistrict=new handlerDistrict();	

        include 'classes/user.php';
        $ctrlUser=new user($db);

        if (!$ctrlUser->islogged())
	        header('Location: RAW_index.php');
            //EJECT
        if (isset($_SESSION['nif']) ){
            if (!$ctrlUser->isAuthorized(5,$_SESSION['nif'])){
                header('Location: RAW_index.php');
            }
        }

	?>


	<script>

		function obtemDistrito(){
				let codigo = $('#distrito option:selected').val();
				$.ajax({
				type: "POST",
				url: 'ajax_district.php',
				data: {distrito: codigo},
				dataType: "html",
				success: function (data){
						if (data) {
							document.getElementById('conselho2').innerHTML = data;
						}
					}
				});
			}

		function pw(){
			registo.senha2.setAttribute('pattern', registar.senha.value);
		}
			

	</script>


	
</head>
			
<body>		
		    <a href="admin2.php"> <button >Voltar</button></a>
			
			

			<?php  

				include 'showMsg.php';
                //$nif, $nome, $sobreNome, $genero, $email, $morada, $codigoPostal, $distrito, $concelho, $dataNascimento,  $contacto, $anuncios, $senha=""
			
			?>
            <?php 
                 $resultado = $ctrlUser->getTodosOsDados($_POST['valorEditar']);
            ?>
			<form  METHOD="POST" ACTION="ajax_user.php" name="registar">
				<input type="hidden" name="codigo" value=5>

				<label>Nome<span>*</span></label>
				<input id="nome" name="nome" type="text" value="<?php echo $resultado['nome']; ?>" required placeholder="">
				<br>


				<label>SobreNome<span>*</span></label>
				<input id="sobreNome" name="sobreNome" value="<?php echo $resultado['sobreNome']; ?>" type="text" required placeholder="">

				<br>
					
				<label>Genero<span>*</span></label>
                    
				<br><input type="radio" name="genero" required value="M" <?php echo ($resultado['genero']=='M' ?"checked":""); ?> > Masculino
				<br><input type="radio" name="genero" required value="F" <?php echo ($resultado['genero']=='F' ?"checked":""); ?> > Feminino
				<br><input type="radio" name="genero" required value="O" <?php echo ($resultado['genero']=='O' ?"checked":""); ?> > Prefiro não dizer
				<br>

				<label>Email<span>*</span></label>
				<input id="email" name="email" type="email" value="<?php echo $resultado['email']; ?>" required placeholder="">
				<br>
				<label>Senha<span>*</span></label>
				<input id="senha1" autocomplete="off" name="senha" type="password" value="" placeholder="Prencher para alterar" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="8 Digitos Min 1 numero, Min 1 Maiuscula, min 1 Minuscula">
				<br>
				<label>Repetir Senha<span>*</span></label>
				<input id="senha2" autocomplete="off" name="senha2" type="password" value="" onchange="pw()"  placeholder="">
				<br>
				<label>Morada<span>*</span></label>
				<input id="morada" name="morada" type="text" value="<?php echo $resultado['morada']; ?>" required placeholder="">
				<br>
				<label>Codigo-postal<span>*</span></label>
				<input id="codPostal" name="codigoPostal"  pattern="\d{4}-\d{3}" title="DDDD-DDD" type="text" value="<?php echo $resultado['codigoPostal']; ?>"required placeholder="">

				<br>
				<label>Distrito<span>*</span></label>

				
				<select name='distrito' id='distrito' onChange='obtemDistrito()' required >
					<?php
					$resultado2=$ctrldistrict->getDistrict($db);
					
					echo "<option value=''>Distrito</option>";
					if ($resultado2 && $resultado2->RecordCount()>0){
						
						while ($linha=$resultado2->FetchRow()){
							echo "<option ".($resultado['distrito']==$linha['id']?"selected":"")." value='".$linha['id']."'>".$linha['name']."</option>";
							
						}
					}
					?>
				</select>
				<br>
				
				

				<label>Concelho<span>*</span></label>
				
				<span id="conselho2">
                    <select name='concelho' id='concelho'  required >    
                    <?php
                        $resultado2=$ctrldistrict->getConcelhoByDistrictId($db, $resultado['distrito']);
                        
                        echo "<option value=''>Concelho</option>";
                        if ($resultado2 && $resultado2->RecordCount()>0){
                            
                            while ($linha=$resultado2->FetchRow()){
                                echo "<option ".($resultado['concelho']==$linha['id']?"selected":"")." value='".$linha['id']."'>".$linha['name']."</option>";
                                
                            }
                        }
                        ?>
                    </select>


				</span>


				<input id="nif" name="nif" type="hidden"  value="<?php echo $resultado['nif']; ?>" pattern="\d{9}" title="Numero de contribuinte com 9 digitos" required placeholder="">

				<label>Contacto<span>*</span></label>
				<input id="tlf" name="contacto" type="text" pattern="\d{9}" value="<?php echo $resultado['contato']; ?>" title="Numero de telefone com 9 digitos" required placeholder="">


				<br>
				<label>Mostrar artigos personalizados<span>*</span></label>
			
				<input name="anuncios" type="radio" required <?php echo ($resultado['anuncios']=='1' ?"checked":""); ?>  value="1"> Sim
				<br>
				<input name="anuncios" type="radio" required <?php echo ($resultado['anuncios']=='0' ?"checked":""); ?> value="0"> Não
                <input name="NOAUTH" type="hidden" value="true">


				<input type="submit" value="Guardar">

				<span id="atualiza"></span>


	
			</form>


	<!-- /End Footer Area -->
 
	<!-- Jquery -->
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>

</body>