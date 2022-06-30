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
		$ctrldistrict=new handlerDistrict();	

        include 'classes/transportador.php';
        $ctrlTransportador=new transportador($db);
        
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
                   
			
			    ?>
                <?php 
                    $resultado = $ctrlTransportador->getTodosOsDados($_SESSION['nif']);
                ?>
				<div class="data">

					<h2>Edite os Dados da sua transportadora </h2>
					<h6><em>Apenas altere os dados necessários.</em></h6>
					<hr>
					<form  METHOD="POST" ACTION="ajax_transportador.php" name="registar">
						<input type="hidden" name="codigo" value=2>
						<input type="hidden" name="idTransportador" value=<?php echo $resultado['idTransportador']?>>

						<label><strong><em>Nome da Empresa: &nbsp </em></strong></label>
						<input id="nome" name="nome" type="text" value="<?php echo $resultado['nomeEmpresa']; ?>" required placeholder="">
						<br>
						<label><strong><em>Descrição: &nbsp </em></strong></label>
						<textarea id="nome" name="descricao" required placeholder="" cols="60"><?php echo $resultado['descricao']; ?></textarea>
						<br>


						<label><strong><em>Morada da Sede: &nbsp </em></strong></label>
						<input id="morada" name="morada" value="<?php echo $resultado['morada']; ?>" type="text" required placeholder="">
						<br>

						<label><strong><em>Código Postal: &nbsp </em></strong></label>
						<input id="codigoPostal" name="codigoPostal"  pattern="\d{4}-\d{3}" title="DDDD-DDD" type="text" value="<?php echo $resultado['codigoPostal']; ?>"required placeholder="">
						<br>

						<label><strong><em>Distrito da Sede: &nbsp </em></strong></label>
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

						<label><strong><em>Concelho da Sede: &nbsp </em></strong></label>
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

						<label><strong><em>Contacto: &nbsp </em></strong></label>
						<input id="contacto" name="contacto" type="text" pattern="\d{9}" value="<?php echo $resultado['contato']; ?>" title="Numero de telefone com 9 digitos" required placeholder="">
						<br>

						<label><strong><em>Página Web da Empresa: &nbsp </em></strong></label>
						<input id="webSite" name="webSite" type="text" value="<?php echo $resultado['webSite']; ?>" required placeholder="">
						<br>
						
						<label><strong><em>Garantia de entrega : &nbsp </em></strong></label>
						<input id="garantiaEntregaXHoras" name="garantiaEntregaXHoras" type="number" value="<?php echo $resultado['garantiaEntregaXHoras']; ?>" required placeholder=""><strong><em> horas</em></strong>
						<br>

						<input type="hidden" name="estado" value="<?php echo $resultado['estado']?>">

						<input type="submit" value="Guardar" class="btnUser">

						<span id="atualiza"></span><br>
			
					</form>
					<hr>
					<div class="opções">
						<a href="mostrarDadosTransportador.php"><button class="btnUser">Voltar </button></a>
					</div>
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
