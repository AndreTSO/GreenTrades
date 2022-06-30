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
        include("topo.php")
        ?>
        <div class="page">
            <div class="content">
                <section class="mb-4">

                    <!--Section heading-->
                    <h2 class="h1-responsive font-weight-bold text-center my-4">Contacte-nos</h2>
                    <!--Section description-->
                    <p class="text-center w-responsive mx-auto mb-5">Tem alguma questão? Não hesite em perguntar-nos.
                        </p>

                    <div class="row">

                        <!--Grid column-->
                        <div class="col-md-9 mb-md-0 mb-5">
                            <form id="contact-form" name="contact-form" action="mail.php" method="POST">

                                <!--Grid row-->
                                <div class="row">

                                    <!--Grid column-->
                                    <div class="col-md-6">
                                        <strong><label for="name" class="">Nome</label></strong>
                                        <div class="md-form mb-0">
                                            <input type="text" id="name" name="name" class="form-control">
                                            
                                        </div>
                                    </div>
                                    <br>
                                    <!--Grid column-->

                                    <!--Grid column-->
                                    <div class="col-md-6">
                                        <strong><label for="email" class="">Email</label></strong>
                                        <div class="md-form mb-0">
                                            <input type="text" id="email" name="email" class="form-control">
                                            
                                        </div>
                                    </div>
                                    <br>
                                    <!--Grid column-->

                                </div>
                                <br>
                                <!--Grid row-->

                                <!--Grid row-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong><label for="subject" class="">Tema</label></strong>
                                        <div class="md-form mb-0">
                                            <input type="text" id="subject" name="subject" class="form-control">
                                            
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <br>
                                <!--Grid row-->

                                <!--Grid row-->
                                <div class="row">

                                    <!--Grid column-->
                                    <div class="col-md-12">
                                        <strong><label for="message">A sua Mensagem</label></strong>
                                        <div class="md-form">
                                            <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea"></textarea>
                                            
                                        </div>

                                    </div>
                                    
                                </div>
                                <br>
                                <!--Grid row-->

                            </form>
                            <br>
                            <hr>

                            <div class="text-center text-md-left">
                                <button class="btnUser"><a class="" onclick="document.getElementById('contact-form').submit();">Enviar</a></button>
                            </div>
                            <div class="status"></div>
                        </div>
                        <!--Grid column-->

                        <!--Grid column-->
                        <div class="col-md-3 text-center">
                            <ul class="list-unstyled mb-0">
                                <li><i class="ti-world" style="font-size: 20px;"></i>
                                    <p>Lisboa, Portugal</p>
                                </li>

                                <li><i class="ti-mobile" style="font-size: 20px;"></i>
                                    <p>+35121345676</p>
                                </li>

                                <li><i class="ti-email" style="font-size: 20px;"></i>
                                    <p>contacto@greentrades.com</p>
                                </li>
                            </ul>
                        </div>
                        <!--Grid column-->

                    </div>

                </section>
                <!--Section: Contact v.2-->

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