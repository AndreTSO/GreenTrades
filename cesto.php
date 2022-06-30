<!DOCTYPE html>
<?php
require_once("includes/config.php");

require_once("classes/produto.php");

$ctrlProd = new produto($db);

?>
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
    <link rel="stylesheet" href="css/cesto.css">
    <link rel="stylesheet" href="css/botoes.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <script>
        function wc() { // Wipe Cesto
            eraseCookie("cesto");
            location.reload();
        }

        function eraseCookie(name) {
            document.cookie = name + '=; Max-Age=-99999999;';
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
                <div class="contentTitle">
                    <h2>O seu Cesto</h2>
                    <hr class="middle">
                </div>
                <br>
                <br>
                <div class="pb-5 mt-n2 mt-md-n3">
                    <div class="row">
                        <div class="wdth col-xl-9 col-md-8">
                            <!-- <h2 class="h6 d-flex flex-wrap justify-content-between align-items-center px-4 py-3 bg-secondary"><span>Products</span><a class="font-size-sm" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left" style="width: 1rem; height: 1rem;"><polyline points="15 18 9 12 15 6"></polyline></svg>Continue shopping</a></h2> -->
                            <!-- Item-->
                            <?php
                            if (isset($_SESSION['nif'])) {
                                //easy, check database for articles in the ptr_cesto with user nif
                                //How about we build a product matrix, and after this we represent it(COMMON)
                                require_once 'classes/consumidor.php';
                                $ctrlConsumidor = new consumidor($db, $_SESSION['nif']); // Vamos assumir que fizeste kitete neh leo ... esta classe requer um nif...
                                $resultadoBDGROSSO = $ctrlConsumidor->getArtigosCesto();

                                if ($resultadoBDGROSSO && $resultadoBDGROSSO->RecordCount() > 0) {
                                    $cestoSplited = array();
                                    while ($linha = $resultadoBDGROSSO->FetchRow()) {
                                        array_push($cestoSplited,  $linha['idArtigo'] . ":" . $linha['quantidade']);
                                    }
                                }
                            } else {
                                //we gonna get local cookies, i must cry.. hard
                                //How about we build a product matrix, and after this we represent it(COMMON)
                                if (isset($_COOKIE["cesto"])) {
                                    $cestoGrosso = $_COOKIE["cesto"];
                                    $cestoSplited = explode("@", $cestoGrosso);
                                    array_pop($cestoSplited); // Retirar a ultima posiçao porque nao tem nada

                                }
                            }
                            // PARTE COMUN

                            $valorFinal = 0;
                            $valorIva = 0;
                            $quanti = 0;
                            $valor = 0;
                            if (isset($cestoSplited)) {

                                foreach ($cestoSplited as $artigo) {
                                    $artigo = explode(":", $artigo);
                                    $productProperties = $ctrlProd->getTodosOsDados($artigo[0]);
                                    $valor = $valor + $productProperties['precoSemIva'] * $artigo[1];
                                    $quanti = $quanti + $artigo[1];
                                    $valorFinal = $valorFinal + (($artigo[1]) * (($productProperties['precoSemIva']) + ($productProperties['precoSemIva'] * ($productProperties['tipoIVA'] / 100))));
                                    $valorIva = $valorIva + (($artigo[1]) * ($productProperties['precoSemIva'] * ($productProperties['tipoIVA'] / 100)));
                                    echo " <div class='d-sm-flex justify-content-between my-4 pb-4 border-bottom'>
                                                <div class='media d-block d-sm-flex text-center text-sm-left'>
                                                    <a class='cart-item-thumb mx-auto mr-sm-4' href='prodShow?q=" . $productProperties['idProduto'] . "'><img src ='images/IMG_PRODUTOS/Art" . $artigo[0] . "ID0.png' width='100px;' height='100px;' alt='Product'></a>
                                                    <div class='media-body pt-3'>
                                                        <h3 class=' product-card-title  border-0 pb-0'><a class='prdtTitle' href='prodShow?q=" . $productProperties['idProduto'] . "'>" . $productProperties['nome'] . "</a></h3>";
                                    //<div class='font-size-sm'><span class='text-muted mr-2'>Size:</span>8.5</div>
                                    //<div class='font-size-sm'><span class='text-muted mr-2'>Color:</span>Black</div>
                                    echo            "<div class='green font-size-lg text-primary pt-2'>Unidade: " . number_format(((1) * ($productProperties['precoSemIva'] + $productProperties['precoSemIva'] * ($productProperties['tipoIVA'] / 100))), 2, '.', '') . "€ </div>";
                                    echo            "<div class='green font-size-lg text-primary pt-2'>Total: " . number_format((($artigo[1]) * ($productProperties['precoSemIva'] + $productProperties['precoSemIva'] * ($productProperties['tipoIVA'] / 100))), 2, '.', '') . "€</div>
                                                    </div>
                                                </div>
                                                <div class='pt-2 pt-sm-0 pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left' style='max-width: 10rem;'>
                                                    <div class='form-group mb-2'>
                                                        <label for='quantity1'>Quantidade</label>
                                                        <input class='form-control form-control-sm' type='number' id='quantity1' value='" . $artigo[1] . "'>
                                                    </div>
                                                    <button class='btnUser  btn-sm btn-block mb-2' type='button' style='padding:5%;'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-refresh-cw mr-1'>
                                                            <polyline points='23 4 23 10 17 10'></polyline>
                                                            <polyline points='1 20 1 14 7 14'></polyline>
                                                            <path d='M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15'></path>
                                                        </svg>Actualizar</button>
                                                    <button class='btnRemove btn-outline-danger btn-sm btn-block mb-2' type='button'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-trash-2 mr-1'>
                                                            <polyline points='3 6 5 6 21 6'></polyline>
                                                            <path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path>
                                                            <line x1='10' y1='11' x2='10' y2='17'></line>
                                                            <line x1='14' y1='11' x2='14' y2='17'></line>
                                                        </svg>Remover</button>
                                                </div>
                                            </div>";
                                }
                            } else {
                                echo "O seu cesto encontra-se vazio, <a href='index.php'> Começar a comprar ?</a><br><br><br>";
                            }


                            ?>

                        </div>
                        <!-- Sidebar-->
                        <div class="sideBar1 col-xl-3 col-md-4 pt-3 pt-md-0">
                            <h2 class="subtotal h6 px-4 py-3 bg-secondary text-center">Subtotal</h2>
                            <div class="h3 font-weight-semibold text-center py-3"><?php echo number_format($valorFinal, 2, '.', ''); ?>€</div>
                            <hr>

                            

                            <form method="POST" action="procedeToCheckout.php">
                                
                                <input type="hidden" value="<?php echo number_format($valorFinal, 2, '.', ''); ?>" name="valorFinal">
                                <input type="hidden" value="<?php echo number_format($valor, 2, '.', ''); ?>" name="valor">
                                <input type="hidden" value="<?php echo $quanti; ?>" name="quantArtigos">
                                <input type="hidden" value="<?php echo number_format($valorIva, 2, '.', ''); ?>" name="iva">
                                <?php 
                                    if (!(isset($_SESSION['nif']))) {
                                       echo "<a href='login.php'><button type='button' class='btnAvancar btn-primary btn-block'>Autenticar-se</button></a> <br><br>";
                                       echo "<a href='registar.php'><button type='button' class='btnAvancar btn-primary btn-block'>Registar-se</button></a>";
                                    }else{
                                        echo '<h3 class="h6 pt-4 font-weight-semibold"><span class="badge badge-success mr-2">Nota</span>Comentários</h3>';
                                        echo '<textarea class="form-control mb-3" id="order-comments" rows="5" name="aditional"></textarea>';
                                        echo '<input type="submit" value="Avançar" class="btnAvancar btn-primary btn-block" >';
                                    }
                                
                                ?>

                                
                            </form>
                            <br>
                            <?php
                            if (isset($_SESSION['nif'])) {
                            ?>
                                <a href="ajax_encomenda.php?codigo=2">
                                    <button class="btnRemove btn-primary btn-block" style="padding:3%;">Limpar Cesto</button><br>
                                </a>
                            <?php
                            } else {
                            ?>
                                <a href="#" onclick='wc()'>
                                    <button class="btnRemove btn-primary btn-block" style="padding:3%;">Limpar Cesto</button>
                                    <br>
                                </a>
                            <?php
                            }
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





    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="js/navbar.js"></script>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/slides.js"></script>
</body>

</html>