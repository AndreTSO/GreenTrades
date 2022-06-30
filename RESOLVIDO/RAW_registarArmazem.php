<!DOCTYPE html>
<html lang="pt">
<head>

	<?php 
		include("includes/config.php");
		require_once("classes/lib.php");
		require_once('classes/district.php');
        require_once 'classes/user.php';

		$ctrldistrict=new handlerDistrict();	
		$ctrllib=new lib($db);	
        $ctrlUser=new user($db);

        if (!$ctrlUser->islogged())
	        header('Location: RAW_index.php');
            //EJECT
        if (isset($_SESSION['nif']) ){
            if (!$ctrlUser->isAuthorized(2,$_SESSION['nif'])){
                header('Location: RAW_index.php');
            }
        }



	?>
<script>
    function obtemDistrito(){
        let codigo = $('#distrito option:selected').val();
        $.ajax({
        type: "POST",
        url: 'ajax_district.php',
        data: {distrito: codigo},
        dataType: "html",
        success: function (data){
                if (data) {
                    document.getElementById('conselho2').innerHTML = data;
                }
            }
        });
    }
</script>
</head>


<body>
        
        <?php
                include 'showMsg.php';
        ?>


        <h1>Registo Empresa</h1> 

        <form ACTION = "ajax_fornecedor.php" METHOD = "POST">
            <?php 
                
            echo "<input type='hidden' value='".$_SESSION['nif']."' name='idFornecedor' >";
            echo "<input type='hidden' value='2' name='codigo' >";
            echo "Nome do Armazem: <input type='text' name='nome' value = ''required placeholder='Nome do Armazem'><br>";
            echo "<hr>";
            echo "Morada do Armazem: <input type='text' name='morada' value = ''required placeholder='Morada'><br>";


            ?>
            Codigo Postal:<input id="codPostal" name="codigoPostal"  pattern="\d{4}-\d{3}" title="DDDD-DDD" type="text" required placeholder="">


                <div class="col-12">
										
                    <div class="form-group">
                        <label>Distrito<span>*</span></label>
                    </div>
                    
                    <select name='distrito' id='distrito' onChange='obtemDistrito()' required >
                    <?php
                    $resultado=$ctrldistrict->getDistrict($db);
                    
                    echo "<option value=''>Distrito</option>";
                    if ($resultado && $resultado->RecordCount()>0){
                        
                        while ($linha=$resultado->FetchRow()){
                            echo "<option  value='".$linha['id']."'>".$linha['name']."</option>";
                            
                        }
                    }
                    echo "</select>";	
                
                    
                ?>

            </div>
            <div class="col-12">
                
                <div class="form-group">
                    <label>Concelho<span>*</span></label>
                </div>
                <span id="conselho2">
                    <input type="text" value="" class="formRegist" required placeholder="Escolha o distrito primeiro &#8593;" disabled></input>
                </span>
            </div>
                <br>
                <hr>
            <?php

                echo "Custo de Manutençao do armazem: <input type='number' name='custoManutencao' value = ''required><br>";
                echo "Poluição gerada por este armazem: <input type='number' name='poluicaoGerada' value = ''required ><br>";
                
                echo "Estado do armazem<br>";
                echo "<select name = 'estado'>";
                    $vetorExterno = $ctrllib->getEstados("ARMAZEM");
                    foreach ($vetorExterno as $vetorInterno){
                        echo "<option value=".$vetorInterno['idEstado'].">".$vetorInterno['estado']."</option>";
                    }
                echo "</select><br>";

                echo "Refrigeração<br>";
                echo "<select name = 'refrigeracao'>";
                    echo "<option value=0>Sem Refrigeração</option>";
                    echo "<option value=1>Com Refrigeração</option>";
                echo "</select> <br>";
                echo "<br>";
                echo "<br>";

                
                echo "<input type='submit' value='Criar armazem'> ";
            ?>
            





        </form>

</body>


	<!-- Jquery -->
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
