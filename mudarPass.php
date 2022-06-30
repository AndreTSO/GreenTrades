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

        include 'classes/user.php';
        $ctrlUser=new user($db);

        if (!$ctrlUser->islogged())
	        header('Location: index.php');
            //EJECT


	?>


	<script>
		function pw(){
			registar.senha2.setAttribute('pattern', registar.senha.value);
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
                <div class="data">
                    <div class="contentTitle">
                        <h2>Alteração de Password</h2>
                        <hr class="middle">
                    </div>
                    
                    <hr>

                    <?php  

                        include 'showMsg.php';
                        //$nif, $nome, $sobreNome, $genero, $email, $morada, $codigoPostal, $distrito, $concelho, $dataNascimento,  $contacto, $anuncios, $senha=""
                    
                    ?>
                    <?php 
                        $resultado = $ctrlUser->getTodosOsDados($_SESSION['nif']);
                    ?>

                    <form  METHOD="POST" ACTION="ajax_user.php" name="registar">
                        <input type="hidden" name="codigo" value=10>
                        <input type="hidden" name="nif" value="<?php echo $_SESSION['nif']?>">
						<label><strong><em>Insira a nova password: &nbsp</em></strong></label>
                        <input name="senha" type="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="8 Digitos Min 1 numero, Min 1 Maiuscula, min 1 Minuscula" required><br>
						<label><strong><em>Repita a nova password: &nbsp</em></strong></label>
                        <input name="senha2" onchange="pw()" type="password" required><br>
						<label><strong><em>Insira a password atual para guardar as alterações feitas: &nbsp</em></strong></label>
                        <input  name="passAntiga" type="password"  required placeholder="Password atual"><br>
                        <input type="submit" value="Guardar" class="btnUser">
                        
                    </form>
                    <hr>
                    <div class="opcoes">
                        <a href="userAccount.php"><button class="btnUser">Voltar</button></a>
                    </div>
                        <br>
                </div>
                
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
