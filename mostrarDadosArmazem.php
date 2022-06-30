


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

        require_once ('classes/armazem.php');
        $ctrlArmazem = new armazem($db);

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
                <div class="contentTitle">
                    <h2>Dados do Armazem</h2>
                    <hr class="middle">
                </div>
                
                
                
                <hr>
                <?php
                    $armazem = $ctrlArmazem->getTodosOsDados($_POST['idArmazem']);
                ?>
                <strong><em>Nome do Armazem:&nbsp</em></strong><?php echo $armazem['nome'] ?><br>
                <strong><em>Morada do Armazem:&nbsp</em></strong><?php echo "".$armazem['morada'].", ".$armazem['nPorta'].", ".$armazem['andar'];?><br>
                <strong><em>Distrito da Sede:&nbsp</em></strong><?php echo $ctrldistrict->getDistrictById($db, $armazem['distrito']) ?><br>
                <strong><em>Concelho da Sede:&nbsp</em></strong><?php echo $ctrldistrict->getConcelhoById($db, $armazem['concelho']) ?><br>
                <strong><em>Código Postal:&nbsp</em></strong><?php echo $armazem['codigoPostal'] ?><br>
                <strong><em>Custo de Manutencao:&nbsp</em></strong><?php echo $armazem['custoManutencao'] ?><strong><em>&nbsp €</em></strong><br>
                <strong><em>Estado:&nbsp</em></strong><?php echo ($armazem['estado']== "34"?"Ativo": ($armazem['estado'] == "35"? "Encerrado":"Indisponivel")) ?><br>
                <hr>
                <div class="opcoes">
                    <form ACTION="editarArmazem.php" METHOD ="POST">
                        <input type="hidden" value="<?php echo $_POST['idArmazem'] ?>" name="idArmazem">
                        <input type="submit" value="Editar Dados" class="btnUser">
                    </form>
                    <hr>
                    <a  href = "showArmazem.php"><button class="btnUser">Voltar</button></a>
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



