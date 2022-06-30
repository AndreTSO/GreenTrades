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
                    <a href="login.php"><i class="ti-user"></i></a>
                </div>
                <div class="cart">
                    <a href="#" class="single-icon"><i class="ti-bag"></i> <span class="total-count">2</span></a>
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
                



                <!-- <div class="right-bar">
                    <div class="top-user"><a href="#0"><i class="ti-search"></i></a></div>

                   <div class="sinlge-bar shopping">
                        <a href="#" class="single-icon"><i class="ti-bag"></i> <span class="total-count">2</span></a>
                        <div class="shopping-item">
                            <div class="dropdown-cart-header">
                                <span>2 Items</span>
                                <a href="#">View Cart</a>
                            </div>
                            
                            <div class="bottom">
                                <div class="total">
                                    <span>Total</span>
                                    <span class="total-amount">$00.00</span>
                                </div>
                                <a href="checkout.php" class="btn animate">Checkout</a>
                            </div>
                        </div>
                        
                    </div> 

                </div>  -->
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

        <!-- Slideshow container -->
        <div class="slideshow-container">

            <!-- Full-width images with number and caption text -->
            <div class="mySlides fade">
                <div class="numbertext">1 / 3</div>
                    <img class="sldImg" src="images/boa.jpg" style="width:100%">
                <div class="text">Caption Text</div>
            </div>
  
            <div class="mySlides fade">
                <div class="numbertext">2 / 3</div>
                    <img class="sldImg" src="images/cover2.jpg" style="width:100%">
               <div class="text">Caption Two</div>
            </div>
  
            <div class="mySlides fade">
                <div class="numbertext">3 / 3</div>
                    <img class="sldImg" src="images/WTF.jpg" style="width:100%">
                <div class="text">Caption Three</div>
            </div>
  
            <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>
  
        <!-- The dots/circles -->
        <!-- <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div> -->

        <div class="content">
            <div class="trending">

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