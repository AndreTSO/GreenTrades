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

    include 'classes/district.php';
    $ctrldistrict = new handlerDistrict();

    include 'classes/user.php';
    $ctrlUser = new user($db);

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


<body>
    <?php
    include 'topo.php';
    ?>
    <div class="page">
        <?php
            include 'showMsg.php';
        ?>

        <div class="content">
            <div class="data">
                <h2>Registo Empresa</h2>
                <hr>
                <form ACTION="ajax_transportador.php" METHOD="POST">
                <?php
                echo "<input type='hidden' value='" . $_SESSION['nif'] . "' name='idTransportador' >";
                echo "<input type='hidden' value='1' name='codigo' >";
                echo "<label><strong><em>Nome Transportadora:&nbsp</em></strong></label> <input type='text' name='nomeEmpresa' value = '' required placeholder='Nome da sua empresa'><br>";

                echo "<hr>";
                echo "<label><strong><em>Morada:&nbsp</em></strong></label> <input type='text' name='morada' value = '' required ><br>";
                echo '<label><strong><em>Codigo Postal:&nbsp</em></strong></label> <input type="text" name="codigoPostal" required pattern="\d{4}-\d{3}" title="DDDD-DDD" data-eye><br>';
                echo "<label><strong><em>Distrito:&nbsp</em></strong></label> <select name = 'distrito' id = 'distrito' onChange='obtemDistrito()' required>";
                $resultado=$ctrldistrict->getDistrict($db);
                
                echo "<option value=''>Distrito</option>";
                if ($resultado && $resultado->RecordCount()>0){
                    
                    while ($linha=$resultado->FetchRow()){
                        echo "<option  value='".$linha['id']."'>".$linha['name']."</option>";
                        
                    }
                }
                echo "</select><br>";
                echo '<span id="conselho2">';
                echo "<label><strong><em>Concelho:&nbsp</em></strong></label> <input name='concelho' id='concelho' type='text' required placeholder='Escolha o distrito primeiro &#8593;' disabled><br>";
				echo '</span>';
                echo "<hr>";
                echo '<label><strong><em>Contacto:&nbsp</em></strong></label> <input  name="contacto" type="number" pattern="\d{9}" title="Numero de telefone com 9 digitos" required><br>';				
                echo "<label><strong><em>WebSite:&nbsp</em></strong></label> <input type='text' name='webSite' value = '' required placeholder='Coloque o seu website pessoal'><br>";
                echo "<label><strong><em>Garantia de Entrega em Horas:&nbsp</em></strong></label> <input type='text' name='entrega' value = '' required placeholder='Coloque o numero de horas'><br>";
                echo '<input class="btnUser" type="submit" value="Guardar">';
                ?>
                </form>
                <hr>
                <div class="opcoes">
                    <a  href = "landpage.php"><button class="btnUser">Voltar</button></a>
                </div>

            </div>
        </div>
    </div>
    <?php

    /* include("includes/footer.php") */

    ?>

</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>


<script src="js/loginOficial.js"></script>
<script src="js/jquery-3.6.0.js"></script>