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
    <link rel="stylesheet" href="css/cuteAlertstyle.css">
    <script src="js/cute-alert.js"></script>
    <script src="js/extraFunctions.js"></script>
    <script>
        function removeNotify(args){
            
            $.ajax({
				type: "POST",
				url: 'ajax_user.php',
				data: {codigo: 11, notify: args},
				dataType: "html",
				success: function (data){
                        
						if (data == 1) {
                            $("#notifyId"+args).remove();
						}
                        if (data == -1) {
                            msgAlert("erro");
						}
					}
				});

        }


        function recuperarCesto(){
            msgAlert("Recuperamos o seu Cesto de compras feito enquanto não esteve autenticado");
            eraseCookie("cesto");
        }

        function eraseCookie(name) {
            document.cookie = name + '=; Max-Age=-99999999;';
        }


                   



    </script>

	<?php 
		require_once("includes/config.php");

        require_once 'classes/user.php';
        require_once 'classes/consumidor.php';
        $ctrlUser=new user($db);
        

        if (!$ctrlUser->islogged())
	        header('Location: index.php');
            //EJECT
      
        



	?>


</head>
<body class="js">
    <div class="body">

        <?php 
            include 'topo.php';

        ?>


        <div class="page" style='background-image: url('images/patternpad.svg'); z-index: 0;'>
            <!-- <img src='images/patternpad.svg' style='object-fit:contain;  z-index: -1;position:absolute;'> -->
            <?php
		        include 'showMsg.php';
	        ?>

            <?php 


                $ctrlConsumidor=new consumidor($db, $_SESSION['nif']);
                if (!$ctrlConsumidor->isCestoOcupied()){
                    if (isset($_COOKIE["cesto"])) {
                        $cestoGrosso = $_COOKIE["cesto"];
                        $cestoSplited = explode("@", $cestoGrosso);
                        array_pop($cestoSplited); // Retirar a ultima posiçao porque nao tem nada

                    }


                    if (isset($cestoSplited)) {

                        foreach ($cestoSplited as $artigo) {
                            $artigo = explode(":", $artigo);
                            $ctrlConsumidor->addArtigosCesto(intval($artigo[0]), intval($artigo[1])); 
                            $ctrlUser->setNotify($_SESSION['nif'], "Recuperamos o seu Cesto de compras", "Recuperamos o seu Cesto de compras feito durante o periodo em que não estava autenticado");     
                        }
                        ?>
                            <script type="text/javascript">
                                recuperarCesto();
                            </script>

                        <?php
                    }



                }




                echo "<div class='content'>";
                echo '<div class="contentTitle">';
                    echo "<p class='welcomemsg'>Bem Vindo ".$_SESSION['nome']."</p>";
                    echo '<hr class="middle">';
                echo '</div>';
                echo '<br>';
                echo '<br>';
                    
                    echo "<div class='opcoesUser'>";

                        echo "<div class='rectan'>";
                            echo "<a href='userAccount.php'style='text-align: center; line-height: 100px;'><span class='linkUser'></span>Conta Pessoal</a>";
                            
                        echo "</div>";


        

                        if (isset($_SESSION["tipoDeConta"]) && $_SESSION["tipoDeConta"] == 1){
                            echo "<div class='rectan'>";
                            echo "<a href='userAccount.php' style='text-align: center; line-height: 100px;'><span class='linkUser'></span>Ultimas Compras</a>";
                            echo "</div>";
                        
                            echo "<div class='rectan'>";
                            echo "<a href='userAccount.php' style='text-align: center; line-height: 100px;'><span class='linkUser'></span>Faturação</a>";
                            echo "</div>";
                    
                        }else if ($_SESSION["tipoDeConta"] == 2){
                            echo "<div class='rectan' >";
                            echo "<a href='mostrarDadosEmpresa.php' style='text-align: center; line-height: 100px;'><span class='linkUser'></span>Dados Empresa</a>";

                            
                            
                            
                            echo "</div>";
                            echo "<div class='rectan'>";
                            echo "<a href='showArmazem.php' style='text-align: center; line-height: 100px;'><span class='linkUser'></span>Armazens</a>";
                            echo "</div>";
                            echo "<div class='rectan'>";
                            echo "<a href='verProduto.php' style='text-align: center; line-height: 100px;'><span class='linkUser'></span>Produtos</a>";
                            echo "</div>";
                            echo "<div class='rectan'>";
                            echo "<a href='userAccount.php' style='text-align: center; line-height: 100px;'><span class='linkUser'></span>Encomendas</a>";
                            echo "</div>";
                            echo "<div class='rectan'>";
                            echo "<a href='userAccount.php' style='text-align: center; line-height: 100px;'><span class='linkUser'></span>Envios</a>";
                            echo "</div>";
                            echo "<div class='rectan'>";
                            echo "<a href='userAccount.php' style='text-align: center; line-height: 100px;'><span class='linkUser'></span>Faturação</a>";
                            echo "</div>";

                        }else if ($_SESSION["tipoDeConta"] == 3){
                            echo "<div class='rectan'>";
                            echo "<a href='mostrarDadosTransportador.php' style='text-align: center; line-height: 100px;'><span class='linkUser'></span>Dados Empresa</a>";
                            echo "</div>";
                            echo "<div class='rectan'>";
                            echo "<a href='showBaseTransportador.php' style='text-align: center; line-height: 100px;'><span class='linkUser'></span>Bases</a>";
                            echo "</div>";
                            echo "<div class='rectan'>";
                            echo "<a href='verVeiculos.php' style='text-align: center; line-height: 100px;'><span class='linkUser'></span>Veiculos</a>";
                            echo "</div>";
                            echo "<div class='rectan'>";
                            echo "<a href='userAccount.php' style='text-align: center; line-height: 100px;'><span class='linkUser'></span>Serviços</a>";
                            echo "</div>";
                            echo "<div class='rectan'>";
                            echo "<a href='userAccount.php' style='text-align: center; line-height: 100px;'><span class='linkUser'></span>Faturação</a>";
                            echo "</div>";
                        
                        }
                        echo "</div>";
                        echo '<br>';
                        echo '<br>';
                        echo '<br>';

                        echo "<hr>";
                        echo '<div class="notifications">';

                        echo '<div class="contentTitle">';
                            echo "<h1 class='welcomemsg'>Notificações</h1>";
                            echo '<hr class="middle">';
                        echo '</div>';
                        
                        
                        echo '<br>';
                        echo '<br>';
                        echo "<table >
                                <tr>
                                    
                                    <th>Data</th>
                                    <th>Mensagem</th>
                                    <th>Ação</th>
                                </tr>";

                        $notificacoes = $ctrlUser->getNotify($_SESSION['nif']);
                        if (!empty($notificacoes)){
                            foreach($notificacoes as $linha){
                                echo"<tr title='".$linha['title']."' id='notifyId".$linha['idAviso']."'>
                                        
                                        <td>".$linha['data']."</td>
                                        <td>".$linha['mensagem']."</td>
                                        <td><center><img src='images/x.png' width='15px' height='15px;' onclick='removeNotify(".$linha['idAviso'].")' style='margin-top:5px;'></center></td>
                                       
                                    </tr>";
                            }
                        }else{
                        echo"   <tr>
                                    <td colspan='3'>Sem notificações</td> 
                                </tr>";
                        }
                        
                        echo "</table>";
                        echo '</div>';
                   
                echo "</div>";
   
	        ?>
        </div> 

        <?php

            include("includes/footer.php")
    
        ?>
    </div>
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
    <script src="js/navbar.js"></script>
</body>