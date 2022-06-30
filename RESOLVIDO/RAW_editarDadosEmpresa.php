<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenTrades</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Web Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    

	<?php 
		include("includes/config.php");
		
		

		include'classes/district.php';
		$ctrldistrict=new handlerDistrict();	

        include 'classes/fornecedor.php';
        $ctrlForncedor=new fornecedor($db);
        
        include 'classes/user.php';
        $ctrlUser=new user($db);

        if (!$ctrlUser->islogged())
	        header('Location: RAW_index.php');
            //EJECT


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
			
		function registar(){
			//EXEMPLO DE AJAX -> var telefone = ($("#telefone").val())
			let senha = document.getElementById("senha1").value;
			let senha2 = document.getElementById("senha2").value;

			if (senha==senha2){
				console.log("Entrei");
				let nif = document.getElementById("nif").value;
				let nome = document.getElementById("nome").value;
				let sobreNome = document.getElementById("sobreNome").value;
				let genero = document.querySelector('input[name="genero"]:checked').value;
				let email = document.getElementById("email").value;
				let morada = document.getElementById("morada").value;
				let codigoPostal = document.getElementById("codPostal").value;
				let distrito = document.getElementById("distrito").value;
				let concelho = document.getElementById("concelho").value;
				let dataNasc = document.getElementById("dataNasc").value;
				let tipoConta = document.querySelector('input[name="tipoConta"]:checked').value;
				let tlf = document.getElementById("tlf").value;
				let anuncios = document.querySelector('input[name="anuncios"]:checked').value;
				
				$.ajax({
					type: "POST",
					url: 'ajax_user.php',
					data: {
						codigo: 1,
						nif: nif,
						nome: nome,
						sobreNome: sobreNome,
						genero: genero,
						email: email,
						senha: senha,
						morada: morada,
						codigoPostal: codigoPostal,
						distrito: distrito,
						concelho:concelho,
						dataNascimento:dataNasc,
						tipoConta:tipoConta,
						contacto:tlf,
						anuncios:anuncios,
						},
					dataType: "html",
					success: function (data){
							if (data) {
								
								document.getElementById('atualiza').innerHTML = data;

							}else{
								alert("Erro no Registo")

							}
						}
					});

			}else{
				alert("Somehow A senha nao é correcta ALTEREM ME DEPOIS");
			}
		}

	</script>


	
</head>
<body>
		<?php 
     		include 'topo.php';

     	?>
		<div class="content">
            

			<?php  

				include 'showMsg.php';
                //$nif, $nome, $sobreNome, $genero, $email, $morada, $codigoPostal, $distrito, $concelho, $dataNascimento,  $contacto, $anuncios, $senha=""
			
			?>
            <?php 
                 $resultado = $$ctrlForncedor->getTodosOsDados($_SESSION['nif']);
                 $resultado = $ctrlUser->getTodosOsDados($_SESSION['nif']);
            ?>

			<form  METHOD="POST" ACTION="ajax_fornecedor.php" name="registar">
				<input type="hidden" name="codigo" value=4>

				<label>Nome da Empresa<span>*</span></label>
				<input id="nome" name="nome" type="text" value="<?php echo $resultado['nomeEmpresa']; ?>" required placeholder="">
				<br>


				<label>Descrição<span>*</span></label>
				<input id="sobreNome" name="sobreNome" value="<?php echo $resultado['descricao']; ?>" type="text" required placeholder="">
				<br>

                <label>Contacto<span>*</span></label>
				<input id="tlf" name="contacto" type="text" pattern="\d{9}" value="<?php echo $resultado['contato']; ?>" title="Numero de telefone com 9 digitos" required placeholder="">
				<br>

				<label>Email<span>*</span></label>
				<input id="email" name="email" type="email" value="<?php echo $resultado['email']; ?>" required placeholder="">
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
				<br>

				<input id="nif" name="nif" type="hidden"  value="<?php echo $resultado['nif']; ?>" pattern="\d{9}" title="Numero de contribuinte com 9 digitos" required placeholder="">

				<label>Data Nascimento<span>*</span></label>
				<input id="dataNascimento" name="dataNascimento" type="date" value="<?php echo $resultado['dataNascimento']; ?>" required placeholder="">
				<br>
				
				


				<label>Mostrar artigos personalizados<span>*</span></label>
				<br>
				<input name="anuncios" type="radio" required <?php echo ($resultado['anuncios']=='1' ?"checked":""); ?>  value="1"> Sim
				<br>
				<input name="anuncios" type="radio" required <?php echo ($resultado['anuncios']=='0' ?"checked":""); ?> value="0"> Não


				<br>
				<label>Ao registar, concorda com os termos e serviços!<span>*</span></label>
				<br>
				
				<label>Insira a pass para guardar novos dados</label><br>
                <input  name="passAntiga" type="password"  required placeholder="Insira a sua password antiga para Validar">

				<input type="hidden" required value="<?php echo $resultado['password']; ?>">

				<input type="submit" value="Guardar">

				<span id="atualiza"></span><br>
				

	
			</form>
			<a href="userAccount.php"> <button >Voltar</button> </a>
			<br>
			
        </div>

	    <?php

        	/* include("includes/footer.php") */
    
    	?>
</body>

	<!-- /End Footer Area -->
 
	<!-- Jquery -->
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
