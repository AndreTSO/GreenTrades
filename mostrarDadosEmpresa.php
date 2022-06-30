


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

        require_once ('classes/fornecedor.php');
        $ctrlFornecedor = new fornecedor($db);

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
                    <h2>Empresa</h2>
                    <hr class="middle">
                </div>
                
                
                <hr>
                <?php
                    if (!$ctrlFornecedor->existsEmpresa($_SESSION['nif'])) { 
                        //A empresa nao foi criada nunca!
                        echo "Empresa ainda não foi registada <br>";
                        echo '<a href = "fornecedorDados.php"><button class="btnUser">Criar Empresa</button></a>';
                        echo '<a  href = "landpage.php"><button class="btnUser">Voltar</button></a>';
                    }else{
                        
                        $user = $ctrlUser -> getTodosOsDados($_SESSION['nif']);
                       $empresa = $ctrlFornecedor -> getTodosOsDados($_SESSION['nif']);
            
                ?>
                <strong><em>Nome do Representante:&nbsp</em></strong> <?php echo $user['nome'] ?> <br>
                <strong><em>Email do Representante:&nbsp</em></strong><?php echo $user['email'] ?>
                
                <hr>
                <strong><em>Nome da Empresa:&nbsp</em></strong><?php echo $empresa['nomeEmpresa'] ?><br>
                <strong><em>Página da Empresa:&nbsp</em></strong><a href="<?php echo $empresa['webSite'] ?>"><?php echo $empresa['webSite'] ?></a><br>
                <strong><em>Descrição:&nbsp</em></strong><?php echo $empresa['descricao'] ?><br>
                <strong><em>Contacto:&nbsp</em></strong><?php echo $user['contato'] ?><br>
                <strong><em>Morada da Sede:&nbsp</em></strong><?php echo $user['morada'] ?><br>
                <strong><em>Distrito da Sede:&nbsp</em></strong><?php echo $ctrldistrict->getDistrictById($db, $user['distrito']) ?><br>
                <strong><em>Concelho da Sede:&nbsp</em></strong><?php echo $ctrldistrict->getConcelhoById($db, $user['concelho']) ?><br>
                <strong><em>Código Postal:&nbsp</em></strong><?php echo $user['codigoPostal'] ?><br>
                <strong><em>Aceita devoluções até:&nbsp</em></strong><?php echo $empresa['PeriodoXDiasCancelar'] ?><strong><em>&nbsp dias úteis</em></strong>
                <hr>
                <strong><em>Poluição gerada até hoje:&nbsp</em></strong><?php echo $empresa['poluicaoGerada'] ?><br>
                <strong><em>Consumo de recursos até hoje:&nbsp</em></strong><?php echo $empresa['consumoRecursos'] ?><br>
                <hr>
    
                <div class="opcoes">
                    <a  href = "editarDadosEmpresa.php"><button class="btnUser">Editar dados Empresa</button></a>
                    <a  href = "landpage.php"><button class="btnUser">Voltar</button></a>
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
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
</body>



