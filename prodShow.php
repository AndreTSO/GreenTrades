<!DOCTYPE html>
<html lang="pt">

<head>
    <?php
    require_once("includes/config.php");
    require_once("classes/produto.php");
    require_once("classes/fornecedor.php");
    require_once("classes/comentarios.php");
    require_once("classes/user.php");


    $ctrlProd = new produto($db);
    $ctrlFornecedor = new fornecedor($db);
    $ctrlComentarios = new comentarios($db);
    $ctrlUser = new user($db);
    if (!isset($_GET['q'])) {
        header("Location: index.php");
    }


    if(isset($_POST['idprodutoComentario'])){
        $insere =  $ctrlComentarios -> criaComentario($_POST['nif'], $_POST['idprodutoComentario'], $_POST['estrelas'], $_POST['comentario']);
    }

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


    <script src="js/cute-alert.js"></script>
    <script src="js/extraFunctions.js"></script>

    <script>
        function addArtigoCesto(args) {
            let logged = "<?php echo (isset($_SESSION['nif']) ? $_SESSION['nif'] : "NOT") ?>";

            if (logged != "NOT") {
                //BD CESTO
                //AJAX LINDO E MARAVILHOSO
                $.ajax({
                    type: "POST",
                    url: 'ajax_encomenda.php',
                    data: {
                        codigo: 1,
                        idArtigo: args,
                        quantidade: 1
                    },
                    dataType: "html",
                    success: function(data) {
                        if (data == 99) { // 99  == sucesso
                            msgAlert("Produto adicionado ao cesto de compras");
                        } else {
                            msgAlert("Erro ao adicionar ao cesto de compras");
                        }
                    }
                });
            } else {
                //COOKIES CESTO
                //JAVASCRIPT FEIO E HORRIVEL
                if (checkCoookie("cesto")) {
                    let artigo = "";
                    valor = getCookie("cesto");

                    artigos = valor.split("@");
                    let Encontrei = false;
                    let novo = "";
                    for (let i = 0; i < artigos.length - 1; i++) {

                        let conjunto = artigos[i].split(":");
                        if (conjunto[0] == args) {
                            //Encontrei um artigo que já existe no cesto
                            Encontrei = true;
                            novo = novo + "" + conjunto[0] + ":" + (parseInt(conjunto[1]) + 1) + "@";
                        } else {
                            novo = novo + "" + artigos[i] + "@";
                        }
                    }
                    if (!Encontrei) {
                        novo = novo + args + ":1@";
                    }
                    setCookie("cesto", novo, 30);
                } else {
                    let artigo = args + ":1@";
                    setCookie("cesto", artigo, 30);
                }
                msgAlert("Produto adicionado ao cesto de compras");
            }


        }

        function wc() { // Wipe Cesto
            eraseCookie("cesto");
        }


        function checkCoookie(arg) {
            let username = getCookie(arg);

            if (username != null) {
                return true;
            } else {
                return false;
            }
        }

        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ')
                    c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0)
                    return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        function eraseCookie(name) {
            document.cookie = name + '=; Max-Age=-99999999;';
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
                <div class="container">
                    <!-- product -->
                    <div class="product-content product-wrap clearfix product-deatil">
                        <div class="row">

                            <?php
                            $artigo = $ctrlProd->getTodosOsDados($_GET['q']);


                            if ($artigo != null) {
                                $allImg = $ctrlProd->getImg($_GET['q']);
                                echo '<div class="col-md-5 col-sm-12 col-xs-12">';
                                    echo '<div class="product-image">';
                                        echo '<div id="myCarousel" class="carousel slide">';
                                            echo '<ol class="carousel-indicators">';
                                                $x = 0;
                                                // foreach ($allImg as $imagem){
                                                //     echo '<li data-target="#myCarousel-2" data-slide-to="'.$x.'" class="active"></li>';
                                                //     $x++;
                                                // }
                                                // echo '<li data-target="#myCarousel-2" data-slide-to="0" class=""></li>';
                                                // echo '<li data-target="#myCarousel-2" data-slide-to="1" class=""></li>';
                                                // echo '<li data-target="#myCarousel-2" data-slide-to="2" class=""></li>';
                                            echo '</ol>';
                                
                                echo '<div class="carousel-inner">';
                                foreach ($allImg as $imagem) {
                                    echo '<div class="mySlides">';
                                    
                                        echo"<img src='images/IMG_PRODUTOS/" . $imagem . "' widht='250px;' height='250px'/>";
                                     
                                    echo'</div>';

                                    // echo '<div class="item">';
                                    // echo "<img src='images/IMG_PRODUTOS/" . $imagem . "' widht='200px;' height='200px;'/>";
                                    // echo '</div>';
                                }
                                echo '<a class="prev" onclick="plusSlides(-1)">&#10094;</a>';
                                echo '<a class="next" onclick="plusSlides(1)">&#10095;</a>';
                                // echo '<a class="left carousel-control" href="#myCarousel-2" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> </a>';
                                // echo '<a class="right carousel-control" href="#myCarousel-2" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> </a>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';



                                echo '<div class="col-md-6 col-md-offset-1 col-sm-12 col-xs-12">';
                                    echo '<h2 class="name">';
                                        echo "" . $artigo['nome'] . "<br>";
                                        

                                        echo '<small>Fornecedor <a href="javascript:void(0);">'.$ctrlFornecedor->getTodosOsDados(($artigo['idFornecedor']))["nomeEmpresa"].'</a></small>';
                                        
                                        $estrelas = $ctrlComentarios->getStarsValue($_GET['q']);
                                        if ($estrelas != 0){
                                            $estrelas = explode(":", $estrelas);
                                        }else{
                                            $estrelas = array();
                                            $estrelas[0]=0;
                                            $estrelas[1]=0;
                                        }

                                        for ($i=0; $i < 5; $i++) { 
                                            if (intval($estrelas[0]+0.5) > $i){
                                                echo '<i class="fa fa-star fa-2x text-primary"></i>';
                                            }else{
                                                echo '<i class="fa fa-star fa-2x text-muted"></i>'; 
                                            }
                                        }
                                        echo '<span class="fa fa-2x"><h5> &nbsp;'.$estrelas[1].' Comentarios</h5></span>';
                                       /*  echo '<a href="javascript:void(0);">109 </a>'; */
                                    echo '</h2>';
                                    echo '<hr>';

                                    echo '<h3 class="price-container">';
                                        echo '<strong>'.number_format(($artigo['precoSemIva']+(($artigo['precoSemIva']*$artigo['tipoIVA']/100))), 2, '.', ''). '€ </strong>';
                                        echo '<small>   Iva Incluido</small>';
                                    echo '</h3>';

                                    

                                    echo '<hr>';

                                    echo '<div class="description description-tabs">';
                                        echo '<ul id="myTab" class="nav nav-pills">';
                                            echo '<li class=""><a href="#more-information" data-toggle="tab" class="no-margin">Descrição do produto </a></li>';
                                            echo '<li class=""><a href="#specifications" data-toggle="tab" class="no-margin">Poluição</a></li>';
                                            echo '<li class=""><a href="#reviews" data-toggle="tab" class="no-margin">Criticas</a></li>';
                                        echo '</ul>';
                                        echo '<div id="myTabContent" class="tab-content">';
                                            echo '<div class="tab-pane active in" id="more-information">';
                                                echo '<br>';
                                                echo '<strong>Descrição</strong>';
                                                echo '<p>';
                                                echo $artigo['descricao'];
                                                echo '</p>';
                                            echo '</div>';
                                            echo '<div class="tab-pane" id="specifications">';
                                                echo '<br>';
                                                echo '<strong>Em desenvolvimento</strong><br>';
                                                echo '<d1 class="">';
                                                    echo $artigo['tags'];
                                                echo '</d1>';
                                            echo '</div>';
                                            echo '<div class="tab-pane" id="reviews">';
                                                if (isset($_SESSION['nif'])){
                                                echo '<br>';
                                                echo '<form method="post" class="well padding-bottom-10" action="prodShow.php?q='.$_GET['q'].'">';
                                                    echo '<textarea rows="2" name="comentario" class="form-control" required placeholder="Escreva uma critica deste produto"></textarea>';
                                                    echo '<div class="margin-top-10">';
                                                        echo "<input type='hidden' name='nif' value='".$_SESSION['nif']." '>";
                                                        echo "<input type='hidden' name='idprodutoComentario' value='".$_GET['q']." '>";
                                                        echo 'Estrelas: <input type="number" name="estrelas" required class="form-control" value="5" max="5" min="1" style="width:50px;"> ';
                                                        echo '<button type="submit" class="btnUser pull-right">Comentar</button><br><br><br>';    
                                                    echo '</div>';
                                                echo '</form>';

                                                $comentarios = $ctrlComentarios->getComentarios($_GET['q']);
                                                
                                                    echo '<div class="chat-body no-padding profile-message">';
                                                        echo '<ul>';
                                                        foreach ($comentarios as $comentario){
                                                            echo '<li class="message">';
                                                              
                                                               echo ' <span class="message-text">
                                                                    <a href="javascript:void(0);" class="username">';
                                                                    $nome = $ctrlUser->getTodosOsDados($comentario['idUser'])['nome'];
                                                                        echo '<strong><em>'.$nome.'</em></strong>
                                                                        
                                                                        <span class="pull-right">';
                                                                        for ($i=0; $i < 5; $i++) { 
                                                                            if (intval($comentario['estrelas']+0.5) > $i){
                                                                                echo '<i class="fa fa-star fa-2x text-primary"></i>';
                                                                            }else{
                                                                                echo '<i class="fa fa-star fa-2x text-muted"></i>'; 
                                                                            }
                                                                        }
                                                                        echo '</span>
                                                                    </a>
                                                                    

                                                                    '.$comentario['comentario'].' <br><strong><em>Data</em></strong> '.$comentario['data'].'
                                                                </span>';
                                                                
                                                            echo '</li>';
                                                        }
                                                        echo '</ul>';
                                                    echo '</div>';
                                                

                                            echo '</div>';
                                                }else{
                                                    echo "Tem de estar autenticado para poder comentar!<br>";
                                                    echo "<a href='login.php'>Autentica ?</a>";
                                                }
                                        echo '</div>';
                                    echo '</div>';
                                    echo '<hr>';
                                    echo '<div class="row">';
                                        echo '<div class="but col-sm-12 col-md-6 col-lg-6">';
                                            echo "<button class='btnUser' onclick='addArtigoCesto(" . $_GET['q'] . ")'> Adicione ao Cesto</button>";
                                        echo '</div>';
                                        echo '<div class="but col-sm-12 col-md-6 col-lg-6">';
                                            echo '<div class="btn-group pull-right">';
                                                echo '<button class="btnUser"></i>Adicionar aos favoritos</button>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';

                                
                                echo '</div>';





                                // OPEN ME PLEASE
                                //                         https://prnt.sc/CIes0h5odubT


                                // ignorem o modo de venda
                                // tipo e tags deixem para nós .. metao só a aparecer o valor(1.. 2 ou 3 ) que depois nos fazemos a pesquisa da categoria pai, e subcategoria

                                
                                







                                //SE a pessoa que está a ver o produto for oWNER do produto tambem pode editar 
                                if (isset($_SESSION['nif']) && ($artigo['idFornecedor'] == $_SESSION['nif'])) {
                                    echo "
                                    <form METHOD = 'POST' ACTION='editarProduto.php'>
                                        <input type='hidden' value='" . $artigo['idProduto'] . "' name='idProduto'>
                                        <input class='btnUser' type='submit' value='Editar' style='padding: 10%;'>
                                    
                                    </form>
                                
                                
                                
                                ";
                                }
                            } else {
                                echo "Nenhum artigo encontrado";
                            }
                            
                            ?>


                            <?php
                            // $artigo = $ctrlProd->getTodosOsDados($_GET['q']);
                            // if ($artigo != null) {
                            //     echo "Nome do Artigo: " . $artigo['nome'] . "<br> <br>";

                            //     // OPEN ME PLEASE
                            //     //                         https://prnt.sc/CIes0h5odubT


                            //     // ignorem o modo de venda
                            //     // tipo e tags deixem para nós .. metao só a aparecer o valor(1.. 2 ou 3 ) que depois nos fazemos a pesquisa da categoria pai, e subcategoria

                            //     echo "FRONT END PLEASE DO THE REPRESENTATION, THANKS <br><br><br><br>";

                            //     $allImg = $ctrlProd->getImg($_GET['q']);
                            //     foreach ($allImg as $imagem) {
                            //         echo "<img src='images/IMG_PRODUTOS/" . $imagem . "' widht='200px;' height='200px;'/>";
                            //     }


                            //     echo "<br><br><br><button class='btnUser' onclick='addArtigoCesto(" . $_GET['q'] . ")'> Adicione ao Cesto</button>";


                            //     //SE a pessoa que está a ver o produto for oWNER do produto tambem pode editar 
                            //     if (isset($_SESSION['nif']) && ($artigo['idFornecedor'] == $_SESSION['nif'])) {
                            //         echo "
                            //         <form METHOD = 'POST' ACTION='editarProduto.php'>
                            //             <input type='hidden' value='" . $artigo['idProduto'] . "' name='idProduto'>
                            //             <input type='submit' value='Editar'>
                                    
                            //         </form>
                                
                                
                                
                            //     ";
                            //     }
                            // } else {
                            //     echo "Nenhum artigo encontrado";
                            // }
                            ?>
                        </div>
                    </div>




                    

                </div>
            </div>
        </div>

        <?php

            include("includes/footer.php")

        ?>


    </div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="cdnjs.cloudflare.com/ajax/libs/flickity/1.0.0/flickity.pkgd.js"></script>
<script src="js/slides.js"></script>
<script src="js/img.js"></script>

</html>