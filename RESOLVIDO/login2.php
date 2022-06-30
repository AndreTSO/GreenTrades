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
    
	<?php 
		include("includes/config.php");
	?>

</head>
<body class="js">
		<header class="header shop">
            <div class="topbar">
                <div class="login">
                    <a href="#"><i class="ti-user"></i></a>
                </div>
                <div class="logo">
                    <a href="index.html"><img src="images/logo.png" alt="logo"></a>
                </div>
                <div class="search-bar-top">
                    <div class="search-bar">
                        <select>
                            <option>All Category</option>
                            <option>watch</option>
                            <option>mobile</option>
                            <option>kid’s item</option>
                        </select>
                        <form>
                            <input name="search" placeholder="Search Products Here....." type="search">
                            <button class="btnn"><i class="ti-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </header>
        <div id="navbar">
            <a href="#home" class="btn-hover">All Category</a>
            <a href="#" class="btn-hover">Shop</a>
            <a href="cart.php" class="btn-hover">Cart</a>
            <a href="checkout.php" class="btn-hover">Checkout</a>
            <a href="#" class="btn-hover">Pages</a>								
            <a href="contact.php" class="btn-hover">Contact Us</a>                                
        </div>
        <div class="content">
            <div class="container">
                <div class="contact-head">
					<div class="row">
						<div class="col-lg-8 col-12">
							<div class="form-main">


							<?php

                                    $msg = array(
                                        1    => "Registado com sucesso!",
                                        2    => "Erro no registo!",
                                        3    => "Erro ao autenticar!",

                                    );

                                    if (isset($_GET['status'])){
                                        echo $msg[$_GET['status']];
                                    }
                                ?>
								<div class="title">
									<h4>Entrar</h4>
									<h3>Use as suas credenciais</h3>
								</div>
								<form class="form" method="post" action="ajax_user.php">
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
										<a href="registar.php"><button type="submit" class="btn ">Registar</button></a>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
        </div>
        <div class="footer-dark">
            <footer>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-md-3 item">
                            <h3>Services</h3>
                            <ul>
                                <li><a href="#">Web design</a></li>
                                <li><a href="#">Development</a></li>
                                <li><a href="#">Hosting</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-md-3 item">
                            <h3>About</h3>
                            <ul>
                                <li><a href="#">Company</a></li>
                                <li><a href="#">Team</a></li>
                                <li><a href="#">Careers</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6 item text">
                            <h3>Company Name</h3>
                            <p>Praesent sed lobortis mi. Suspendisse vel placerat ligula. Vivamus ac sem lacus. Ut vehicula rhoncus elementum. Etiam quis tristique lectus. Aliquam in arcu eget velit pulvinar dictum vel in justo.</p>
                        </div>
                        <div class="col item social"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-instagram"></i></a></div>
                    </div>
                    <p class="copyright">Company Name © 2018</p>
                </div>
            </footer>
        </div>


		
	<!--<h4>Entrar</h4>
	<h3>Use as suas credenciais</h3>
	
	<form class="form" method="post" action="ajax_user.php">
		<input type="hidden" name="codigo" value=3>
		<label>Email<span>*</span></label>
		<input name="email" type="email" placeholder="">

		<label>Senha<span>*</span></label>
		<input name="senha" type="password" placeholder="">

		<button type="submit" class="btn ">Entrar</button>

	</form>
	<center>
        <div style="background-color:brown; width:500px; height:400px; border-radius:15px;">
            <h1>Edit me please!</h1>
            <p>I have a Dream.. A dream of becomming a beautiful website</p>
            <img src="https://www.eas.pt/wp-content/uploads/2017/08/LUTER-1-437x276.jpg"/>

        </div>
    </center> -->

	
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
</body>
