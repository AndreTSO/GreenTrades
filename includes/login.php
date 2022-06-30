


<!--<div class="sinlge-bar">
    <a href="#" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
</div>-->

<?php 

    if (isset($_SESSION["nif"])) {
        
        ?>

        <div class="sinlge-bar">
			<a href="conta.php" class="single-icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i> &nbsp;Conta</a><br>
            <a href="ajax_user?codigo=4" class="single-icon"><i class="fa fa-leave-circle-o" aria-hidden="true"></i> &nbsp;Sair </a>
        </div>


        <?php


    }else{
        ?>

        <div class="sinlge-bar">
            <a href="login.php" class="single-icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i> &nbsp;Entrar </a>
        </div>


        <?php
    }

?>

