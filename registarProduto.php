<!DOCTYPE html>
<html lang="pt">
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
    <link rel="stylesheet" href="css/botoes.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/themify-icons.css">

	<?php 
		include("includes/config.php");
		require_once("classes/lib.php");
		require_once('classes/district.php');
        require_once 'classes/user.php';
        require_once 'classes/armazem.php';
   

		$ctrldistrict=new handlerDistrict();	
		$ctrllib=new lib($db);	
        $ctrlUser=new user($db);
        $ctrlArmazens= new armazem($db);


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



        function obtemSubCategoria(){
				let codigo = $('#categoriaPAPI option:selected').val();
                
				$.ajax({
				type: "POST",
				url: 'ajax_categoria.php',
				data: {categoriaPAI: codigo},
				dataType: "html",
				success: function (data){
						if (data) {
							document.getElementById('conselho2').innerHTML = data;
						}
					}
				});
			}

        function SimValidade(){
            $('#validade').html("<input type='date' id='retiraValidade' name='validade' value='' required /><button onclick='NoValidade()' type='button'>Remover</button>");
        }
        function NoValidade(){
            $('#validade').html("<button type='button' onclick='SimValidade()'>Adicionar data de Validade</button>");

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
                <?php
                    include 'showMsg.php';
                ?>
                <h1>Registo Produto</h1> 

                <form ACTION = "inserirImagem.php" METHOD = "POST">
                    <?php 
                
                        echo "<input type='hidden' value='".$_SESSION['nif']."' name='idFornecedor' >";
                        echo "<input type='hidden' value='3' name='codigo' >";
                        echo "<label><strong><em>Nome Produto:&nbsp</em></strong></label> <input type='text' name='nome' value = ''required><br>";
                        echo "<label><strong><em>Descriçao Produto:&nbsp</em></strong></label> <textarea name='descricao' cols='60' value = ''required> </textarea><br>";

                    ?>
                    <label><strong><em>Categoria:&nbsp</em></strong></label>
                    <select name = 'tipo' id = 'categoriaPAPI' onChange='obtemSubCategoria()' required >
                    <?php
                        $resultado=$ctrllib->getCategoria($db);
                    
                        echo "<option value=''>Categoria</option>";
                        if ($resultado && $resultado->RecordCount()>0){
                            while ($linha=$resultado->FetchRow()){
                                echo "<option  value='".$linha['idCategoria']."'>".$linha['categoria']."</option>";
                            
                            }
                        }
                        echo "</select>";	
                
				    ?>
                
                    <span id="conselho2">
                        <br><label><strong><em>SubCategoria:&nbsp</em></strong></label> <input  type="text" name='tags' required placeholder="Escolha a Categoria Primeiro &#8593;" disabled><br>
                    </span>
                    <hr>
                
                    <?php					
            
                
                        //echo "SubCategoria Produto: <input type='text' name='tags' value = ''required><br>"; 
                        echo "<label><strong><em>Preço Produto sem IVA:&nbsp</em></strong></label> <input type='number' name='precoSemIva'  step= '0.01' value ='' required ><br>";
                        echo "<label><strong><em>Tipo de IVA:&nbsp</em></strong></label> 

                        <select name='tipoIVA' required >
                            <option value='23' >Normal - Continente - 23%</option>
                            <option value='22' >Normal - Madeira - 22%</option>
                            <option value='18' >Normal - Açores - 18%</option>
                            <option value='13' >Intermedia - Continente - 13%</option>
                            <option value='12' >Intermedia - Madeira - 12%</option>
                            <option value='9'  >Intermedia - Açores - 9%</option>
                            <option value='6'  >Reduzida - Continente - 6%</option>
                            <option value='5'  >Reduzida - Madeira - 5%</option>
                            <option value='4'  >Reduzida - Açores - 4%</option>
                            <option value='0'  >Isento</option>
                        </select>
        
                        <br>";
                        echo "<label><strong><em>Data de Validade:&nbsp</em></strong></label> <span id='validade'><button type='button' onclick='SimValidade()'>Adicionar data de Validade</button></span><br>";
               
                        echo "<label><strong><em>Condição:&nbsp</em></strong></label> <select name = 'estado'>";
                            echo "<option value=0>Novo</option>";
                            echo "<option value=1>Usado</option>";
                        echo "</select> <br>";
               
        

                        echo "<label><strong><em>Recursos Consumidos:&nbsp</em></strong></label> <input type='number' name='recursosConsumidos' value = ''required ><br>";
                        echo "<label><strong><em>Custo Manutençao:&nbsp</em></strong></label> <input type='number' name='custoManutencao' value = ''required ><br>";
                        echo "<input type='hidden' name='modoDeVenda' value = '0'required>";
                        echo "<input type='hidden' name='pesoPorVenda' value = '0'required>";
                        echo "<input type='hidden' name='arquivado' value = '0'required>";
                        echo "<label><strong><em>Notas Internas:&nbsp</em></strong></label> <input type='text' name='notasInternasAoFornecedor' value = ''required ><br>";
                        echo "<input type='hidden' name='dataCriacaoTimeStamp' value = '".date('Y/m/d')."'required ><br>";
                        echo "<input class='btnUser' type='submit' value='Criar produto'> ";
                        
                    ?>
                </form>
                <a href="verProduto.php"> <button class="btnUser">Voltar</button> </a>
            </div>
            <br>
        </div>
        <?php 
            include 'includes/footer.php';
        ?> 
    </div>
    
</body>


	<!-- Jquery -->
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
