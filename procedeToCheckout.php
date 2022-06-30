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
	<link rel="stylesheet" href="css/botoes.css">
    

	<?php 
		include("includes/config.php");
		
		

		include'classes/district.php';
		$ctrldistrict=new handlerDistrict();	

        include 'classes/user.php';
        $ctrlUser=new user($db);

		include 'classes/transportador.php';
        $ctrlTrans=new transportador($db);

        if (!$ctrlUser->islogged())
	        header('Location: index.php');
            //EJECT

		if (!(isset($_POST['quantArtigos']))){
			header('Location: cesto.php');
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
	<div class="body">
		<?php 
     		include 'topo.php';

     	?>
		<div class="page">
			<div class="content">
				<?php  

					include 'showMsg.php';
                	//$nif, $nome, $sobreNome, $genero, $email, $morada, $codigoPostal, $distrito, $concelho, $dataNascimento,  $contacto, $anuncios, $senha=""
			
				?>
            	<?php 
                	$resultado = $ctrlUser->getTodosOsDados($_SESSION['nif']);
            	?>

				<div class="data">
					<form  METHOD="POST" ACTION="finish.php" name="registar">
						<h2>Dados do comprador</h2>
						
						<hr>
						<input type="hidden" name="codigo" value=3>

						<label><strong><em>Nome: &nbsp </em></strong></label>
						<input id="nome" name="nome" type="text" value="<?php echo $resultado['nome']; ?>" required placeholder="">
						<br>


						<label><strong><em>Sobrenome: &nbsp </em></strong></label>
						<input id="sobreNome" name="sobreNome" value="<?php echo $resultado['sobreNome']; ?>" type="text" required placeholder="">

						
					
						<br>
						<label><strong><em>Nº de Contribuinte: &nbsp </em></strong></label>
						<input id="nif" name="nif" type="number" value="<?php echo $resultado['nif']; ?>" pattern="\d{9}" title="Numero de contribuinte com 9 digitos" required placeholder="">
						<br>
                        
						<label><strong><em>Telefone: &nbsp</em></strong></label>
						<input id="tlf" name="contacto" type="text" pattern="\d{9}" value="<?php echo $resultado['contato']; ?>" title="Numero de telefone com 9 digitos" required placeholder="">
						<br>
						<label><strong><em>Email: &nbsp</em></strong></label>
						<input id="email" name="email" type="email" value="<?php echo $resultado['email']; ?>" required placeholder="">
                        <br><br><br>

                        <h2>Dados para entrega do produto</h2>
						<hr>

						<label><strong><em>Morada: &nbsp</em></strong></label>
						<input id="morada" name="morada" type="text" value="<?php echo $resultado['morada']; ?>" required placeholder="">
						<br>
						<label><strong><em>Código Postal: &nbsp</em></strong></label>
						<input id="codPostal" name="codigoPostal"  pattern="\d{4}-\d{3}" title="DDDD-DDD" type="text" value="<?php echo $resultado['codigoPostal']; ?>"required placeholder="">
						<br>
						<label><strong><em>Distrito: &nbsp</em></strong></label>
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
						<label><strong><em>Concelho: &nbsp</em></strong></label>
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
                        
						<br><br><br>

                        <h2>Artigos Encomendados Resumo</h2>
                        
                        
						<hr><?php
                            echo "<p><strong><em>Nº Total de Artigos: </em></strong>".$_POST['quantArtigos']."  </p>";
							
                            echo "<p><strong><em>Valor sem Iva: </em></strong>".$_POST['valor']."  </p>";
                            echo "<p><strong><em>Valor do Iva: </em></strong>".$_POST['iva']."  </p>";
                            echo "<p><strong><em>Valor Final: </em></strong>".$_POST['valorFinal']."  </p>";
                            echo "<a href='cesto.php'><button type='button' class='btnUser'>Ver artigos novamente </button></a>";

							echo "<input type='hidden' name='quantArtigos' value='".$_POST['quantArtigos']."' >";
							echo "<input type='hidden' name='valor' value='".$_POST['valor']."' >";
							echo "<input type='hidden' name='iva' value='".$_POST['iva']."' >";
							echo "<input type='hidden' name='valorFinal' value='".$_POST['valorFinal']."' >";

                        ?>
                        
                        <br><br><br>

                        <h2>Mensagem Adicional</h2>
						<hr>

                        <textarea class="form-control mb-3" id="order-comments" rows="5" name="aditional"><?php echo $_POST['aditional']?></textarea>
						
						<br><br><br>

                        <h2>Escolha da transportadora</h2>
						<hr>
						<?php
						$transportadoras = $ctrlTrans->getTodasTransportadoraDados();
						if ($transportadoras != null){
							foreach($transportadoras as $transportador){
								echo "<input type='radio' name='trans' required value='".$transportador['idTransportador']."' > ".$transportador['nomeEmpresa']."<br><pre>&#9;".$transportador['descricao']."</pre>";
							}
							echo "<input type='radio' name='trans' required value='0' > Levantar encomenda em armazem <br><pre>&#9;Deslocar-me até ao armazem para recolher o produto</pre>";
						}else{
							echo "Não existem transportadoras disponiveis ";
							echo "<input type='radio' name='trans' required value='0' > Levantar encomenda em armazem <br><pre>&#9;Deslocar-me até ao armazem para recolher o produto</pre>";
						}

						?>

						<br><br><br>

						<h2>Metodo de Pagamento</h2> 
						<hr>
                        
						<input type='radio' name='pagamento' value='Paypal' required > Paypal


						<hr>
						<input type="submit" class="btnUser" value="Finalizar" > <a href="cesto.php"><button type='button'class="btnUser">Voltar </button></a>
					</form>

					<hr>
					<div class="opções">
						
					</div>

					
				</div>
			</div>
        </div>

	    <?php

        	include("includes/footer.php") 
    
    	?>
	</div>
</body>

	<!-- /End Footer Area -->
 
	<!-- Jquery -->
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
