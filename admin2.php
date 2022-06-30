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
    <link rel="stylesheet" href="css/twitter.css">
	<?php 
		include("includes/config.php");

        include 'classes/user.php';
        $ctrlUser=new user($db);
        
	?>




</head>

<body>


        

        <?php 
            if (isset($_POST['email'])){
                $ctrlUser->login($_POST['email'], $_POST['password']);
            }
        ?>

    
        <?php
        
            if (isset($_SESSION['nif']) ){
                if (!$ctrlUser->isAuthorized(5,$_SESSION['nif'])){
                    header('Location: RAW_index.php');
                }
             //MOSTRA A PAGINA AUTENTICADA
        ?>
        <?php 
            echo " <a href='ajax_user.php?codigo=4'>Sair</a>";
            echo "<br>";
            include("showMsg.php");
            echo "<br><br><h1>Todos os utilizadores</h1><br>";
                
            $vetorExterno = $ctrlUser->getAllUser();
            echo "<table class='table table-condensed'>";
                echo "<tr>";
                    echo "<th>Nome</th>";
                    echo "<th>Sobre nome</th>";
                    echo "<th>Data Registo</th>";
                    echo "<th>Tipo de Conta</th>";
                    echo "<th>Estado Conta</th>";
                    echo "<th>Observações</th>";
                    echo "<th>Editar</th>";
                echo "</tr>";

            foreach ($vetorExterno as $vetorInterno){
                echo "<tr>";
                    echo "<td>".$vetorInterno['nome']."</td>";
                    echo "<td>".$vetorInterno['sobreNome']."</td>";
                    echo "<td>".$vetorInterno['dataRegisto']."</td>";
                    echo "<td>".($vetorInterno['tipoDeConta']== 1?"Utilizador": ($vetorInterno['tipoDeConta'] == 2?  "Fornecedor":($vetorInterno['tipoDeConta'] == 3?  "Transportador": "Administrador" ) ))."</td>";
                    echo "<td>".($vetorInterno['estadoConta']== 31?"Ativa": ($vetorInterno['estadoConta'] == 32?  "Bloqueada":($vetorInterno['estadoConta'] == 33?  "Desativada": "Por Ativar" ) ))."</td>";
                    echo "<td title='".$vetorInterno['observacoes']."'>  ".(substr($vetorInterno['observacoes'], 0, 15)).(strlen($vetorInterno['observacoes'])>15?" ...":"")."</td>";
                    echo "<td>
                            <form METHOD='POST' ACTION='editarDadosAdmin.php'>
                                <input type='hidden' value='".$vetorInterno['nif']."' name='valorEditar'>
                                <input type='submit' class='btn btn-success' value='Editar'>
                            </form>
                        </td>";
                echo "</tr>";
            }
            echo "</table>";

            
            }else{
               
            }
        ?>
        

    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>




</body>