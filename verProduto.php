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
		require_once('classes/produto.php');
        require_once 'classes/user.php';
        require_once 'classes/armazem.php';
   
	
		$ctrllib=new lib($db);	
        $ctrlUser=new user($db);
        $ctrlArmazens= new armazem($db);
        $ctrlProduto = new produto($db);


        if (!$ctrlUser->islogged())
	        header('Location: index.php');
            //EJECT
        if (isset($_SESSION['nif']) ){
            if (!$ctrlUser->isAuthorized(2,$_SESSION['nif'])){
                header('Location: index.php');
            }
        }
	?>
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
                <div class="contentTitle">
                    <H1>Produtos</H1>
                    <hr class="middle">
                </div>
                <br>
                <br>
                
                <?php
                    $hoje = date("Y-m-d");
                    //Using PHP's date and strtotime functions to get
                    //the date 30 days from now.
                    $thirtyDays = date("Y-m-d", strtotime("+30 days"));

                    //Print out the result.
                    if ((!$ctrlProduto->existeProduto($_SESSION['nif']))) {
                        echo "Nenhum produto registado <br>";
                        echo '<a href = "registarProduto.php"><button class="btnUser">Registar Produto</button></a><br>';
                        echo '<a href="landpage.php"><button class="btnUser">Voltar</button></a>';
                    }else{
                        $produto = $ctrlProduto->getTodosOsProdutos($_SESSION['nif']);
                        echo '<table class="table">';
                        echo '<thead>
                            <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">SubCategoria</th>
                            <th scope="col">Validade</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Apagar</th>
                            </tr>
                        </thead>';
                        foreach ($produto as $produtos){
                            if($produtos['arquivado'] == 0){
                                echo '
                                <tbody>
                                <tr>
                                <th scope="row">'.$produtos['nome'].'</th>';
                                echo '<td>'.$ctrllib->getCategoriaById($db, $produtos['tipo']).'</td>
                                <td>'.$ctrllib->getSubCategoriaById($db, $produtos['tags']).'</td> 
                                <td>'.($produtos['validade']!= null ?$produtos['validade']." 
                                
                                ".($produtos['validade']>$thirtyDays?"<img src='/images/verde.png' width='15px'; height='15px' />": 
                                
                                (($produtos['validade']<=$thirtyDays and $produtos['validade']>=$hoje)?"<img src='/images/amarelo.png' width='15px'; height='15px' />":"<img src='/images/vermelho.png' width='15px'; height='15px' />")
                                
                                
                                )  :"Sem Validade").'
                                
                                
                                
                                
                                
                                </td>
                                <td>'.($produtos['arquivado']==1?"Arquivado":"Ativo").'</td>
                                <td><form ACTION="editarProduto.php" METHOD ="POST" >
                                        <input type="hidden" value="'.$produtos['idProduto'].'" name="idProduto">
                                        <input class="btnTable" type="submit" value="Editar" >
                                    </form>
                                </td>
                                <td><form ACTION="ajax_fornecedor.php" METHOD ="POST" >
                                        <input type="hidden" value="7" name="codigo" >
                                        <input type="hidden" value="'.$produtos['idProduto'].'" name="idProduto">
                                        <input class="btnTable" type="submit" value="Apagar" >
                                    </form>
                                </td>
                                </tr>
                                </tbody>';
                            }
                        }
                        echo '</table>';
                        echo '<a href = "registarProduto.php"><button class="btnUser">Registar Novo Produto</button></a><br>';
                        echo '<a href="landpage.php"><button class="btnUser">Voltar</button></a>';

                    }
                ?>
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
