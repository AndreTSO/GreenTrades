<!DOCTYPE html>
<html lang="pt">
<head>    
	<?php 
		include("includes/config.php");
	?>

</head>
<body class="js">


        <?php

            include 'showMsg.php';
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
		

		

	
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
</body>
