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
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/font-awesome.css">
        <link rel="stylesheet" href="css/themify-icons.css">
        <link rel="stylesheet" href="css/cuteAlertstyle.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="js/cute-alert.js"></script>
        <script src="js/extraFunctions.js"></script>

        <script>
            let area1=true;
            let area2=true;
            setInterval(function() {

                $("#Carrosel1")
                    .mouseenter(function() {
                        area1=false;
                    })
                    .mouseleave(function() {
                        area1=true;
                    });
                $("#Carrosel2")
                    .mouseenter(function() {
                        area2=false;
                    })
                    .mouseleave(function() {
                        area2=true;
                    });


                if(area1) {
                    $('#zone1').toggle(0);
                    $('#zone2').toggle(0);
                }
                if(area2) {
                    $('#zone3').toggle(0);
                    $('#zone4').toggle(0);
                }
		    }, 5000); //5 seconds

 


            function addArtigoCesto(args){
                let logged = "<?php echo (isset($_SESSION['nif'])?$_SESSION['nif']:"NOT")?>";

                if (logged!="NOT"){
                    //BD CESTO
                    //AJAX LINDO E MARAVILHOSO
                    $.ajax({
                        type: "POST",
                        url: 'ajax_encomenda.php',
                        data: {codigo: 1, idArtigo: args, quantidade: 1},
                        dataType: "html",
                        success: function (data){
                                if (data==99) { // 99  == sucesso
                                    msgAlert("Produto adicionado ao cesto de compras");
                                }else{
                                    msgAlert("Erro ao adicionar ao cesto de compras");
                                }
                            }
                    });
                }else{
                    //COOKIES CESTO
                    //JAVASCRIPT FEIO E HORRIVEL
                    if (checkCoookie("cesto")){
                        let artigo="";
                        valor = getCookie("cesto");

                        artigos = valor.split("@");
                        let Encontrei = false;
                        let novo = "";
                        for (let i = 0; i < artigos.length-1; i++) {

                            let conjunto = artigos[i].split(":");
                            if (conjunto[0] == args){
                                //Encontrei um artigo que já existe no cesto
                                Encontrei = true;
                                novo=novo+""+conjunto[0]+":"+(parseInt(conjunto[1])+1)+"@";
                            }else{
                                novo=novo+""+artigos[i]+"@";
                            }
                        }
                        if (!Encontrei){
                            novo=novo+args+":1@";
                        }
                        setCookie("cesto", novo, 30);
                    }else{
                        let artigo = args+":1@";
                        setCookie("cesto", artigo, 30);
                    }
                    msgAlert("Produto adicionado ao cesto de compras");
                }

               
            }

            function wc(){ // Wipe Cesto
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

            function setCookie(name,value,days) {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days*24*60*60*1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "")  + expires + "; path=/";
            }
            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for(var i=0;i < ca.length;i++) {
                    var c = ca[i];
                    while (c.charAt(0)==' ') 
                        c = c.substring(1,c.length);
                    if (c.indexOf(nameEQ) == 0) 
                        return c.substring(nameEQ.length,c.length);
                }
                return null;
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
                    <div class="presentation">
                        <h1> Bem Vindo à GreenTrades</h1>
                        <h3> Diminua o seu impacto enquanto faz as suas compras.</h3>
                        <p>Ao efectuar as suas compras no nosso site não só terá acesso aos melhores e mais recentes produtos <br>
                            disponiveis no mercado, como terá acesso aos níveis de poluição causada pelo transporte <br>
                            e armazenamento dos produtos. <br>
                            Desta maneira pode tomar a decisão mais acertada e reduzir a pegada ecológica.</p>
                    </div>

                    
                    <div class="trending carousel" id="Carrosel1">
                        <!--<div class="carousel__arrows">
                            <span class="left ti-angle-left"></span>
                            <span class="right ti-angle-right"></span>
                        </div> -->
                        <h1 class="title"> Produtos em destaque</h1>
                       
                        <ul class="carousel__item" id="zone1">
                            <?php 
                                $artigos = $ctrlProd->getRandomProducts();

                                foreach(array_slice($artigos, 0, 4) as $artigo){
                                    echo "<li class='prdt'>";
                                        echo "<div  style='cursor: pointer;' class='showPrdt'>";
                                        echo "<a href='prodShow.php?q=".$artigo['idProduto']."' target='_blank'><img class='imgPrdt' src='images/IMG_PRODUTOS/Art".$artigo['idProduto']."ID0.png'/></a>";
                                        echo "</div>";
                                        echo "<p>".$artigo['nome']."</p>";
                                        echo "<p>".number_format(($artigo['precoSemIva']+(($artigo['precoSemIva']*$artigo['tipoIVA']/100))), 2, '.', '')."€</p>";
                                        echo "<button class='btnAddCesto' onclick='addArtigoCesto(".$artigo['idProduto'].")'> Adicione ao Cesto</button>";
                                    echo "</li>";
                                }
                            ?>
                        </ul>
                        <ul class="carousel__item" id="zone2" display:none>
                            <?php 
                                //Remover os 4 anteriores
                                foreach(array_slice($artigos, 4, 8) as $artigo){
                            

                                    echo "<li class='prdt'>";
                                        echo "<div  style='cursor: pointer;' class='showPrdt'>";
                                        echo "<a href='prodShow.php?q=".$artigo['idProduto']."' target='_blank'><img class='imgPrdt' src='images/IMG_PRODUTOS/Art".$artigo['idProduto']."ID0.png'/></a>";
                                        echo "</div>";
                                        echo "<p>".$artigo['nome']."</p>";
                                        echo "<p>".number_format(($artigo['precoSemIva']+(($artigo['precoSemIva']*$artigo['tipoIVA']/100))), 2, '.', '')."€</p>";
                                        echo "<button class='btnAddCesto' onclick='addArtigoCesto(".$artigo['idProduto'].")'> Adicione ao Cesto</button>";
                                    echo "</li>";

                                }
                            ?>
                            
                        </ul>
                        <!--
                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                            -->
                    
                    </div>
                    
                    <div class="new carousel" id="Carrosel2">
                        <h1 class="title"> Produtos em destaque</h1>
                        
                        <ul class="carousel__item" id="zone3">
                            <?php 
                                $artigos = $ctrlProd->getRandomProducts();

                                foreach(array_slice($artigos, 0, 4) as $artigo){

                                    echo "<li class='prdt'>";
                                        echo "<div  style='cursor: pointer;' class='showPrdt'>";
                                        echo "<a href='prodShow.php?q=".$artigo['idProduto']."' target='_blank'><img class='imgPrdt' src='images/IMG_PRODUTOS/Art".$artigo['idProduto']."ID0.png'/></a>";
                                        echo "</div>";
                                        echo "<p>".$artigo['nome']."</p>";
                                        echo "<p>".number_format(($artigo['precoSemIva']+(($artigo['precoSemIva']*$artigo['tipoIVA']/100))), 2, '.', '')."€</p>";
                                        echo "<button class='btnAddCesto' onclick='addArtigoCesto(".$artigo['idProduto'].")'> Adicione ao Cesto</button>";
                                    echo "</li>";

                                }
                            ?>
                        </ul>
                        <ul class="carousel__item" id="zone4" display:none>
                            <?php 
                                //Remover os 4 anteriores
                                foreach(array_slice($artigos, 4, 8) as $artigo){
                            

                                    echo "<li class='prdt'>";
                                        echo "<div  style='cursor: pointer;' class='showPrdt'>";
                                        echo "<a href='prodShow.php?q=".$artigo['idProduto']."' target='_blank'><img class='imgPrdt' src='images/IMG_PRODUTOS/Art".$artigo['idProduto']."ID0.png'/></a>";
                                        echo "</div>";
                                        echo "<p>".$artigo['nome']."</p>";
                                        echo "<p>".number_format(($artigo['precoSemIva']+(($artigo['precoSemIva']*$artigo['tipoIVA']/100))), 2, '.', '')."€</p>";
                                        echo "<button class='btnAddCesto' onclick='addArtigoCesto(".$artigo['idProduto'].")'> Adicione ao Cesto</button>";
                                    echo "</li>";

                                }
                            ?>
                            
                        </ul>
                        <!-- <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a> -->

                    
                    </div>
                    
                    
                    
                    <div class="categories">
                        <h3>Veja também as nossas diversas categorias</h3>
                        <div class="category-1">
                            Desporto e Ar Livre
                            <?php 

                            ?>
                        </div>
                        <div class="category-2">

                        </div>
                        <div class="category-3">

                        </div>
                    </div>
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