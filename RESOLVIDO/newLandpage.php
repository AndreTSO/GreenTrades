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
    <link rel="stylesheet" href="css/leo.css">

	<?php 
		include("includes/config.php");

        include 'classes/user.php';
        $ctrlUser=new user($db);

        if (!$ctrlUser->islogged())
	        header('Location: index.html');
            //EJECT
        
        include ('classes/district.php');
        $ctrldistrict = new handlerDistrict($db);
	?>


</head>
<script>

    function mostrar(){
        $("#ApiEscondida").show();
        $("#btnAPI").hide();
    }

    function perfilTab(){
        $("#empresa").hide();
        $("#perfil").show();
        $("#armazem").hide();
        $("#produtos").hide();
        $("#encomendas").hide();
        $("#empresa-tab").removeClass('active');
        $("#perfil-tab").addClass('active');
        $("#armazem-tab").removeClass('active');
        $("#produtos-tab").removeClass('active');
        $("#encomendas-tab").removeClass('active');
    }

    function empresaTab(){
        $("#empresa").show();
        $("#perfil").hide();
        $("#armazem").hide();
        $("#produtos").hide();
        $("#encomendas").hide();
        $("#empresa-tab").addClass('active');
        $("#perfil-tab").removeClass('active');
        $("#armazem-tab").removeClass('active');
        $("#produtos-tab").removeClass('active');
        $("#encomendas-tab").removeClass('active');
    }

    function armazemTab(){
        $("#empresa").hide();
        $("#perfil").hide();
        $("#armazem").show();
        $("#produtos").hide();
        $("#encomendas").hide();
        $("#empresa-tab").removeClass('active');
        $("#perfil-tab").removeClass('active');
        $("#armazem-tab").addClass('active');
        $("#produtos-tab").removeClass('active');
        $("#encomendas-tab").removeClass('active');
    }

    function produtosTab(){
        $("#empresa").hide();
        $("#perfil").hide();
        $("#armazem").hide();
        $("#produtos").show();
        $("#encomendas").hide();
        $("#empresa-tab").removeClass('active');
        $("#perfil-tab").removeClass('active');
        $("#armazem-tab").removeClass('active');
        $("#produtos-tab").addClass('active');
        $("#encomendas-tab").removeClass('active');
    }

    function encomendasTab(){
        $("#empresa").hide();
        $("#perfil").hide();
        $("#armazem").hide();
        $("#produtos").hide();
        $("#encomendas").show();
        $("#empresa-tab").removeClass('active');
        $("#perfil-tab").removeClass('active');
        $("#armazem-tab").removeClass('active');
        $("#produtos-tab").removeClass('active');
        $("#encomendas-tab").addClass('active');
    }
    

</script>
<body class="js">
    <div class="body">

     <?php 
     include 'topo.php';

     ?>


    <div class="page">
        <?php
		    include 'showMsg.php';
	    ?>

        <div class="container emp-profile">
            <form method="post">
                <div class="row">
