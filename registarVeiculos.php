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
    <link rel="stylesheet" href="css/botoes.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/themify-icons.css">

	<?php 
		include("includes/config.php");
		require_once("classes/lib.php");
		require_once('classes/district.php');
        require_once 'classes/user.php';
        require_once 'classes/baseTransportador.php';
   

		$ctrldistrict=new handlerDistrict();	
		$ctrllib=new lib($db);	
        $ctrlUser=new user($db);
        $ctrlbaseTransportador= new baseTransportador($db);


        if (!$ctrlUser->islogged())
	        header('Location: index.php');
            //EJECT
        if (isset($_SESSION['nif']) ){
            if (!$ctrlUser->isAuthorized(3,$_SESSION['nif'])){
                header('Location: index.php');
            }
        }



	?>
<script>



        function obtemSubCategoria(){
				let codigo = $('#categoriaPAPI option:selected').val();
                
				$.ajax({
				type: "POST",
				url: 'ajax_categoria.php',
				data: {categoriaPAI: codigo},
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
                <h1>Registo Veiculo</h1> 

                <form ACTION = "ajax_transportador.php" METHOD = "POST">
                    <?php 
                        echo "<input type='hidden' value='4' name='codigo' >"; ?>
                    <label><strong><em>Tipo de veiculo:&nbsp</em></strong></label>
                    <select name = 'tipo' id = 'categoriaPAPI' onChange='obtemSubCategoria()' required >
                    <?php
                        $resultado=$ctrlbaseTransportador->getTipoVeiculo();
                    
                        echo "<option value=''>Escolher tipo</option>";
                        foreach($resultado as $tipo){
                            echo "<option  value='".$tipo['idTipo']."'>".$tipo['tipo']."</option>";
                        }
                        echo "</select><br>";
				    ?>
                    <label><strong><em>Ano do veiculo:&nbsp</em></strong></label>
                    <input name="ano" type="month" name="bday-month" value=""><br>

                    <label><strong><em>Matricula:</em></strong></label>
					<input type="text" name="matricula" required title="DD-DD-DD" data-eye><br>

                    <label><strong><em>Marca:</em></strong></label>
					<input type="text" name="marca" required><br>

                    <label><strong><em>Consumo Por 100km:</em></strong></label>
					<input type="number" name="consumo" required><br>

                    <label><strong><em>Tipo de Combustivel:</em></strong></label>
					<select name="combustivel" required>
                        <option value="gasolina">Gasolina</option>
                        <option value="gasoleo">Gasoleo</option>
                        <option value="diesel">Diesel</option>
                    </select><br>

                    <label><strong><em>Carga Maxima(Kg):</em></strong></label>
					<input type="number" name="carga" required><br>

                    <input type="hidden" name="estado" value="22">

                    <label><strong><em>Frigorifico:</em></strong></label>
					<select name="frigorifico" required>
                        <option value="0">Sim</option>
                        <option value="1">Não</option>
                    </select><br>
                    <hr>
                    <h2>Atribuir a uma base</h2>
                    <label><strong><em>Base:&nbsp</em></strong></label>
                    <select name = 'idBaseTransportador' id = 'categoriaPAPI' onChange='obtemSubCategoria()' required >
                    <?php
                        $resultado=$ctrlbaseTransportador->getTodosOsDados($_SESSION['nif']);
                    
                        echo "<option value=''>Escolher base</option>";
                        foreach($resultado as $base){
                            echo "<option  value='".$base['idBase']."'>".$base['nome']."</option>";
                        }
                        echo "</select>";
				    ?><br>
                    <hr>
                    <input type='submit' value='Criar Veiculo' class='btnUser'>
                </form>
                <hr>
                <a href="verProduto.php"> <button class="btnUser">Voltar</button> </a>
            </div>
            <br>
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
