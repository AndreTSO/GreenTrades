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
							
							
								
										<?php
										$resultado = $ctrlUser->getTodosOsDados($_SESSION['nif']);
										echo '<div class="container rounded bg-white mt-5 mb-5">
                        <div class="row">
                            <div class="col-md-3 border-right">
                                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold">' . $resultado['nome'] . '</span><span class="text-black-50">' . $resultado['email'] . '</span><span> </span></div>
                            </div>
                            <div class="col-md-5 border-right">
                                <div class="p-3 py-5">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="text-right">Perfil</h4>
                                    </div>
                                    
                                    
                                    <div class="row mt-2">
                                        <div class="col-md-6"><label class="labels"><strong><em>Nome:  &nbsp&nbsp</em></strong></label> <input type="text" class="form-control" placeholder=' . $resultado['nome'] . ' value=""></div>
                                        <div class="col-md-6"><label class="labels"><strong><em>Sobrenome:  &nbsp&nbsp</em></strong></label><input type="text" class="form-control" placeholder=' . $resultado['sobreNome'] . ' value=""></div>
                                        <div class="col-md-6"><label class="labels"><strong><em>Género:  &nbsp&nbsp</em></strong></label><input type="text" class="form-control" placeholder=' . $resultado['genero'] . ' value=""></div>
                                        <div class="col-md-6"><label class="labels"><strong><em>Nascimento:  &nbsp&nbsp</em></strong></label><input type="text" class="form-control" placeholder=' . $resultado['dataNascimento'] . ' value=""></div>
                                    </div>
                                    <hr>
                                    <div class="row mt-2">
                                        <div class="col-md-6"><label class="labels"><strong><em>Telefone: &nbsp&nbsp </em></strong></label> <input type="text" class="form-control" placeholder=' . $resultado['contato'] . ' value=""></div>
                                        <div class="col-md-6"><label class="labels"><strong><em>Nº Contribuinte:  &nbsp&nbsp</em></strong></label><input type="text" class="form-control" placeholder=' . $resultado['nif'] . ' value=""></div>
                                        <div class="col-md-6"><label class="labels"><strong><em>Morada: &nbsp&nbsp </em></strong></label><input type="text" class="form-control" placeholder=' . $resultado['morada'] . ' value=""> </div>
                                        <div class="col-md-6"><label class="labels"><strong><em>Código Postal:  &nbsp&nbsp</em></strong></label><input type="text" class="form-control" placeholder=' . $resultado['codigoPostal'] . ' value=""></div>
                                        <div class="col-md-6"><label class="labels"><strong><em>Distrito:  &nbsp&nbsp</em></strong></label><input type="text" class="form-control" placeholder=' . $ctrldistrict->getDistrictById($db, $resultado['distrito']). ' value=""></div>
                                        <div class="col-md-6"><label class="labels"><strong><em>Concelho:  &nbsp&nbsp</em></strong></label><input type="text" class="form-control" placeholder=' . $ctrldistrict->getConcelhoById($db, $resultado['concelho']) . ' value=""></div>
                                        <div class="col-md-8"><label class="labels"><strong><em>Email:  &nbsp&nbsp</em></strong></label><input type="text" class="form-control" placeholder=' . $resultado['email'] . ' value=""></div>
                                    </div>
                                    
                                    ';
										?>
									</div>
								</div>
								<div class="">
				<center>
					<strong><label for="" class=""><em>Insira a password atual para guardar as alterações feitas: </em></label></strong>

				</center>
			</div>
			<center>
				<input class="formInput" name="passAntiga" type="password" required placeholder="Password atual">

			</center>

					</div>
			</div>

			
			<br>



			<center>

				<input type="submit" value="Guardar" class="btnUser">
				<input type="hidden" required value="<?php echo $resultado['password']; ?>">
				<span id="atualiza"></span>
			</center>
		</div>
	</div>
	
	</form>
	<hr>
	<center>
	<div class="opções">
		<a href="userAccount.php"><button class="btnUser">Voltar </button></a>
	</div>
	</center>
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