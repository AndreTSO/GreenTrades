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

    <?php
    include("includes/config.php");

    include 'classes/user.php';
    $ctrlUser = new user($db);

    if (!$ctrlUser->islogged())
        header('Location: index.html');
    //EJECT

    include 'classes/district.php';
    $ctrldistrict = new handlerDistrict();

    ?>


    <script>
        function mostrar() {
            $("#Apishow").show();
            $("#btnAPI").hide();
        }
    </script>

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
                <div class="data">
                    <div class="contentTitle">
                        <h2>Dados Pessoais </h2>
                        <hr class="middle">
                    </div>

                    <?php
                    // $resultado = $ctrlUser->getTodosOsDados($_SESSION['nif']);
                    // echo "<center>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>Nome:</em></strong> </div><div class='input-group'>" . $resultado['nome'] . "</div></div>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>Sobrenome:</strong></em> </div><div class='input-group'>" . $resultado['sobreNome'] . "</div></div>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>G??nero:</strong></em> </div><div class='input-group'>" . ($resultado['genero'] == "M" ? "Masculino" : ($resultado['genero'] == "F" ? "Feminino" : "Prefiro n??o dizer")) . "</div></div>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>N?? de Contribuinte:</strong></em> </div><div class='input-group'>" . $resultado['nif'] . "</div></div>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>Data de Nascimento:</strong></em> </div><div class='input-group'>" . $resultado['dataNascimento'] . "</div></div>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>Telefone:</strong></em></div><div class='input-group'> " . $resultado['contato'] . "</div></div>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>Email:</strong></em> </div><div class='input-group'>" . $resultado['email'] . "</div></div>";
                    // echo "<hr>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>Morada:</strong></em> </div><div class='input-group'>" . $resultado['morada'] . "</div></div>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>C??digo Postal:</strong></em> </div><div class='input-group'>" . $resultado['codigoPostal'] . "</div></div>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>Distrito:</strong></em> </div><div class='input-group'>" . $ctrldistrict->getDistrictById($db, $resultado['distrito']) . "</div></div>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>Concelho:</strong></em> </div><div class='input-group'>" . $ctrldistrict->getConcelhoById($db, $resultado['concelho']) . "</div></div>";
                    // echo "<hr>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>Tipo De Conta:</strong></em> </div><div class='input-group'>" . ($resultado['tipoDeConta'] == 1 ? "Utilizador" : ($resultado['tipoDeConta'] == 2 ?  "Fornecedor" : ($resultado['tipoDeConta'] == 3 ?  "Transportador" : "Administrador"))) . "</div></div>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>Mostrar Artigos Favoritos:</strong></em> </div><div class='input-group'>" . ($resultado['anuncios'] ? "Sim" : "N??o") . "</div></div>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>Registado Desde:</strong></em> </div><div class='input-group'>" . $resultado['dataRegisto'] . "</div></div>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>Estado da sua Conta:</strong></em> </div><div class='input-group'>" . ($resultado['estadoConta'] == 30 ? "Por Verificar" : ($resultado['estadoConta'] == 31 ? "Verificada" : "Bloqueada")) . "</div></div>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>Observa????es:</strong></em> </div><div class='input-group'>" . (trim($resultado['observacoes']) == "" ? "Sem observa????es" : $resultado['observacoes']) . "</div></div>";
                    // echo "<div class='form1'><div class='titleInput'><strong><em>Chave API:</strong></em> </div><div class='input-group'><span id='btnAPI' ><button onclick='mostrar()'>Mostrar</button></span>  <span id='Apishow' style='display: none;' >" . $resultado['apiKey'] . "</span></div></div>";
                    // echo "<hr>";
                    // echo "</center>";
                    ?>
                    <?php
                    $resultado = $ctrlUser->getTodosOsDados($_SESSION['nif']);
                    echo '<div class="container rounded bg-white mt-5 mb-5">
                        <div class="row">
                            <div class="col-md-3 border-right">
                                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold">' . $resultado['nome'] . '</span><span class="text-black-50">' . $resultado['email'] . '</span><span> </span></div>
                            </div>
                            <div class="col-md-5 border-right">
                                <div class="p-3 py-5">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="text-right">Perfil</h4>
                                    </div>
                                    
                                    
                                    <div class="row mt-2">
                                        <div class="col-md-6"><label class="labels"><strong><em>Nome:  &nbsp&nbsp</em></strong></label> ' . $resultado['nome'] . '</div>
                                        <div class="col-md-6"><label class="labels"><strong><em>Sobrenome:  &nbsp&nbsp</em></strong></label>'. $resultado['sobreNome'] . '</div>
                                        <div class="col-md-6"><label class="labels"><strong><em>G??nero:  &nbsp&nbsp</em></strong></label>'. $resultado['genero'] . '</div>
                                        <div class="col-md-6"><label class="labels"><strong><em>Nascimento:  &nbsp&nbsp</em></strong></label>'. $resultado['dataNascimento'] . '</div>
                                    </div>
                                    <hr>
                                    <div class="row mt-2">
                                        <div class="col-md-6"><label class="labels"><strong><em>Telefone: &nbsp&nbsp </em></strong></label> '. $resultado['contato'] . '</div>
                                        <div class="col-md-6"><label class="labels"><strong><em>N?? Contribuinte:  &nbsp&nbsp</em></strong></label>'. $resultado['nif'] . '</div>
                                        <div class="col-md-6"><label class="labels"><strong><em>Morada: &nbsp&nbsp </em></strong></label>'. $resultado['morada'] . ' </div>
                                        <div class="col-md-6"><label class="labels"><strong><em>C??digo Postal:  &nbsp&nbsp</em></strong></label>'. $resultado['codigoPostal'] . '</div>
                                        <div class="col-md-6"><label class="labels"><strong><em>Distrito:  &nbsp&nbsp</em></strong></label>'. $ctrldistrict->getDistrictById($db, $resultado['distrito']) .'</div>
                                        <div class="col-md-6"><label class="labels"><strong><em>Concelho:  &nbsp&nbsp</em></strong></label>'. $ctrldistrict->getConcelhoById($db, $resultado['concelho']) . '</div>
                                        <div class="col-md-8"><label class="labels"><strong><em>Email:  &nbsp&nbsp</em></strong></label>'. $resultado['email'] . '</div>
                                    </div>
                                    <hr>
                                    <div class="row mt-2">
                                        <div class="col-md-12"><label class="labels"><strong><em>Tipo de Conta:  &nbsp&nbsp</em></strong></label>'. ($resultado['tipoDeConta'] == 1 ? "Utilizador" : ($resultado['tipoDeConta'] == 2 ?  "Fornecedor" : ($resultado['tipoDeConta'] == 3 ?  "Transportador" : "Administrador"))) . '</div>
                                        <div class="col-md-12"><label class="labels"><strong><em>Mostrar Artigos Favoritos:  &nbsp&nbsp</em></strong></label>'. ($resultado['anuncios'] ? "Sim" : "N??o") . '</div>
                                        <div class="col-md-12"><label class="labels"><strong><em>Registado Desde:  &nbsp&nbsp</em></strong></label>'. $resultado['dataRegisto'] .  '</div>
                                        <div class="col-md-12"><label class="labels"><strong><em>Estado da sua Conta:  &nbsp&nbsp</em></strong></label>'. ($resultado['estadoConta'] == 30 ? "Por Verificar" : ($resultado['estadoConta'] == 31 ? "Verificada" : "Bloqueada")) . '</div>
                                        <div class="col-md-12"><label class="labels"><strong><em>Observa????es: &nbsp&nbsp </em></strong></label>'. (trim($resultado['observacoes']) == "" ? "Sem observa????es" : $resultado['observacoes']) . '</div></div>
                                        <div class="col-md-12"><label class="labels"><strong><em>Chave API: &nbsp&nbsp </em></strong></label><span id="btnAPI" ><button onclick="mostrar()">Mostrar</button></span>  <span id="Apishow" style="display: none;" >' . $resultado['apiKey'] . '</span></div>
                                    </div>
                                    ';
                                    ?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="opcoes">
                <center>
                <a href="landpage.php"><button class="btnUser">Voltar</button></a>
                <a href="editUser.php"><button class="btnUser">Editar Dados</button></a>
                <button id="myBtn" class="btnUser">Eliminar Conta</button>
                <a href="mudarPass.php"><button class="btnUser">Mudar Password</button></a>
                </center>
            </div>
            </div>
            
        </div>
    </div>
    </div>
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Tem a certeza que quer eliminar esta conta?</h2>
            <h4>Se sim, insira a sua palavra-passe abaixo e clique em "Eliminar Definitivamente"</h4>
            <br>
            <br>
            <form METHOD="POST" ACTION="ajax_user.php" name="registar">
                <input type="hidden" name="codigo" value=6>

                <input name="nif" type="hidden" value="<?php echo $_SESSION['nif']; ?>">

                <input name="password" type="password" required placeholder="Insira a sua password para Validar">&nbsp

                <input class="btnUser" type="submit" value="Eliminar Definitivamente">

            </form>
        </div>

    </div>
    <?php
    include("includes/footer.php")
    ?>


    <!-- <div class="footer">

        </div> -->
    </div>
</body>
<script src="js/modal.js"></script>
<script src="js/navbar.js"></script>
<script src="js/jquery-3.6.0.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.0.js"></script>
<script src="js/jquery-ui.min.js"></script>

</html>