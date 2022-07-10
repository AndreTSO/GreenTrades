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



	include 'classes/district.php';
	$ctrldistrict = new handlerDistrict();

	include 'classes/fornecedor.php';
	$ctrlForncedor = new fornecedor($db);

	include 'classes/user.php';
	$ctrlUser = new user($db);

	if (!$ctrlUser->islogged())
		header('Location: RAW_index.php');
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
	</script>


</head>

<body>
	<div class="body">
		<?php
		include 'topo.php';

		?>
		<div class="page">

			<div class="content">
				<div class="contentTitle">
					<h2>Edite os Dados da sua Empresa </h2>
					<hr class="middle">
				</div>


				<?php

				include 'showMsg.php';
				//$nif, $nome, $sobreNome, $genero, $email, $morada, $codigoPostal, $distrito, $concelho, $dataNascimento,  $contacto, $anuncios, $senha=""

				?>
				<?php
				$resultado = $ctrlForncedor->getTodosOsDados($_SESSION['nif']);
				?>
				<div class="data">


					<center><h6><em>Apenas altere os dados necessários.</em></h6></center>
					
					<form METHOD="POST" ACTION="ajax_fornecedor.php" name="registar">
						<input type="hidden" name="codigo" value=4>
						<input type="hidden" name="idFornecedor" value=<?php echo $resultado['idFornecedor'] ?>>

						<!-- <label><strong><em>Nome da Empresa: &nbsp </em></strong></label>
						<input id="nome" name="nome" type="text" value="<?php echo $resultado['nomeEmpresa']; ?>" required placeholder="">
						<br>

						<label><strong><em>Descrição: &nbsp </em></strong></label>
						<input id="descricao" name="descricao" value="<?php echo $resultado['descricao']; ?>" type="text" required placeholder="">
						<br>

						<label><strong><em>Morada da Sede: &nbsp </em></strong></label>
						<input id="morada" class="form-control" name="morada" value="'. $resultado['morada'].'" type="text" required placeholder="">
						<br>

						<label><strong><em>Código Postal: &nbsp </em></strong></label>
						<input id="codigoPostal" class="form-control" name="codigoPostal" pattern="\d{4}-\d{3}" title="DDDD-DDD" type="text" value="'.$resultado['codigoPostal'].'" required placeholder="">
						<br>

						<label><strong><em>Distrito da Sede: &nbsp </em></strong></label>
						<select name='distrito' class="form-control" id='distrito' onChange='obtemDistrito()' required>
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
						<br>

						<label><strong><em>Concelho da Sede: &nbsp </em></strong></label>
						<span id="conselho2">
							<select name='concelho' id='concelho' required>
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
						<br>

						<label><strong><em>Contacto: &nbsp </em></strong></label>
						<input id="contacto" name="contacto" class="form-control" type="text" pattern="\d{9}" value="'. $resultado['contacto'].'" title="Numero de telefone com 9 digitos" required >
						<br>

						<label><strong><em>Página Web da Empresa: &nbsp </em></strong></label>
						<input id="webSite" class="form-control" name="webSite" type="text" value="'.$resultado['webSite'].'" required placeholder="">
						<br>

						<label><strong><em>Período de Cancelamento: &nbsp </em></strong></label>
						<input id="PeriodoXDiasCancelar" class="form-control" name="PeriodoXDiasCancelar" type="number" value="'.$resultado['PeriodoXDiasCancelar'].'" required placeholder=""> dias
						<br>

						<input type="hidden" name="poluicaoGerada" value="<?php echo $resultado['poluicaoGerada'] ?>">
						<input type="hidden" name="recursosConsumidos" value="<?php echo $resultado['recursosConsumidos'] ?>">
						<input type="hidden" name="estado" value="<?php echo $resultado['estado'] ?>"> -->
						<?php
						// $resultado = $ctrlUser->getTodosOsDados($_SESSION['nif']);
						echo '<div class="container rounded bg-white mt-5 mb-5">
                        <div class="row">
                            <div class="col-md-4 border-right">
                                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><span class="font-weight-bold"></span><span class="text-black-50"></span><span> </span></div>
                            </div>
                            <div class="col-md-5 border-right">
                                <div class="p-3 py-5">
                                    
                                    
                                    <div class="row mt-1">
                                        <div class="col-md-12"><label class="labels"><strong><em>Nome da Empresa:&nbsp</em></strong></label> <input id="nome" name="nome" class="form-control" type="text" value="' .$resultado['nomeEmpresa']. '" required placeholder=""></div>
                                        <br><div class="col-md-12"><label class="labels"><strong><em>Página da Empresa:  &nbsp&nbsp</em></strong></label><input id="webSite" class="form-control" name="webSite" type="text" value="'.$resultado['webSite'].'" required placeholder=""></div>
                                        <br><div class="col-md-12"><label class="labels"><strong><em>Descrição  &nbsp&nbsp</em></strong></label><input id="descricao" class="form-control" name="descricao" value="'.$resultado['descricao'].'" type="text" required placeholder=""></div>
                                        <br><div class="col-md-12"><label class="labels"><strong><em>Contacto:  &nbsp&nbsp</em></strong></label><input id="contacto" name="contacto" class="form-control" type="text" pattern="\d{9}" value="'. $resultado['contacto'].'" title="Numero de telefone com 9 digitos" required ></div>
                                    </div>
                                    <hr>
                                    <div class="row mt-2">
										<br><div class="col-md-12"><label class="labels"><strong><em>Morada da Sede: &nbsp&nbsp </em></strong></label> <input id="morada" class="form-control" name="morada" value="'. $resultado['morada'].'" type="text" required placeholder=""></div>
										<br><div class="col-md-12"><label class="labels"><strong><em>Distrito da Sede:  &nbsp&nbsp</em></strong></label><select name="distrito" class="form-control" id="distrito" onChange="obtemDistrito()" required>';
										
										$resultado2 = $ctrldistrict->getDistrict($db);
			
										echo "<option value=''>Distrito</option>";
										if ($resultado2 && $resultado2->RecordCount() > 0) {
			
											while ($linha = $resultado2->FetchRow()) {
												echo "<option " . ($resultado['distrito'] == $linha['id'] ? "selected" : "") . " value='" . $linha['id'] . "'>" . $linha['name'] . "</option>";
											}
										}
										
									echo '</select>
										</div>
                                        <br><div class="col-md-12"><label class="labels"><strong><em>Concelho da Sede: &nbsp&nbsp </em></strong></label><span id="conselho2">
										<select name="concelho" class="form-control" id="concelho" required>';
											
											$resultado2 = $ctrldistrict->getConcelhoByDistrictId($db, $resultado['distrito']);
			
											echo "<option value=''>Concelho</option>";
											if ($resultado2 && $resultado2->RecordCount() > 0) {
			
												while ($linha = $resultado2->FetchRow()) {
													echo "<option " . ($resultado['concelho'] == $linha['id'] ? "selected" : "") . " value='" . $linha['id'] . "'>" . $linha['name'] . "</option>";
												}
											}
											
										echo'</select>
										</span> </div>
                                        <br><div class="col-md-12"><label class="labels"><strong><em>Código Postal:  &nbsp&nbsp</em></strong></label><input id="codigoPostal" class="form-control" name="codigoPostal" pattern="\d{4}-\d{3}" title="DDDD-DDD" type="text" value="'.$resultado['codigoPostal'].'" required placeholder=""></div>
                                        <br><div class="col-md-12"><label class="labels"><strong><em>Aceita devoluções até:  &nbsp&nbsp</em></strong></label><input id="PeriodoXDiasCancelar" class="form-control" name="PeriodoXDiasCancelar" type="number" value="'.$resultado['PeriodoXDiasCancelar'].'" required placeholder=""><em> dias úteis</em></div>
                                    </div>
                                    
                                    <input type="hidden" name="poluicaoGerada" value="'.$resultado["poluicaoGerada"].'">
									<input type="hidden" name="recursosConsumidos" value="'.$resultado["recursosConsumidos"].'">
									<input type="hidden" name="estado" value="'.$resultado["estado"].'">
                                    ';
						?>
				</div>
			</div>

		</div>
	</div>
	<center>
	<input type="submit" value="Guardar" class="btnUser">

	<span id="atualiza"></span><br>

	</form>
	<hr>
	<div class="opções">
		<a href="mostrarDadosEmpresa.php"><button class="btnUser">Voltar </button></a>
	</div>
	</center>
	</div>
	<br>

	</div>
	</div>

	<?php

	/* include("includes/footer.php")  */

	?>
	</div>
</body>

<!-- /End Footer Area -->

<!-- Jquery -->
<script src="js/jquery-3.6.0.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.0.js"></script>
<script src="js/jquery-ui.min.js"></script>