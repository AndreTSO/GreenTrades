<?php 


    echo "<ul>";
        if (isset($_SESSION['nif'])){
            echo "<a href='RAW_landpage.php'> <li>Conta Utilizador</li></a>";
            echo "<a href='ajax_user.php?codigo=4'> <li>Sair</li></a>";
            
        }else{
            echo "<a href='RAW_login.php'> <li>Entrar</li></a>";
            echo "<a href='RAW_registar.php'> <li>Registar</li></a>";
            echo "<a href='RAW_cesto.php'> <li>Cesto</li></a>";
        }
    
    echo "</ul>
        
    <br><br><br>";





?>