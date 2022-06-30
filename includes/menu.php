<?php 


    echo "<ul>";
        if (isset($_SESSION['nif'])){}
            echo "<a href='RAW_userAccount.php'> <li>Conta Pessoal</li></a>";
            echo "<a href='ajax_user.php?codigo=4'> <li>Sair</li></a>";
        }else{
            echo "<a href='RAW_userAccount.php'> <li>Conta Pessoal</li></a>";
            echo "<a href='ajax_user.php?codigo=4'> <li>Sair</li></a>";
        }
    
    echo "</ul>
        
    <br><br><br>";





?>