<!--                     <div class="col-md-4">
                        <div class="profile-img">
                            <img src="/images/utilizador.jpg" alt=""/>
                            <div class="file btn btn-lg btn-primary">
                                Change Photo
                                <input type="file" name="file"/>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-6">
                        <div class="profile-head">
                        <?php
                            $resultado = $ctrlUser->getTodosOsDados($_SESSION['nif']);
                        ?>
                                    <h4>
                                        <p>Bem-Vindo</p>
                                    </h4>
                                    <h6>
                                    <?php echo ($resultado['tipoDeConta']== 1?"Utilizador": ($resultado['tipoDeConta'] == 2?  "Fornecedor":($resultado['tipoDeConta'] == 3?  "Transportador": "Administrador" ) ))?>
                                    </h6>
                                    <p class="proile-rating">AVALIAÇAO : <span>5 estrelas</span></p>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <?php
                                            if($resultado['tipoDeConta'] == "1"){
                                                echo '<li class="nav-item">
                                                        <a class="nav-link active" id="home-tab" data-toggle="tab"  role="tab" aria-controls="home" onclick="firstTab();" aria-selected="true" style="color:black;">Perfil</a>
                                                    </li>';
                                            }elseif($resultado['tipoDeConta'] == "2"){
                                                echo '<li class="nav-item">
                                                        <a class="nav-link active" id="perfil-tab" data-toggle="tab"  role="tab" aria-controls="perfil" onclick="perfilTab();" aria-selected="true" style="color:black;">Perfil</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="empresa-tab" data-toggle="tab"  role="tab" aria-controls="empresa" onclick="empresaTab();" aria-selected="false" style="color:black;">Empresa</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="armazem-tab" data-toggle="tab"  role="tab" aria-controls="armazem" onclick="armazemTab();" aria-selected="false" style="color:black;">Armazem</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="produtos-tab" data-toggle="tab"  role="tab" aria-controls="produtos" onclick="produtosTab();" aria-selected="false" style="color:black;">Produtos</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="encomendas-tab" data-toggle="tab"  role="tab" aria-controls="encomendas" onclick="encomendasTab();" aria-selected="false" style="color:black;">Encomendas</a>
                                                    </li>';
                                            }elseif($resultado['tipoDeConta'] == "3"){
                                                echo "caralho";
                                            }else{
                                                echo "ADMIN";
                                            }

                                        ?>
                                    </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- <div class="col-md-4">
                       <div class="profile-work">
                            <p>WORK LINK</p>
                            <a href="">Website Link</a><br/>
                            <a href="">Bootsnipp Profile</a><br/>
                            <a href="">Bootply Profile</a>
                            <p>SKILLS</p>
                            <a href="">Web Designer</a><br/>
                            <a href="">Web Developer</a><br/>
                            <a href="">WordPress</a><br/>
                            <a href="">WooCommerce</a><br/>
                            <a href="">PHP, .Net</a><br/>
                        </div>
                    </div> -->
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <!-- PERFIL -->
                            <div class="tab-pane fade show active" id="perfil" role="tabpanel" aria-labelledby="perfil-tab">
                                        <!-- <div class="row">
                                            <div class="col-md-6">
                                                <label>TIPO DE CONTA</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $resultado['tipoDeConta']?></p>
                                            </div>
                                        </div> -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Nome</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $resultado['nome']." ".$resultado['sobreNome']?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Genero</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo ($resultado['genero']== "M"?"Masculino": ($resultado['genero'] == "F"?  "Feminino":"Prefiro Não Dizer"))?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $resultado['email'] ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Morada</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $resultado['morada'] ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Codigo Postal</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $resultado['codigoPostal'] ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Distrito</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $ctrldistrict->getDistrictById($db, $resultado['distrito']) ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Concelho</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $ctrldistrict->getConcelhoById($db, $resultado['concelho']) ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Contacto</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $resultado['contato'] ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Data Nascimento</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $resultado['dataNascimento'] ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Observações</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo (trim($resultado['observacoes'])==""?"Sem observações":$resultado['observacoes']) ?></p>
                                            </div>
                                        </div>
                                <button type="submit" class="btn btn-outline-success"><a href='LEO_editUser.php' style="text-decoration: none; color: green;">Editar dados</a></button>
                        </div>
                        <!-- EMPRESA -->
                        <div  class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane" id="empresa" role="tabpanel" aria-labelledby="empresa-tab">
                            <?php
                                $empresa = $ctrlFornecedor -> getTodosOsDados($_SESSION['nif']);
                                if($empresa == NULL){
                                    echo "Ainda sem empresa registada!<br>";
                                    echo '<br><button type="button" class="btn btn-outline-success">Registar Empresa</button>';
                                }else{
                                    echo '
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>
                                                <?php
                                                var_dump($empresa);
                                                echo "leo";
                                                echo "ZAZA";
                                                ?> 
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>Expert</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Hourly Rate</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>10$/hr</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Total Projects</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>230</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>English Level</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>Expert</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Availability</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>6 months</p>
                                        </div>
                                    </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Your Bio</label><br/>
                                    <p>Your detail description</p>
                                </div>
                            </div>';
                                }
                            ?>
                            </div>
                        </div>
                        <!-- ARMAZEM -->
                        <div  class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane" id="armazem" role="tabpanel" aria-labelledby="armazem-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>armazem</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>LOL</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Hourly Rate</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>10$/hr</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Total Projects</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>230</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>English Level</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Expert</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Availability</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>6 months</p>
                                            </div>
                                        </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Your Bio</label><br/>
                                        <p>Your detail description</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- PRODUTOS -->
                        <div  class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane" id="produtos" role="tabpanel" aria-labelledby="produtos-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>produtos</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>LOL</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Hourly Rate</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>10$/hr</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Total Projects</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>230</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>English Level</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Expert</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Availability</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>6 months</p>
                                            </div>
                                        </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Your Bio</label><br/>
                                        <p>Your detail description</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ENCOMENDAS -->
                        <div  class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane" id="encomendas" role="tabpanel" aria-labelledby="encomendas-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>encomendas</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>LOL</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Hourly Rate</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>10$/hr</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Total Projects</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>230</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>English Level</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Expert</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Availability</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>6 months</p>
                                            </div>
                                        </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Your Bio</label><br/>
                                        <p>Your detail description</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>           
        </div>
    <?php

        include("includes/footer.php")
    
    ?>
    </div>
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
</body>