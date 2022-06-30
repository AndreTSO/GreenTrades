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

    <link rel="stylesheet" href="css/twitter.css">
	<?php
	require_once("includes/config.php");
	require_once("classes/lib.php");
	require_once('classes/district.php');
	require_once 'classes/user.php';
	require_once 'classes/produto.php';

	$ctrldistrict = new handlerDistrict();
	$ctrllib = new lib($db);
	$ctrlUser = new user($db);
	$ctrlProduto = new produto($db);

	if (!$ctrlUser->islogged())
		header('Location: RAW_index.php');
	//EJECT
	if (isset($_SESSION['nif'])) {
		if (!$ctrlUser->isAuthorized(2, $_SESSION['nif'])) {
			header('Location: RAW_index.php');
		}
	}

	if (isset($_POST['codigo']) && $_POST['codigo'] == 3) {


		$resposta =  $ctrlProduto->createProduto(
			$_POST['idFornecedor'],
			$_POST['nome'],
			$_POST['descricao'],
			$_POST['tipo'],
			$_POST['tags'],
			$_POST['precoSemIva'],
			$_POST['recursosConsumidos'],
			$_POST['custoManutencao'],
			$_POST['estado'],
			$_POST['tipoIVA'],
			$_POST['modoDeVenda'],
			$_POST['pesoPorVenda'],
			$_POST['arquivado'],
			$_POST['notasInternasAoFornecedor'],
			$_POST['dataCriacaoTimeStamp'],
			(isset($_POST['validade']) ? $_POST['validade'] : NULL)
		);

		if ($resposta != false) {
			$lastID = $resposta;
			$_GET['status'] = 19;
		} else {
			$_GET['status'] = 20;
		}
	}


	if ((isset($_POST['operacao'])) && $_POST['operacao'] == 12) {
		// ESTAS A RECEBER AS IMAGENS :)	
		// idProduto
		// Capa , foto(ID)
		$nomeFinal = "Art" . $_POST['idProduto'] . "ID" . (0) . ".png";
		adicionaImagem($_FILES['capa'], $nomeFinal, $_POST['idProduto'], $ctrlProduto);

		$valooor = $_POST['nfotosEscolhidas'];
		for ($i = 1; $i <= $valooor; $i++) {

			$nomeFinal = "Art" . $_POST['idProduto'] . "ID" . $i . ".png";

			adicionaImagem($_FILES['foto' . $i], $nomeFinal, $_POST['idProduto'], $ctrlProduto);
		}
	}

	function adicionaImagem($_FILE, $nomeFinal, $idProduto, $ctrlProduto)
	{
		$target_dir = "images/IMG_PRODUTOS/";


		if ($ctrlProduto->getImgByID($idProduto, $nomeFinal)) { //SE existir a foto .. elimina a
			$ctrlProduto->remImg($idProduto, $nomeFinal);
			unlink($target_dir . $nomeFinal);
		}
		$ctrlProduto->addImg($idProduto, $nomeFinal);



		$target_file = $target_dir . basename($_FILE["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image

		$check = getimagesize($_FILE["tmp_name"]);
		if ($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}

		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILE["size"] > 1000000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
		} else {
			$_FILE["name"] = $nomeFinal;
			$target_file = $target_dir . basename($_FILE["name"]);
			if (move_uploaded_file($_FILE["tmp_name"], $target_file)) {
				echo "The file " . basename($_FILE["name"]) . " has been uploaded. <br>";
			} else {
				echo "Sorry, there was an error uploading your file.  <br>";
			}
		}
	}


	?>
	<script>
		let contador = 0;

		function addimg() {
			$('#remSpan').show();
			if (contador == 9) {
				$('#appendFoto').attr("disabled", true);
			}
			contador += 1;
			$("#maisFotos").append("<span id='spanFoto" + contador + "'> Imagem: " + contador + " <input type='file' id='foto" + contador + "' name='foto" + contador + "' required> <br></span>");


			atualizadornfotosEscolhidas();
		}

		function remFoto() {



			$("#spanFoto" + contador).remove();
			contador -= 1;

			if (contador < 10) {
				$('#appendFoto').attr("disabled", false);
			}
			if (contador == 0) {
				$('#remSpan').hide();
			}


			atualizadornfotosEscolhidas();

		}

		function atualizadornfotosEscolhidas() {

			$('#update').val(contador);
		}
	</script>
</head>


<body>
	<div class="body">
		<?php
		include 'topo.php';
		?>
		<div class="page">
			<?php
			include 'showMsg.php';
			?>
			<div class="content">
				<h1>Inserir imagens</h1>
				<button class="btnUser" id="appendFoto" onclick="addimg();">Adicionar mais fotos</button> <span id='remSpan' hidden><button class="btnUser" type='button' onclick='remFoto()'>Remover</button> </span>
				<form ACTION="inserirImagem.php" METHOD="POST" enctype="multipart/form-data">
					<input type="hidden" name="operacao" value=12>

					<input type="hidden" name="idProduto" value="<?php echo $lastID; ?>">
					<br>
					Imagem Capa:   <input type="file" name="capa" required><br>
					<br>
					<span id="maisFotos">



					</span><br><br>

					<input type="hidden" id="update" name="nfotosEscolhidas" value="0">
					<input class="btnUser" type="submit" value="Guardar Fotos" \>
				</form>
				<div class="opções">
						<a href="showArmazem.php"><button class="btnUser">Voltar </button></a>
				</div>    
			</div>
		</div>
		<?php
		include 'includes/footer.php';
		?>
	</div>






</body>


<!-- Jquery -->
<script src="js/jquery-3.6.0.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.0.js"></script>
<script src="js/jquery-ui.min.js"></script>