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
									<h4>Registar</h4>
									<h3>Registe-se na nossa plataforma</h3>
								</div>

								


								<form class="form" METHOD="POST" ACTION="ajax_user.php" name="registo">
									<input type="hidden" name="codigo" value=2>
									<div class="row">
									<div class="col-12">
										<div class="form-group">
											<label>Nome<span>*</span></label>
											<input id="nome" name="nome" type="text" required placeholder="">
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>SobreNome<span>*</span></label>
											<input id="sobreNome" name="sobreNome" type="text" required placeholder="">
										</div>
									</div>
									<div class="col-12">
										
											
										<label>Genero<span>*</span></label>
				
										<br><input type="radio" name="genero" required value="M" checked="checked"> Masculino
										<br><input type="radio" name="genero" required value="F"> Feminino
										<br><input type="radio" name="genero" required value="O"> Prefiro não dizer
										<br>
									</div>
									
									<div class="col-12">
										<div class="form-group">
											<label>Email<span>*</span></label>
											<input id="email" name="email" type="email" required placeholder="">
										</div>
									</div>

									<div class="col-12">
										<div class="form-group">
											<label>Senha<span>*</span></label>
											<input id="senha1" name="senha" type="password" required placeholder="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="8 Digitos Min 1 numero, Min 1 Maiuscula, min 1 Minuscula">
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>Repetir Senha<span>*</span></label>
											<input id="senha2" name="senha2" type="password" onchange="pw()" required placeholder="">
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>Morada<span>*</span></label>
											<input id="morada" name="morada" type="text" required placeholder="">
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>Codigo-postal<span>*</span></label>
											<input id="codPostal" name="codigoPostal"  pattern="\d{4}-\d{3}" title="DDDD-DDD" type="text" required placeholder="">
										</div>
									</div>
									<div class="col-12">
										
										<div class="form-group">
											<label>Distrito<span>*</span></label>
										</div>
										
										<select name='distrito' id='distrito' onChange='obtemDistrito()' required >
										<?php
										$resultado=$ctrldistrict->getDistrict($db);
										
										echo "<option value=''>Distrito</option>";
										if ($resultado && $resultado->RecordCount()>0){
											
											while ($linha=$resultado->FetchRow()){
												echo "<option  value='".$linha['id']."'>".$linha['name']."</option>";
												
											}
										}
										echo "</select>";	
									
										
									?>



									</div>
									<div class="col-12">
										
										<div class="form-group">
											<label>Concelho<span>*</span></label>
										</div>
										<span id="conselho2">
											<input type="text" value="" class="formRegist" required placeholder="Escolha o distrito primeiro &#8593;" disabled></input>
										</span>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>Data de nascimento<span>*</span></label>
											<input id="dataNasc" name="dataNascimento" type="date" required placeholder="">
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>Tipo de conta<span>*</span></label>
										</div>
										<input type="radio" name="tipoConta" required value="1" checked="checked"> Cliente
										<br><input type="radio" name="tipoConta" required value="2"> Fornecedor
										<br><input type="radio" name="tipoConta" required value="3"> Transportador
									
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>Nif<span>*</span></label>
											<input id="nif" name="nif" type="number" pattern="\d{9}" title="Numero de contribuinte com 9 digitos" required placeholder="">
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label>Contacto<span>*</span></label>
											<input id="tlf" name="contacto" type="text" pattern="\d{9}" title="Numero de telefone com 9 digitos" required placeholder="">
										</div>
									</div>		

									<div class="col-12">
										<div class="form-group">
											<label>Mostrar artigos personalizados<span>*</span></label>
										</div>
										<input name="anuncios" type="radio" required checked="checked" value="1"> Sim
										<br><input name="anuncios" type="radio" required value="0"> Não
									</div>	
										
									<div class="col-12">

										<div class="form-group button">
											<label>Ao registar, concorda com os termos e serviços!<span>*</span></label>
											<br>
											<button  class="btn ">Registar</button>

											<span id="atualiza"></span>


								
											
										</div>
									</div>
								</form>

								
							</div>
						</div>
                        <div class="col-lg-4 col-12">
							<div class="single-head">
								<div class="single-info">
									<i class="fa fa-user"></i>
									<h4 class="title">Entrar</h4>
									<div class="form-group button">
										<a href="login.php"><button type="submit" class="btn ">Entrar</button></a>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
        <script src="js/navbar.js"></script>

	    <script src="js/bootstrap.min.js"></script>
        <script src="js/slides.js"></script>
    </body>
</html>