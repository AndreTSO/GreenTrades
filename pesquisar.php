<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product List</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,600,700,800" rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/pesquisar.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
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
		require_once('classes/produto.php');
        require_once 'classes/user.php';
   
	
		$ctrllib=new lib($db);	
        $ctrlUser=new user($db);
        $ctrlProduto = new produto($db);


      



	?>
    <script>
    function obtemSubCategoria(){
        let codigo = $('#categoriaPAPI option:selected').val();
        
        $.ajax({
        type: "POST",
        url: 'ajax_categoria.php',
        data: {categoriaPAI: codigo, pesquisa:1},
        dataType: "html",
        success: function (data){
                if (data) {
                    document.getElementById('subTipo').innerHTML = data;
                }
            }
        });
    }


    function serchAutomatic(){
        
        let codigo = 1;
        let categoriaPAI = $('#categoriaPAPI option:selected').val();
        let categoriaFILHO = $('#conse option:selected').val();
        let valorMax = $('#maxValue').val();
        let texto = $('#texto').val();
        
        $.ajax({
        type: "POST",
        url: 'ajax_pesquisar.php',
        data: {codigo: 1, categoria:categoriaPAI, categoria2: categoriaFILHO, pesquisa:texto, valor:valorMax},
        dataType: "html",
        success: function (data){
                if (data) {
                    
                    document.getElementById('destroi').innerHTML = data;
                }
            }
        });

    }

    </script>


</head>

<body>
        
    <div class="body">
        <?php 
                include 'topo.php';
        ?>
        <div class="page">
            <!-- <div class="sideBar">
                <h3>Categorias:</h3>
                <?php
                    // $resultado=$ctrllib->getCategoria($db);
                    // echo "<a href='#'>Todas as Categorias</a>";
                    // if ($resultado && $resultado->RecordCount()>0){
                                
                    //     while ($linha=$resultado->FetchRow()){
                    //         echo "<a href='#'>.$linha['categoria']</a>";
                                   
                    //     }
                    // }
                             
                            	
                        
				?>
            </div> -->
            <div class="content">
                <div class="contentTitle">
                    <p class='welcomemsg'>Os nossos Produtos</p>
                    <hr class="middle">
                </div>
                <br>
                
                <div class="tools">
                    <!-- <div class="search-area">
                        <input type="text" id="search" placeholder="Search" />
                        <button id="searchbutton">Go</button>
                    </div> -->
                    <div class="toolsFilter">
                        <span class="pesquisar"> 
                            <label><strong>Categoria:&nbsp </strong></label>
                            <select name = 'tipo' id = 'categoriaPAPI' onmouseup='obtemSubCategoria(); serchAutomatic() ' required >
                            <?php
                                $resultado=$ctrllib->getCategoria($db);
                            
                                echo "<option value=''>Todas</option>";
                                if ($resultado && $resultado->RecordCount()>0){
                                    while ($linha=$resultado->FetchRow()){
                                        echo "<option  value='".$linha['idCategoria']."'>".$linha['categoria']."</option>";
                                    
                                    }
                                }
                                echo "</select>";	
                        
                            ?>

                            <span id="subTipo">
                                <label><strong>&nbsp Sub Categoria:&nbsp </strong></label>
                                <select name="conse" id="subtipo" onmouseup="serchAutomatic()">
                                    <option value="" >Todas</option>
                                </select>
                            </span>
                            

                            <label><strong>&nbspNome Artigo:&nbsp </strong></label><input type = "text" value="" onkeypress="serchAutomatic()" placeholder="" id="texto" >
                            <label><strong>&nbspPreço Maximo:&nbsp </strong></label><input type = "number" value="" onkeypress="serchAutomatic()" oninput ="serchAutomatic()" placeholder="" min ="0" id="maxValue" >
                            
                        </span>
                    </div>

                    <div class="settings">
                        
                        <a href="pesquisar.php"><button class="btnUser" >Limpar filtros</button></a>
                        <button  class="btnUser" id="view">Trocar Visualização</button>
                    </div>
                </div>
                
                <div class="products" id="destroi">
                    <?php
                        $produto = $ctrlProduto->getProductsSite((isset($_GET['categoria'])?$_GET['categoria']:""), (isset($_GET['pesquisa'])?$_GET['pesquisa']:""));
                        if (!empty($produto)) {

                            foreach ($produto as $produtos){
                                $preco = $ctrlProduto-> getRealPrice($produtos['idProduto']);
                                $imagem = $ctrlProduto->getImg($produtos['idProduto']);
                                $subCat = $ctrllib->getSubCategoriaNome($produtos['tags']);
                                $imagemDIV = "";
                                if(empty($imagem)){
                                    $imagemDIV = "<img src='images/IMG_PRODUTOS/noIMG.png'>";
                                }else{
                                    $imagemDIV = "<img src='images/IMG_PRODUTOS/".$imagem[0]."'>";
                                }
                                echo "
                                    
                                        <a style='color:black;' href='prodShow?q=".$produtos['idProduto']."'>
                                            <div class='product'>
                                                <div class='product-img'>".
                                                    $imagemDIV."
                                                </div>
                                                <div class='product-content'>
                                                    <h3>".$produtos['nome']."
                                                        
                                                        <small>".$produtos['descricao']."</small>
                                                    </h3>
                                                    <p class='product-text price'>".$preco." €</p>
                                                    <p class='product-text genre'>".$subCat."</p>
                                                </div>
                                            </div>
                                        </a>
                                    ";
                            }
                        }else{
                            echo "<center><img src='images/clippy.gif' width='130px' height='130px' style='border-radius:30px;' /><br>
                            Não encontramos nenhum resultado, <br> Experimente mudar algo na sua pesquisa!</center>
                                
                            
                            ";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $("#view").click(function () {
            $(".products").toggleClass("products-table");
        });
    </script>
    <?php 
                include 'includes/footer.php';
        ?>
</body>

</html>