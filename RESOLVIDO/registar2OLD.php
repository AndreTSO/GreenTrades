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
			registo.senha2.setAttribute('pattern', registo.senha.value);
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
		<div class="content">
            <div class="container">
                <div class="contact-head">
					<div class="row">
						<div class="col-lg-8 col-12">
							<div class="form-main">

								<?php

                                  include('showMsg.php');
                                ?>

								<div class="title">
									<h4>Registar</h4>
									<h3>Registe-se na nossa plataforma</h3>
								</div>

								


								<form class="form" METHOD="POST" ACTION="ajax_user.php" name="registo">
									<input type="hidden" name="codigo" value=2>
									<div class="row">
									<div class="col-12">
										<div class="form-group">
											<label>Nome<span>*</span></label>
											<input id="nome" name="nome" type="text" required placeholder="">
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>SobreNome<span>*</span></label>
											<input id="sobreNome" name="sobreNome" type="text" required placeholder="">
										</div>
									</div>
									<div class="col-12">
										
											
										<label>Genero<span>*</span></label>
				
										<br><input type="radio" name="genero" required value="M" checked="checked"> Masculino
										<br><input type="radio" name="genero" required value="F"> Feminino
										<br><input type="radio" name="genero" required value="O"> Prefiro não dizer
										<br>
									</div>
									
									<div class="col-12">
										<div class="form-group">
											<label>Email<span>*</span></label>
											<input id="email" name="email" type="email" required placeholder="">
										</div>
									</div>

									<div class="col-12">
										<div class="form-group">
											<label>Senha<span>*</span></label>
											<input id="senha1" name="senha" type="password" required placeholder="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="8 Digitos Min 1 numero, Min 1 Maiuscula, min 1 Minuscula">
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>Repetir Senha<span>*</span></label>
											<input id="senha2" name="senha2" type="password" onchange="pw()" required placeholder="">
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>Morada<span>*</span></label>
											<input id="morada" name="morada" type="text" required placeholder="">
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>Codigo-postal<span>*</span></label>
											<input id="codPostal" name="codigoPostal"  pattern="\d{4}-\d{3}" title="DDDD-DDD" type="text" required placeholder="">
										</div>
									</div>
									<div class="col-12">
										
										<div class="form-group">
											<label>Distrito<span>*</span></label>
										</div>
										
										<select name='distrito' id='distrito' onChange='obtemDistrito()' required >
										<?php
										$resultado=$ctrldistrict->getDistrict($db);
										
										echo "<option value=''>Distrito</option>";
										if ($resultado && $resultado->RecordCount()>0){
											
											while ($linha=$resultado->FetchRow()){
												echo "<option  value='".$linha['id']."'>".$linha['name']."</option>";
												
											}
										}
										echo "</select>";	
									
										
									?>



									</div>
									<div class="col-12">
										
										<div class="form-group">
											<label>Concelho<span>*</span></label>
										</div>
										<span id="conselho2">
											<input type="text" value="" class="formRegist" required placeholder="Escolha o distrito primeiro &#8593;" disabled></input>
										</span>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>Data de nascimento<span>*</span></label>
											<input id="dataNasc" name="dataNascimento" type="date" required placeholder="">
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>Tipo de conta<span>*</span></label>
										</div>
										<input type="radio" name="tipoConta" required value="1" checked="checked"> Cliente
										<br><input type="radio" name="tipoConta" required value="2"> Fornecedor
										<br><input type="radio" name="tipoConta" required value="3"> Transportador
									
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>Nif<span>*</span></label>
											<input id="nif" name="nif" type="number" pattern="\d{9}" title="Numero de contribuinte com 9 digitos" required placeholder="">
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>Contacto<span>*</span></label>
											<input id="tlf" name="contacto" type="text" pattern="\d{9}" title="Numero de telefone com 9 digitos" required placeholder="">
										</div>
									</div>		

									<div class="col-12">
										<div class="form-group">
											<label>Mostrar artigos personalizados<span>*</span></label>
										</div>
										<input name="anuncios" type="radio" required checked="checked" value="1"> Sim
										<br><input name="anuncios" type="radio" required value="0"> Não
									</div>	
										
									<div class="col-12">

										<div class="form-group button">
											<label>Ao registar, concorda com os termos e serviços!<span>*</span></label>
											<br>
											<button  class="btn ">Registar</button>

											<span id="atualiza"></span>


								
											
										</div>
									</div>
								</form>

								
							</div>
						</div>
                        <div class="col-lg-4 col-12">
							<div class="single-head">
								<div class="single-info">
									<i class="fa fa-user"></i>
									<h4 class="title">Entrar</h4>
									<div class="form-group button">
										<a href="login.php"><button type="submit" class="btn ">Entrar</button></a>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
        </div>
        
		</div>
			
</body>
	<!-- /End Footer Area -->
 
	<!-- Jquery -->
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
