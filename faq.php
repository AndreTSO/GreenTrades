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
                <div class="faq_area section_padding_130" id="faq">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12 col-sm-8 col-lg-6">
                                <!-- Section Heading-->
                                <div class="section_heading text-center wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                                    <h3><span>Frequently </span> Asked Questions</h3>
                                    <p>Appland is completely creative, lightweight, clean &amp; super responsive app landing page.</p>
                                    <div class="line"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <!-- FAQ Area-->
                            <div class="col-12 col-sm-10 col-lg-8">
                                <div class="accordion faq-accordian" id="faqAccordion">
                                    <div class="card border-0 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                                        <div class="card-header" id="headingOne">
                                            <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">How can I install this app?<span class="lni-chevron-up"></span></h6>
                                        </div>
                                        <div class="collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#faqAccordion">
                                            <div class="card-body">
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto quidem facere deserunt sint animi sapiente vitae suscipit.</p>
                                                <p>Appland is completely creative, lightweight, clean &amp; super responsive app landing page.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border-0 wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
                                        <div class="card-header" id="headingTwo">
                                            <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">The apps isn't installing?<span class="lni-chevron-up"></span></h6>
                                        </div>
                                        <div class="collapse" id="collapseTwo" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                                            <div class="card-body">
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto quidem facere deserunt sint animi sapiente vitae suscipit.</p>
                                                <p>Appland is completely creative, lightweight, clean &amp; super responsive app landing page.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border-0 wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                                        <div class="card-header" id="headingThree">
                                            <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">Contact form isn't working?<span class="lni-chevron-up"></span></h6>
                                        </div>
                                        <div class="collapse" id="collapseThree" aria-labelledby="headingThree" data-parent="#faqAccordion">
                                            <div class="card-body">
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto quidem facere deserunt sint animi sapiente vitae suscipit.</p>
                                                <p>Appland is completely creative, lightweight, clean &amp; super responsive app landing page.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Support Button-->
                                <div class="support-button text-center d-flex align-items-center justify-content-center mt-4 wow fadeInUp" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInUp;">
                                    <i class="lni-emoji-sad"></i>
                                    <p class="mb-0 px-2">Can't find your answers?</p>
                                    <a href="contacts.php"> Contact us</a>
                                </div>
                            </div>
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
    <script src="js/bootstrap.js"></script>
    <script src="cdnjs.cloudflare.com/ajax/libs/flickity/1.0.0/flickity.pkgd.js"></script>
    <script src="js/slides.js"></script>
</body>

</html>