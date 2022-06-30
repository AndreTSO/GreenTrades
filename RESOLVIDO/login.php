<!DOCTYPE html>
<html lang="en">
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
    </head>
    <body>
        <div class="content">
            <div class="container">
                <div class="contact-head">
					<div class="row">
						<div class="col-lg-8 col-12">
							<div class="form-main">


							<?php

                                    include('includes/showMsg.php')
                                ?>
								<div class="title">
									<h4>Entrar</h4>
									<h3>Use as suas credenciais</h3>
								</div>
								<form class="form" method="post" action="ajax_userTeste.php">
								<input type="hidden" name="codigo" value=3>
									<div class="row">
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Email<span>*</span></label>
												<input name="email" type="email" placeholder="">
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Senha<span>*</span></label>
												<input name="senha" type="password" placeholder="">
											</div>
										</div>
                                        <div class="col-12">
											<div class="form-group button">
												<button type="submit" class="btn ">Entrar</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
                        <div class="col-lg-4 col-12">
							<div class="single-head">
								<div class="single-info">
									<i class="fa fa-user"></i>
									<h4 class="title">Registar</h4>
									<div class="form-group button">
										<a href="registar2.php"><button type="submit" class="btn ">Registar</button></a>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
        <script src="js/navbar.js"></script>

	    <script src="js/bootstrap.min.js"></script>
        <script src="js/slides.js"></script>
    </body>
</html>