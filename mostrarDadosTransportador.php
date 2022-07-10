


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
         if (isset($_SESSION['nif']) ){
             if (!$ctrlUser->isAuthorized(3,$_SESSION['nif'])){
                header('Location: index.php');
             }
        }

        require_once ('classes/transportador.php');
        $ctrlTransportador = new transportador($db);

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
                    if (!$ctrlTransportador->existsEmpresa($_SESSION['nif'])) { 
                        //A empresa nao foi criada nunca!
                        echo "Empresa ainda não foi registada <br>";
                        echo '<a href = "transportadorDados.php"><button class="btnUser">Criar Empresa</button></a>';
                        echo '<a  href = "landpage.php"><button class="btnUser">Voltar</button></a>';
                    }else{
                        
                        $user = $ctrlUser -> getTodosOsDados($_SESSION['nif']);
                       $empresa = $ctrlTransportador -> getTodosOsDados($_SESSION['nif']);
            
                ?>

                <div class="container rounded bg-white mt-5 mb-5">
                    <div class="row">
                        <div class="col-md-4 border-right">
                            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><span class="font-weight-bold"><?php echo $user['nome'] ?></span><span class="text-black-50"><?php echo $user['email'] ?></span><span> </span></div>
                            <!-- <strong><em>Nome do Representante:&nbsp</em></strong> <?php echo $user['nome'] ?> <br>
                            <strong><em>Email do Representante:&nbsp</em></strong><?php echo $user['email'] ?> -->
                        </div>
                        <div class="col-md-5 border-right">
                            <div class="p-3 py-5">
                                <div class="row mt-1">
                                    <div class="col-md-12"><label class="labels"><strong><em>Nome da Transportadora:&nbsp</em></strong></label><?php echo $empresa['nomeEmpresa'] ?></div>
                                    <div class="col-md-12"><label class="labels"><strong><em>Descrição:&nbsp</em></strong></label><?php echo $empresa['descricao']; ?></div>
                                    <div class="col-md-12"><label class="labels"><strong><em>Página da Empresa:&nbsp</em></strong></label><a href="<?php echo $empresa['webSite'] ?>"><?php echo $empresa['webSite'] ?></a></div>
                                    <div class="col-md-12"><label class="labels"><strong><em>Contacto:&nbsp</em></strong></label><?php echo $user['contato'] ?></div>
                                </div>
                                <hr>
                                <div class="row mt-2">
                                    <div class="col-md-12"><label class="labels"><strong><em>Morada da Sede:&nbsp</em></strong></label><?php echo $user['morada'] ?></div><br>
                                    <div class="col-md-12"><label class="labels"><strong><em>Distrito da Sede:&nbsp</em></strong></label><?php echo $ctrldistrict->getDistrictById($db, $user['distrito']) ?></div><br>
                                    <div class="col-md-12"><label class="labels"><strong><em>Concelho da Sede:&nbsp</em></strong></label><?php echo $ctrldistrict->getConcelhoById($db, $user['concelho']) ?></div><br>
                                    <div class="col-md-12"><label class="labels"><strong><em>Código Postal:&nbsp</em></strong></label><?php echo $user['codigoPostal'] ?></div><br>
                                    <div class="col-md-12"><label class="labels"><strong><em>Entregas em :&nbsp</em></strong></label><?php echo $empresa['garantiaEntregaXHoras'] ?><strong><em>&nbsp;Horas</em></strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                                    <!--<hr>
                <strong><em>Poluição gerada até hoje:&nbsp</em></strong><?php echo $empresa['poluicaoGerada'] ?><br>
                <strong><em>Consumo de recursos até hoje:&nbsp</em></strong><?php echo $empresa['consumoRecursos'] ?><br>
                <hr>-->
                <center>
                <div class="opcoes">
                    <a  href = "editarDadosTransportadora.php"><button class="btnUser">Editar dados transportadora</button></a>
                    <a  href = "landpage.php"><button class="btnUser">Voltar</button></a>
                </div>
                </center>
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



