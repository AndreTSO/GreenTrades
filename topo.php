<?php

require_once("classes/lib.php");

$ctrllib=new lib($db);
?>
<div class="top">
        <header class="header shop">
            <div class="topbar">
                <div class="login">
                    

                    <?php
                        if (isset($_SESSION['nif'])){
                            echo "<p class='bemVindo'>Bem vindo ";
                            echo $_SESSION['nome'];
                            echo "</p>";
                            echo "<a href='landpage.php' class='btnn1'><i class='ti-home'></i></a>";
                            echo "<a href='ajax_user.php?codigo=4' class='btnn1'><i class='ti-power-off'></i></a>";
                            echo '<a href="cesto.php" class="btnn1"><script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/aoggitwj.json"
                                trigger="click"
                                colors="primary:#ffffff"
                                style="width:25px;height:25px">
                            </lord-icon></i></a>';
                            
                            
                        }else{
                            echo '<a href="login.php" class="btnn1"><script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/dklbhvrt.json"
                                trigger="click"
                                colors="primary:#ffffff"
                                style="width:25px;height:25px">
                            </lord-icon> </a>';
                            echo "<a href='registar.php' class='btnn1'><i class='ti-pencil'></i></a>";
                            echo '<a href="cesto.php" class="btnn1"><script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/aoggitwj.json"
                                trigger="click"
                                colors="primary:#ffffff"
                                style="width:25px;height:25px">
                            </lord-icon></i></a></a>';
                        }
                    
                    
                    
                    ?>





                </div>
                <div class="logo">
                    <a href="index.php"><img src="images/logo1.png" alt="logo" style="width: 85%; height: 100%; margin-top: 0px;"></a>
                </div>
                <form action="pesquisar.php">
                <div class="search-bar-top">
                    <div class="search-bar">
                        <select class = ' nice-select open' name='categoria'>
                        <?php
                             $resultado=$ctrllib->getCategoria($db);
                             echo "<option value=''>Todas as Categorias</option>";
                             if ($resultado && $resultado->RecordCount()>0){
                                
                                while ($linha=$resultado->FetchRow()){
                                    echo "<option value='".$linha['idCategoria']."'>".$linha['categoria']."</option>";
                                   
                               }
                             }
                             
                            	
                        
				        ?>
                        </select>

                            <input name="pesquisa" placeholder="Search Products Here....." type="search">
                            <button type="submit" class="btnn"><i class="ti-search"></i>
                        </form>
                    </div>
                </div>
            </div>
        </header>
		<div id="navbar">
            <a href="index.php" class="btn-hover">Inicio</a>
            <a href="pesquisar.php" class="btn-hover">Todos</a>
            <a href="pesquisar.php" class="btn-hover">Novos</a>
            <a href="pesquisar.php" class="btn-hover">Em Promoção</a>
            <a href="pesquisar.php" class="btn-hover">Em Destaque</a>						
            <!-- <a href="contacts.php" class="btn-hover">Contactos</a>                             -->
        </div>
</div>