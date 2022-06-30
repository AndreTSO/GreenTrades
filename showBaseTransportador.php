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
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/botoes.css">

    <link rel="stylesheet" href="css/twitter.css">
    <?php
    require_once("includes/config.php");
    require_once("classes/lib.php");
    require_once('classes/district.php');
    require_once('classes/user.php');
    require_once('classes/baseTransportador.php');
    $ctrldistrict = new handlerDistrict();
    $ctrllib = new lib($db);

    $ctrlUser = new user($db);
    $ctrlBaseTransportador = new baseTransportador($db);

    if (!$ctrlUser->islogged())
        header('Location: index.php');
    //EJECT
    if (isset($_SESSION['nif'])) {
        if (!$ctrlUser->isAuthorized(3, $_SESSION['nif'])) {
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
            <?php
            include 'showMsg.php';
            ?>
            <div class="content">
                <div class="contentTitle">
                    <h2>As suas Bases</h2>
                    <hr class="middle">
                </div>

                <hr>
                <?php
                if (!$ctrlBaseTransportador->existsBase($_SESSION['nif'])) {
                    echo "Nenhuma base registada <br>";
                    echo '<a href = "registarBase.php"><button class="btnUser" >Criar Base</button></a>';
                    echo '<a href="landpage.php"><button class="btnUser" >Voltar</button></a>';
                } else {
                    $base = $ctrlBaseTransportador->getTodosOsDados($_SESSION['nif']);
                    echo '<table class="table">';
                    echo '<thead>
                        <tr>
                        <th scope="col"><strong><em>Nome</em></strong></th>
                        <th scope="col"><strong><em>Morada</em></strong></th>
                        <th scope="col"><strong><em>Estado</em></strong></th>
                        <th scope="col"><strong><em>Custo</em></strong></th>
                        <th scope="col"><strong><em>Poluição Gerada</em></strong></th>
                        </tr>
                      </thead>';
                    $vetorExternoEstados = $ctrllib->getEstados("ARMAZEM");
                    foreach ($base as $bases) {
                        if (!($bases['estado'] == "37")) {
                            echo '
                            <tbody>
                            <tr>
                            <th scope="row">' . $bases['nome'] . '</th>
                            <td>' . $bases['morada'] . '</td>
                            <td>' . ($bases['estado'] == "34" ? "Ativo" : ($bases['estado'] == "35" ? "Encerrado" : "Indisponivel")) . '</td> 
                            <td>' . $bases['custoManutencao'] . '</td>
                            <td>' . $bases['poluicaoGerada'] . '</td>

                            </tr>
                            </tbody>';
                        }
                    }
                    echo '</table>';
                    echo '<hr>';
                    echo '<a href = "registarBase.php"><button class="btnUser">Criar Base</button></a>';
                    echo '<a href="landpage.php"><button class="btnUser">Voltar</button></a>';
                }


                ?>
                <!--         <table class='table table-condensed'>

            <?php
            /* $vetorExternoArmazens = $ctrlArmazem->getTodosOsArmazens($_SESSION['nif']);
                echo "<tr>
                    <th>Armazem</th>
                    <th>Morada</th>
                    <th>Estado</th>
                    <th>Custo</th>
                    <th>Refrigeração</th>
                    <th>Poluição gerada</th>
                    <th>Editar</th>
                </tr>";

                $vetorExternoEstados = $ctrllib->getEstados("ARMAZEM");
                foreach ($vetorExternoArmazens as $vetorInternoArmazens){
                    echo "<tr>
                        <td>".$vetorInternoArmazens['nome']."</td>
                        <td>".$vetorInternoArmazens['morada']."</td>
                        <td>".$ctrllib->getEstadosById($vetorInternoArmazens['estado'])."</td>
                        <td>".$vetorInternoArmazens['custoManutencao']."</td>
                        <td>".($vetorInternoArmazens['referigeracao']==1?"Sim":"Não")."</td>
                        <td>".$vetorInternoArmazens['poluicaoGerada']."</td>
                        <td>
                            <form ACTION='RAW_editarArmazem.php' METHOD ='POST' >
                                <input type='hidden' value='".$vetorInternoArmazens['poluicaoGerada']."' name='idArmazemEditar'>
                                <input type='submit' value='Editar' >
                        
                            </form>
                        </td>
                    </tr>
                    ";
                }
        
                    */
            ?>
            </table> -->
            </div>

        </div>
        <?php

        include("includes/footer.php");

        ?>
    </div>
    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
    <script src="js/jquery-ui.min.js"></script>


</body>