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
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<!-- JavaScript Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
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



	include 'classes/district.php';
	$ctrldistrict = new handlerDistrict();

	include 'classes/user.php';
	$ctrlUser = new user($db);

	if (!$ctrlUser->islogged())
		header('Location: index.php');
	//EJECT


	?>


	<script>
		function obtemDistrito() {
			let codigo = $('#distrito option:selected').val();
			$.ajax({
				type: "POST",
				url: 'ajax_district.php',
				data: {
					distrito: codigo
				},
				dataType: "html",
				success: function(data) {
					if (data) {
						document.getElementById('conselho2').innerHTML = data;
					}
				}
			});
		}

		function pw() {
			registo.senha2.setAttribute('pattern', registar.senha.value);
		}

		function registar() {
			//EXEMPLO DE AJAX -> var telefone = ($("#telefone").val())
			let senha = document.getElementById("senha1").value;
			let senha2 = document.getElementById("senha2").value;

			if (senha == senha2) {
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
						concelho: concelho,
						dataNascimento: dataNasc,
						tipoConta: tipoConta,
						contacto: tlf,
						anuncios: anuncios,
					},
					dataType: "html",
					success: function(data) {
						if (data) {

							document.getElementById('atualiza').innerHTML = data;

						} else {
							alert("Erro no Registo")

						}
					}
				});

			} else {
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
				<section class="mb-4">
					<?php

					include 'showMsg.php';
					//$nif, $nome, $sobreNome, $genero, $email, $morada, $codigoPostal, $distrito, $concelho, $dataNascimento,  $contacto, $anuncios, $senha=""

					?>
					<?php
					$resultado = $ctrlUser->getTodosOsDados($_SESSION['nif']);
					?>

					<div class="data">
						<form class="well form-horizontal" METHOD="POST" ACTION="ajax_user.php" name="registar">
							<div class="contentTitle">
								<h2 class='welcomemsg h1-responsive font-weight-bold text-center my-4'>Edite os seus Dados</h2>
								<hr class="middle">
							</div>
							<h6 class="text-center w-responsive mx-auto mb-5">Apenas altere os dados necessários.</h6>
							<hr>
							<center>
								<div class="">
									<div class="">
										<div class="form1">
											<input type="hidden" name="codigo" value=5>
											<!--Grid column-->

											<div class="form-group">
												<strong><label for="name" class=""><em>Nome: </em></label></strong>

											</div>
											<div class="input-group">
												<center>
													<input class="formInput" id="nome" name="nome" type="text" value="<?php echo $resultado['nome']; ?>" required placeholder="">
												</center>
											</div>
										</div>

										<div class="form1">
											<div class="form-group">
												<strong><label for="surname" class=""><em>Sobrenome: </em></label></strong>

											</div>
											<div class="input-group">
												<center>
													<input class="formInput" id="sobreNome" name="sobreNome" value="<?php echo $resultado['sobreNome']; ?>" type="text" required placeholder="">
												</center>
											</div>
										</div>
										
										<div class="form1">
											<div class="form-group">
												<strong><label for="gender" class=""><em>Género: </em></label></strong>

											</div>
											<div class="input-group">
												<center>
													<select name="genero" class="formInput">
														<option name="genero" required value="M" <?php echo ($resultado['genero'] == 'M' ? "checked" : ""); ?>> Masculino
														<option name="genero" required value="F" <?php echo ($resultado['genero'] == 'F' ? "checked" : ""); ?>> Feminino
														<option name="genero" required value="O" <?php echo ($resultado['genero'] == 'O' ? "checked" : ""); ?>> Prefiro não dizer
													</select>
												</center>
											</div>
										</div>
										
										<div class="form1">
											<div class="form-group">
												<strong><label for="" class="">Nº de Contribuinte:</label></strong>

											</div>
											<div class="input-group">
												<center>
													<input class="formInput inputGroupContainer" id="nif" name="nif" type="number" value="<?php echo $resultado['nif']; ?>" pattern="\d{9}" title="Numero de contribuinte com 9 digitos" required placeholder="">
												</center>
											</div>
										</div>
										
										<div class="form1">
											<div class="form-group">
												<strong><label for="" class=""><em>Data Nascimento: </em></label></strong>

											</div>
											<div class="input-group">
												<center>
													<input class="formInput" id="dataNascimento" name="dataNascimento" type="date" value="<?php echo $resultado['dataNascimento']; ?>" required placeholder="">
												</center>
											</div>
										</div>
										<hr>
										<div class="form1">
											<div class="form-group">
												<strong><label for="" class=""><em>Telefone: </em></label></strong>

											</div>
											<div class="input-group">
												<center>
													<input class="formInput" id="tlf" name="contacto" type="text" pattern="\d{9}" value="<?php echo $resultado['contato']; ?>" title="Numero de telefone com 9 digitos" required placeholder="">
												</center>
											</div>


										</div>
										
										<div class="form1">
											<div class="form-group">
												<strong><label for="" class=""><em>Email: </em></label></strong>

											</div>
											<div class="input-group">
												<center>
													<input class="formInput" id="email" name="email" type="email" value="<?php echo $resultado['email']; ?>" required placeholder="">
												</center>
											</div>


										</div>
										
										<div class="form1">
											<div class="form-group">
												<strong><label for="" class=""><em>Morada: </em></label></strong>

											</div>
											<div class="input-group">
												<center>
													<input class="formInput" id="morada" name="morada" type="text" value="<?php echo $resultado['morada']; ?>" required placeholder="">
												</center>
											</div>


										</div>
										<hr>
										<div class="form1">
											<div class="form-group">
												<strong><label for="" class=""><em>Código Postal: </em></label></strong>

											</div>
											<div class="input-group">
												<center>
													<input class="formInput" id="codPostal" name="codigoPostal" pattern="\d{4}-\d{3}" title="DDDD-DDD" type="text" value="<?php echo $resultado['codigoPostal']; ?>" required placeholder="">
												</center>
											</div>
										</div>
										
										<div class="form1">
											<div class="form-group">
												<strong><label for="" class=""><em>Distrito: </em></label></strong>

											</div>
											<div class="input-group">
												<center>
													<select name='distrito' id='distrito' onChange='obtemDistrito()' class='formInput' required>
														<?php
														$resultado2 = $ctrldistrict->getDistrict($db);

														echo "<option value=''>Distrito</option>";
														if ($resultado2 && $resultado2->RecordCount() > 0) {

															while ($linha = $resultado2->FetchRow()) {
																echo "<option " . ($resultado['distrito'] == $linha['id'] ? "selected" : "") . " value='" . $linha['id'] . "'>" . $linha['name'] . "</option>";
															}
														}
														?>
													</select>
												</center>
											</div>

										</div>
										
										<div class="form1">
											<div class="form-group">
												<strong><label for="" class=""><em>Concelho: </em></label></strong>

											</div>
											<div class="input-group">
												<center>
													<span id="conselho2">
														<select name='concelho' id='concelho' class='formInput' required>
															<?php
															$resultado2 = $ctrldistrict->getConcelhoByDistrictId($db, $resultado['distrito']);

															echo "<option value=''>Concelho</option>";
															if ($resultado2 && $resultado2->RecordCount() > 0) {

																while ($linha = $resultado2->FetchRow()) {
																	echo "<option " . ($resultado['concelho'] == $linha['id'] ? "selected" : "") . " value='" . $linha['id'] . "'>" . $linha['name'] . "</option>";
																}
															}
															?>
														</select>
													</span>

												</center>
											</div>
										</div>
										<hr>
										<div class="form1">
											<div class="form-group">
												<strong><label for="" class=""><em>Mostrar artigos personalizados: </em></label></strong>

											</div>
											<div class="input-group">
												<center>
													<select name="anuncios" class="formInput">
														<option name="anuncios" required <?php echo ($resultado['anuncios'] == '1' ? "checked" : ""); ?> value="1"> Sim
														<option name="anuncios" required <?php echo ($resultado['anuncios'] == '0' ? "checked" : ""); ?> value="0"> Não

													</select>
												</center>
											</div>
											<br>
										</div>
										<hr>
										
										<div class="">
											<center>
												<strong><label for="" class=""><em>Insira a password atual para guardar as alterações feitas: </em></label></strong>

											</center>
										</div>
										<center>
											<input class="formInput" name="passAntiga" type="password" required placeholder="Password atual">

										</center>
										<br>

										
										<center>
											
											<input type="submit" value="Guardar" class="btnUser">
											<input type="hidden" required value="<?php echo $resultado['password']; ?>">
											<span id="atualiza"></span>
										</center>
									</div>
								</div>
							</center>
						</form>
						<hr>
						<div class="opções">
							<a href="userAccount.php"><button class="btnUser">Voltar </button></a>
						</div>
					</div>
				</section>
				
			</div><!-- /.container -->
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
<script src="js/forms.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.0.js"></script>
<script src="js/jquery-ui.min.js"></script>