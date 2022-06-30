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
		require_once("classes/lib.php");
		require_once('classes/district.php');
        require_once 'classes/user.php';

		$ctrldistrict=new handlerDistrict();	
		$ctrllib=new lib($db);	
        $ctrlUser=new user($db);

        if (!$ctrlUser->islogged())
	        header('Location: RAW_index.php');
            //EJECT
        if (isset($_SESSION['nif']) ){
            if (!$ctrlUser->isAuthorized(3,$_SESSION['nif'])){
                header('Location: RAW_index.php');
            }
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
</script>
</head>


<body>
    <div class="body">
        <div class="page">
            <?php 
                include 'topo.php';

            ?>
            <?php
                    include 'showMsg.php';
            ?>

            <div class="content">
                <h2>Registo de Nova Base</h2> 
                <hr>
                <form ACTION = "ajax_transportador.php" METHOD = "POST">
                    <?php 
                        
                    echo "<input type='hidden' value='".$_SESSION['nif']."' name='idTransportador' >";
                    echo "<input type='hidden' value='3' name='codigo' >";
                    echo "<label><strong><em>Nome da Base:  &nbsp </em></strong></label><input type='text' name='nome' value = ''required placeholder='Nome da Base'><br>";
                    echo "<label><strong><em>Morada a Base:  &nbsp </em></strong></label> <input type='text' name='morada' value = ''required placeholder='Morada'><br>";
                    echo "<label><strong><em>Distrito:  &nbsp </em></strong></label> <select name = 'distrito' id = 'distrito' onChange='obtemDistrito()' required>";
                        $resultado=$ctrldistrict->getDistrict($db);
                        
                        echo "<option value=''>Distrito</option>";
                        if ($resultado && $resultado->RecordCount()>0){
                            
                            while ($linha=$resultado->FetchRow()){
                                echo "<option  value='".$linha['id']."'>".$linha['name']."</option>";
                                
                            }
                        }
                    echo "</select><br>";
                    echo '<span id="conselho2">';
                    echo "</label><strong>Concelho</strong><input name='concelho' id='concelho' type='text' required placeholder='Escolha o distrito primeiro &#8593;' disabled><br>";
                    echo '</span>';
                    echo '<label><strong><em>Código Postal:  &nbsp </em></strong></label> <input type="text" name="codigoPostal" required pattern="\d{4}-\d{3}" title="DDDD-DDD" data-eye><br>';
                    echo "<label><strong><em>Custo de Manutenção da Base:  &nbsp </em></strong></label> <input type='number' name='custoManutencao' value = ''required><br>";
                    echo "<label><strong><em>Poluição gerada por esta Base:  &nbsp </em></strong></label> <input type='number' name='poluicaoGerada' value = ''required ><br>";
                    
                    echo "<label><strong><em>Estado do Base:  &nbsp </em></strong></label>";
                    echo "<select name = 'estado'>";
                        $vetorExterno = $ctrllib->getEstados("ARMAZEM");
                        foreach ($vetorExterno as $vetorInterno){
                            echo "<option value=".$vetorInterno['idEstado'].">".$vetorInterno['estado']."</option>";
                        }
                    echo "</select><br><br>";
                    echo "<input type='submit' value='Criar base' class='btnUser'> ";

                    ?>
                </form>
                <hr>
                <div class="opções">
						<a href="showBaseTransportador.php"><button class="btnUser">Voltar </button></a>
				</div>        
            </div>

            
        </div>
        <?php

            include("includes/footer.php");

        ?>

    </div>
</body>


	<!-- Jquery -->
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
