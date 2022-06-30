

<!-- NAO ESTRAGAR ESTA BASE, NAO MEXER; NAO RESPIRA!-->


<!DOCTYPE html>
<html lang="pt">
    <head>
        <?php 
            require_once("includes/config.php");
            require_once("classes/produto.php");

            $ctrlProd = new produto($db);


        ?>
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
        <link rel="stylesheet" href="css/cuteAlertstyle.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="js/cute-alert.js"></script>
        <script src="js/extraFunctions.js"></script>


        <script>
            function wc(){ // Wipe Cesto
                eraseCookie("cesto");
                location.reload();
            }

            function eraseCookie(name) {   
                document.cookie = name+'=; Max-Age=-99999999;';  
            }


        </script>

        </head>
    <body>
        <div class="body">            
            <?php
                include("topo.php") 
            ?>
            <div class="page">
                <div class="content">
                    <center>
                        <h3>Obrigado pelo seu pagamento!</h3>
                        <br>
                        <a href="index.php"><button class="btnUser">Continuar</button></a>
                    </center>
                </div>

            </div>

            <?php

                include("includes/footer.php")

            ?> 
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
        <script src="js/navbar.js"></script>

	    <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="cdnjs.cloudflare.com/ajax/libs/flickity/1.0.0/flickity.pkgd.js"></script>
        <script src="js/slides.js"></script>
    </body>
</html>