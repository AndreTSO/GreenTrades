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
        if(!isset($_POST['idVeiculo'])){
            header('Location: landpage.php');
        }

		

		include'classes/district.php';
		$ctrldistrict=new handlerDistrict();	

        include 'classes/armazem.php';
        $ctrlArmazem=new armazem($db);

        include 'classes/veiculos.php';
        $ctrlVeiculo=new veiculo($db);
        
		include 'classes/baseTransportador.php';
        $ctrlbaseTransportador=new baseTransportador($db);
        
        include 'classes/user.php';
        $ctrlUser=new user($db);

        if (!$ctrlUser->islogged())
	        header('Location: index.php');
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
                    $resultado = $ctrlVeiculo->getTodosOsDados($_POST['idVeiculo']);
					if($resultado['estado']==20){
						echo "<h2>Editar Veiculo</h2><br>";
						echo "Este veiculo esta atribuido a um serviço!<br>";
						echo "Não pode ser alterado enquanto esta em serviço!<br>";?>
						<form ACTION="mostrarVeiculo.php" METHOD ="POST">
                        <input type="hidden" value="<?php echo $_POST['idVeiculo'] ?>" name="idVeiculo">
                        <input type="submit" value="Voltar" class="btnUser">
                    </form>
					<?php
					}else{
                ?>

                <h2>Editar Veiculo</h2>
				<h6><em>Apenas altere os dados necessários.</em></h6>
				<hr>
			    <form  METHOD="POST" ACTION="ajax_transportador.php">
				    <input type="hidden" name="codigo" value=6>
				    <input type="hidden" name="idVeiculo" value=<?php echo $resultado['idVeiculo']?>>
					<label><strong><em>Tipo de Veiculo: &nbsp </em></strong></label>
                    	<select name="tipoVeiculo">
				        	<option required value="0" <?php echo ($resultado['tipoVeiculo']==0 ?"selected":""); ?> > Carro
				        	<option required value="1" <?php echo ($resultado['tipoVeiculo']==1 ?"selected":""); ?> > Mota
							<option required value="2" <?php echo ($resultado['tipoVeiculo']==2 ?"selected":""); ?> > Camião
						</select>
					<br>
					<label><strong><em>Ano do veiculo:&nbsp</em></strong></label>
                    <input name="ano" type="month" name="bday-month" value="<?php echo $resultado['anoDoVeiculo']?>"><br>

					<label><strong><em>Matricula:</em></strong></label>
					<input type="text" name="matricula" required title="DD-DD-DD" value="<?php echo $resultado['matricula']?>"><br>

					<label><strong><em>Marca:</em></strong></label>
					<input type="text" name="marca" value="<?php echo $resultado['marca']?>" required><br>

					<label><strong><em>Consumo Por 100km:</em></strong></label>
					<input type="number" name="consumo" value="<?php echo $resultado['consumoPorCemKm']?>" required><br>

					<label><strong><em>Tipo de Combustivel:</em></strong></label>
					<select name="combustivel" required>
                        <option required value="gasolina" <?php echo ($resultado['tipoDeCombustivel']=='gasolina' ?"selected":""); ?>> Gasolina
                        <option required value="gasoleo" <?php echo ($resultado['tipoDeCombustivel']=='gasoleo' ?"selected":""); ?>> Gasoleo
                        <option required value="diesel" <?php echo ($resultado['tipoDeCombustivel']=='diesel' ?"selected":""); ?>> Diesel
                    </select><br>

					<label><strong><em>Carga Maxima(Kg):</em></strong></label>
					<input type="number" name="carga" value="<?php echo $resultado['cargaMaxima']?>" required><br>

					<label><strong><em>Frigorifico:</em></strong></label>
					<select name="frigorifico" required>
                        <option required value="0" <?php echo ($resultado['frigorifico']=='0' ?"selected":""); ?>> Sim
                        <option required value="1" <?php echo ($resultado['frigorifico']=='1' ?"selected":""); ?>> Não
                    </select><br>

					<label><strong><em>Estado:</em></strong></label>
					<select name="estado" required>
                        <option required value="22" <?php echo ($resultado['estado']==22 ?"selected":""); ?>> Disponivel
                        <option required value="21" <?php echo ($resultado['estado']==21 ?"selected":""); ?>> Avariado
                    </select><br>
					<hr>

					<h2>Atribuir a uma base</h2>
                    <label><strong><em>Base:&nbsp</em></strong></label>
                    <select name = 'idBaseTransportador' id = 'categoriaPAPI' onChange='obtemSubCategoria()' required >
                    <?php
                        $resultado2=$ctrlbaseTransportador->getTodosOsDados($_SESSION['nif']);
                    
                        foreach($resultado2 as $base){
                            echo "<option value='".$base['idBase']."'".($resultado['idBaseTransportador']==$base['idBase'] ?'selected':'').">".$base['nome']."</option>";
                        }
                        echo "</select>";
				    ?><br>
                    <hr>

					<input type="submit" value="Guardar" class="btnUser">
				
				</form>
				<hr>
				<div class="opções">
					<form ACTION="mostrarVeiculo.php" METHOD ="POST">
                        <input type="hidden" value="<?php echo $_POST['idVeiculo'] ?>" name="idVeiculo">
                        <input type="submit" value="Voltar" class="btnUser">
                    </form>
				</div>
				<?php
					}
				?>
			</div>
			
			
        </div>

	    <?php

        	include("includes/footer.php");
    
    	?>
	</div>
</body>

	<!-- /End Footer Area -->
 
	<!-- Jquery -->
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
