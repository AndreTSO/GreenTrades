<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Registar</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/loginOficial.css">


	<?php 
		include("includes/config.php");
		
		include('classes/district.php');
		$ctrldistrict=new handlerDistrict();	

	?>


	<script>

		function obtemDistrito(){
				let codigo = $('#distrito option:selected').val();
				$.ajax({
				type: "POST",
				url: 'ajax_district.php',
				data: {distrito: codigo, registo: 1},
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
		

	</script>




</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="images/logo.png" alt="bootstrap 4 login page">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Registar</h4>

							<?php
								include ('showMsg.php');
							?>

							<form method="POST" class="my-login-validation" action="ajax_user.php" name="registo">
								<input type="hidden" name="codigo" value=2>
								<div class="form-group">
									<label for="name">Nome:</label>
									<input id="name" type="text" class="form-control" name="nome" required autofocus>
									<div class="invalid-feedback">
										Qual o seu nome?
									</div>
								</div>

								<div class="form-group">
									<label for="name">Sobre nome:</label>
									<input id="sobreNome" type="text" class="form-control" name="sobreNome" required>
									<div class="invalid-feedback">
										Qual o seu sobrenome?
									</div>
								</div>
										
								<div class="form-group">
									<label for="name">Genero:</label>
									<select name = 'genero' id = 'genero' required class="form-control">									
										<option required value='M' selected >Masculino</option>
										<option required value='F'>Feminino</option>
										<option required value='O'>Não Declarar</option>
									</select>
									<div class="invalid-feedback">
										Qual o seu Genero?
									</div>
								</div>

								<div class="form-group">
									<label for="email">Endereço de email</label>
									<input id="email" type="email" class="form-control" name="email" required>
									<div class="invalid-feedback">
										O seu endereço de email é invalido!
									</div>
								</div>

								<div class="form-group">
									<label for="password">Password</label>
									<input id="senha1" type="password" class="form-control" name="senha" required data-eye  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="8 Digitos Min 1 numero, Min 1 Maiuscula, min 1 Minuscula">
									<div class="invalid-feedback">
										Password is required
									</div>
								</div>

								<div class="form-group">
									<label for="password">Repetir Password</label>
									<input id="senha2" type="password" class="form-control" name="senha2" onchange="pw()" required data-eye >
									<div class="invalid-feedback">
										Password is required
									</div>
								</div>
								
								<div class="form-group">
									<label for="name">Morada:</label>
									<input id="morada" type="text" class="form-control" name="morada" required>
									<div class="invalid-feedback">
										Qual a sua morada?
									</div>
								</div>

								<div class="form-group">
									<label for="name">Codigo Postal:</label>
									<input id="codPostal" type="text" class="form-control" name="codigoPostal" required pattern="\d{4}-\d{3}" title="DDDD-DDD" data-eye>
									<div class="invalid-feedback">
										Qual o seu codigo postal DDDD-DDD?
									</div>
								</div>

								
								<div class="form-group">
									<label for="name">Distrito:</label>
									<select name = 'distrito' id = 'distrito' onChange='obtemDistrito()' required class="form-control">
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
									
									<div class="invalid-feedback">
										Qual o seu distrito?
									</div>
								</div>

								



								<div class="form-group">
									<label for="name">Concelho:</label>
									<span id="conselho2">
										<input id="concelho" type="text" class="form-control" required placeholder="Escolha o distrito primeiro &#8593;" disabled>
									</span>
									<div class="invalid-feedback">
										Qual o seu Concelho?
									</div>
								</div>


								<div class="form-group">
									<label for="name">Data de nascimento:</label>
									<input id="dataNasc" name="dataNascimento" type="date" required class="form-control">
									<div class="invalid-feedback">
										Qual a sua data de nascimento?
									</div>
								</div>


								<div class="form-group">
									<label for="name">Tipo de Conta:</label>
									<select name = 'tipoConta' id = 'tipoConta' required class="form-control">									
										<option value='1' selected >Cliente</option>
										<option value='2'>Fornecedor</option>
										<option value='3'>Transportador</option>
									</select>
							
									
									<div class="invalid-feedback">
										Qual o seu propósito na nossa plataforma?
									</div>
								</div>

								

								<div class="form-group">
									<label for="name">Nif:</label>
									<input  name="nif" type="number" pattern="\d{9}" title="Numero de contribuinte com 9 digitos" required  class="form-control">
									<div class="invalid-feedback">
										Qual o seu nº de identificação fiscal?
									</div>
								</div>

								<div class="form-group">
									<label for="name">Telefone:</label>
									<input  name="contacto" type="number" pattern="\d{9}" title="Numero de telefone com 9 digitos" required  class="form-control">
									<div class="invalid-feedback">
										Qual o seu nº de telefone?
									</div>
								</div>

								<div class="form-group">
									<label for="name">Gostaria que lhe apresentassemos artigos personalizados:</label>
									<select name = 'anuncios'  required class="form-control">									
										<option value='1' selected >Sim</option>
										<option value='0'>Não</option>
										
									</select>
									
									<div class="invalid-feedback">
										Gostaria que lhe apresentassemos artigos personalizados
									</div>
								</div>

								<div class="form-group">
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="agree" id="agree" class="custom-control-input" required="">
										<label for="agree" class="custom-control-label">Eu concordo com os <a href="#">Termos e condiçoes</a></label>
										<div class="invalid-feedback">
											Eu aceito os termos e condições!
										</div>
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block" style="background-color: #6FB863;">
										Registar
									</button>
								</div>
								<div class="mt-4 text-center">
									Já tem conta? <a href="login.php">Entrar</a>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; 2017 &mdash; GreenTrades
					</div>
				</div>
			</div>
		</div>
	</section>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	

	<script src="js/loginOficial.js"></script>
	<script src="js/jquery-3.6.0.js"></script>
</body>
</html>