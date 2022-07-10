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
    require_once 'classes/produto.php';


    $ctrldistrict = new handlerDistrict();
    $ctrllib = new lib($db);
    $ctrlUser = new user($db);
    $ctrlArmazens = new armazem($db);
    $ctrlProduto = new produto($db);


    if (!$ctrlUser->islogged())
        header('Location: RAW_index.php');
    //EJECT
    if (isset($_SESSION['nif'])) {
        if (!$ctrlUser->isAuthorized(2, $_SESSION['nif'])) {
            header('Location: RAW_index.php');
        }
    }
    if (!(isset($_POST['idProduto']))) {
        header('Location: verProduto.php');
    }



    ?>
    <script>
        function obtemSubCategoria() {
            let codigo = $('#categoriaPAPI option:selected').val();

            $.ajax({
                type: "POST",
                url: 'ajax_categoria.php',
                data: {
                    categoriaPAI: codigo
                },
                dataType: "html",
                success: function(data) {
                    if (data) {
                        document.getElementById('conselho2').innerHTML = data;
                    }
                }
            });
        }

        function SimValidade() {
            $('#validade').html("Data de Validade: <input type='date' id='retiraValidade' name='validade' value='' required /><button onclick='NoValidade()' type='button'>Remover</button><br>");
        }

        function NoValidade() {
            $('#validade').html("Data de Validade: <button type='button' onclick='SimValidade()'>Adicionar data de Validade</button><br>");

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
                <div class="contentTitle">
                    <h1>Editar Produto</h1>
                    <hr class="middle">
                </div>

                
                <form ACTION="ajax_fornecedor.php" METHOD="POST">
                    <?php
                    $resultado = $ctrlProduto->getTodosOsDados($_POST['idProduto']);
                    echo "<input type='hidden' value='" . $_SESSION['nif'] . "' name='idFornecedor' >";
                    echo "<input type='hidden' value='" . $_POST['idProduto'] . "' name='idProduto' >";
                    echo "<input type='hidden' value='6' name='codigo' >";
                    echo '<div class="container rounded bg-white mt-5 mb-5">
                            <div class="row">
                                <div class="col-md-4 border-right">
                                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><span class="font-weight-bold"></span><span class="text-black-50"></span><span> </span></div>
                                </div>
                                <div class="col-md-5 border-right">
                                    <div class="p-3 py-5">
                                        <div class="row mt-1">

                                            <div class="col-md-12"><label><strong>Nome Produto: &nbsp</label></strong><input class="form-control" type="text" name="nome" value = "' . $resultado['nome'] . '" required></div><br>
                                            <div class="col-md-12"><label><strong>Descriçao Produto: &nbsp</label></strong> <textarea class="form-control" name="descricao" cols="60" required>' . $resultado['descricao'] . '</textarea></div><br>
                    ';
                    ?>
                    <div class="col-md-12"><label><strong>Categoria: &nbsp</label></strong>
                    <select name='tipo' class="form-control" id='categoriaPAPI' onChange='obtemSubCategoria()' required>
                        <?php
                        $resultado2 = $ctrllib->getCategoria($db);

                        echo "<option value=''>Categoria</option>";
                        if ($resultado2 && $resultado2->RecordCount() > 0) {
                            while ($linha = $resultado2->FetchRow()) {
                                echo "<option " . ($resultado['tipo'] == $linha['idCategoria'] ? "selected" : "") . " value='" . $linha['idCategoria'] . "'>" . $linha['categoria'] . "</option>";
                            }
                        }
                        echo "</select></div>";

                        ?>

                            <div class="col-md-12"><span id="conselho2">
                            <br><label><strong>SubCategoria: &nbsp</label></strong>
                            <select name="tags" class="form-control" id="tags" required>
                                <?php
                                $resultado2 = $ctrllib->getSubCategoriaByCategoriaId($db, $resultado['tipo']);

                                echo "<option value=''>SubCategoria</option>";
                                if ($resultado2 && $resultado2->RecordCount() > 0) {
                                    while ($linha = $resultado2->FetchRow()) {
                                        echo "<option " . ($resultado['tags'] == $linha['idsubcategoria'] ? "selected" : "") . " value='" . $linha['idsubcategoria'] . "'>" . $linha['subcategoria'] . "</option>";
                                    }
                                }

                                ?>
                            </select>
                            <br>
                        </span>
                        </div>
                        <hr>
                        <div class="row mt-2">
                        <?php


                        //echo "SubCategoria Produto: <input type='text' name='tags' value = ''required><br>"; 
                        echo "<div class='col-md-12'><label><strong>Preço Produto sem IVA: &nbsp</label></strong> <input type='number' class='form-control' name='precoSemIva' step='0.01' value = '" . $resultado['precoSemIva'] . "'required ></div><br>";
                        echo "<div class='col-md-12'><label><strong>Tipo de IVA:  &nbsp</label></strong>

                        <select name='tipoIVA' class='form-control' required >
                            <option value='23' " . ($resultado['tipoIVA'] == '23' ? "selected" : "") . " >Normal - Continente - 23%</option>
                            <option value='22' " . ($resultado['tipoIVA'] == '22' ? "selected" : "") . " >Normal - Madeira - 22%</option>
                            <option value='18' " . ($resultado['tipoIVA'] == '18' ? "selected" : "") . " >Normal - Açores - 18%</option>
                            <option value='13' " . ($resultado['tipoIVA'] == '13' ? "selected" : "") . " >Intermedia - Continente - 13%</option>
                            <option value='12' " . ($resultado['tipoIVA'] == '12' ? "selected" : "") . " >Intermedia - Madeira - 12%</option>
                            <option value='9' " . ($resultado['tipoIVA'] == '9' ? "selected" : "") . "  >Intermedia - Açores - 9%</option>
                            <option value='6' " . ($resultado['tipoIVA'] == '6' ? "selected" : "") . "  >Reduzida - Continente - 6%</option>
                            <option value='5' " . ($resultado['tipoIVA'] == '5' ? "selected" : "") . "  >Reduzida - Madeira - 5%</option>
                            <option value='4' " . ($resultado['tipoIVA'] == '4' ? "selected" : "") . "  >Reduzida - Açores - 4%</option>
                            <option value='0' " . ($resultado['tipoIVA'] == '0' ? "selected" : "") . "  >Isento</option>
                        </select></div>
        
                        <br>";
                        echo "<span id='validade'>";
                        if ($resultado['validade'] == NULL) {
                            echo "<div class='col-md-12'><label><strong>Data de Validade:  &nbsp</label></strong><button type='button' onclick='SimValidade()'>Adicionar data de Validade</button></div><br>";
                        } else {
                            echo "<div class='col-md-12'><label><strong>Data de Validade:  &nbsp</label></strong><input type='date' class='form-control'  id='retiraValidade' name='validade' value='" . $resultado['validade'] . "' required /><button onclick='NoValidade()' type='button'>Remover</button></div><br>";
                        }
                        echo "</span>";
                        echo "<div class='col-md-12'><label><strong>Condição:  &nbsp</label></strong> <select name = 'estado' class='form-control' >";
                        echo "<option value=0 " . ($resultado['estado'] == '0' ? "selected" : "") . ">Novo</option>";
                        echo "<option value=1 " . ($resultado['estado'] == '1' ? "selected" : "") . ">Usado</option>";
                        echo "</select></div> <br>";
                        echo '</div>';
                        echo '<hr>
                        <div class="row mt-2">';

                        echo "<div class='col-md-12'><label><strong>Recursos Consumidos:  &nbsp</label></strong> <input type='number' class='form-control' name='recursosConsumidos' value = '" . $resultado['recursosConsumidos'] . "'required ></div><br>";
                        echo "<div class='col-md-12'><label><strong>Custo Manutençao:  &nbsp</label></strong> <input type='number' class='form-control' name='custoManutencao' value = '" . $resultado['custoManutencao'] . "'required ></div><br>";
                        echo "<input type='hidden' name='modoDeVenda' value = '0'required>";
                        echo "<input type='hidden' name='pesoPorVenda' value = '0'required>";
                        echo "<input type='hidden' name='arquivado' value = '0'required>";
                        echo "<div class='col-md-12'><label><strong>Notas Internas:  &nbsp</label></strong> <input type='text' class='form-control' name='notasInternasAoFornecedor' value = '" . $resultado['notasInternasAoFornecedor'] . "'required ></div><br>";
                        echo "<input type='hidden' name='dataCriacaoTimeStamp' value = '" . $resultado['dataCriacaoTimeStamp'] . "'required ><br>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        
                        echo "
                            <center><input type='submit'  class='btnUser' value='Guardar'></center> 
                            </form>


                            <hr>
                            <br>

                            <form METHOD='POST' ACTION='editarImg.php' >
                                <input type='hidden' value='" . $_POST['idProduto'] . "' name='idProduto'>
                                <center><input type='submit' class='btnUser'value='Editar Imagens '></center>
                            </form>
                            <br>
                            <hr>
                            
                            <div class='contentTitle'>
                                <h3>Adicionar produto ao armazem!</h3>
                                <hr class='middle'>
                            </div>
                            
                            ";


                        $resposta  = $ctrlArmazens->getTodosOsArmazens($_SESSION['nif']);


                        $contador = 0;
                        echo "<div class='row justify-content-center'>";
                        echo "<div class='col-md-0'>";
                        echo "<form ACTION = 'ajax_fornecedor.php' METHOD = 'POST'>";
                        echo "<input type='hidden' value='" . $_SESSION['nif'] . "' name='idFornecedor' >";
                        echo "<input type='hidden' value='" . $_POST['idProduto'] . "' name='idProduto' >";
                        echo "<input type='hidden' value='8' name='codigo' >";
                        $armazensid = array();



                        $place = $ctrlArmazens->getStockandLoc($_POST['idProduto']); // 1-> Stock 0-> idArmazem

                        if (!empty($place)) {
                            $armazem  = $ctrlArmazens->getTodosOsDados($place['idArmazemFornecedor']);
                            echo "<div class='row justify-content-center'>";
                            echo "<input type='number' name='stock' required value='" . $place['stock'] . "' min='0' > Artigos no Armazem: " . $armazem['nome'] . "&nsbp";
                            echo "<input type='hidden' name='idArmazem' value='" . $place['idArmazemFornecedor'] . "' >";
                            echo "<br>";
                            echo "</div>";
                            echo "<br>";
                        } else {
                            //vazio
                            echo "<select name='idArmazem'>";
                            foreach ($resposta as $linha) {
                                if ($linha['estado'] != 37) {
                                    $contador += 1;
                                    echo "<option value='" . $linha['idArmazemFornecedor'] . "'>" . $linha['nome'] . "</option>";
                                }
                            }
                            echo "</select>";
                            if ($contador == 0) {
                                echo "Não foram encontrados armazens para adicionar este produto, por favor crie 1 armazem primeiro";
                            } else {
                                $stock = $ctrlProduto->getTodosOsProdutosDoArmazem($_POST['idProduto'], $linha['idArmazemFornecedor']);
                                echo "<input  type='number' name='stock' required value='" . $stock . "' min='0' >";
                            }
                        }
                        echo "<br>";
                        echo "<div class='row justify-content-center'";
                        echo "<div class='col-md-12'>";
                        echo "<br><input class='btnUser'type='submit'  class='btn' value='Guardar quantidades' style='padding:5px;'/>
                            </form>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        
                        ?>

                        <hr>

                <center><a href="verProduto.php"> <button class="btnUser" type="button">Voltar</button> </a></center>
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