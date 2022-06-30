


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
		
		include'classes/district.php';
		$ctrldistrict=new handlerDistrict();	

        include 'classes/user.php';
        $ctrlUser=new user($db);

        if (!$ctrlUser->islogged())
	        header('Location: index.php');
            //EJECT
        // if (isset($_SESSION['nif']) ){
        //     if (!$ctrlUser->isAuthorized(2,$_SESSION['nif'])){
        //         header('Location: index.php');
        //     }
        // }

        require_once ('classes/veiculos.php');
        $ctrlVeiculo = new veiculo($db);
        require_once ('classes/baseTransportador.php');
        $ctrlTransportador = new baseTransportador($db);

	?>
</head>


<body>
    <div clas="body">
        <?php 
            include 'topo.php';

        ?>
        <div class="page">

            <?php
                include 'showMsg.php';
            ?>

            <div class="content">
                
                <h2>Dados do Veiculo</h2>
                <hr>
                <?php
                    $veiculo = $ctrlVeiculo->getTodosOsDados($_POST['idVeiculo']);
                ?>
                <strong><em>Tipo de Veiculo:&nbsp</em></strong><?php echo ($veiculo['tipoVeiculo']=="0"?"Carro":($veiculo['tipoVeiculo']=="1"?"Mota":"Camião")); ?><br>
                <strong><em>Ano do Veiculo:&nbsp</em></strong><?php echo $veiculo['anoDoVeiculo'];?><br>
                <strong><em>Matricula:&nbsp</em></strong><?php echo $veiculo['matricula']; ?><br>
                <strong><em>Marca:&nbsp</em></strong><?php echo $veiculo['marca']; ?><br>
                <strong><em>Consumo Por 100km:&nbsp</em></strong><?php echo $veiculo['consumoPorCemKm']; ?><br>
                <strong><em>Tipo de Combustivel:&nbsp</em></strong><?php echo $veiculo['tipoDeCombustivel'];?><br>
                <strong><em>Carga Maxima(kg):&nbsp</em></strong><?php echo $veiculo['cargaMaxima'] ?><br>
                <strong><em>Frigorifico:&nbsp</em></strong><?php echo ($veiculo['frigorifico']==0?"Sim":"Não")?><br>
                <hr>
                <?php
                    $base = $ctrlTransportador->getBase($veiculo['idBaseTransportador']);

                ?>
                <strong><em>Base:&nbsp</em></strong><?php echo $base['nome']?><br>
                <hr>
                <div class="opcoes">
                    <form ACTION="editarVeiculo.php" METHOD ="POST">
                        <input type="hidden" value="<?php echo $_POST['idVeiculo'] ?>" name="idVeiculo">
                        <input type="submit" value="Editar Dados" class="btnUser">
                    </form>
                    <hr>
                    <a  href = "verVeiculos.php"><button class="btnUser">Voltar</button></a>
                </div>
                
            </div>
        </div>
        <?php

            include("includes/footer.php");
    
        ?>
    </div>    
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
</body>



