<!DOCTYPE html>
<html lang="pt">
<head>

	<?php 
		include("includes/config.php");

        include 'classes/user.php';
        $ctrlUser=new user($db);

        if (!$ctrlUser->islogged())
	        header('Location: RAW_index.php');
            //EJECT

        include'classes/district.php';
        $ctrldistrict=new handlerDistrict();	
        
	?>


    <script>

        function mostrar(){
            $("#ApiEscondida").show();
            $("#btnAPI").hide();
        }


    </script>

</head>

<body>


    <?php 
     
     include 'includes/RAW_menu.php';
     include 'showMsg.php';
     ?>

    <h2>Dados Pessoais </h2>

    <a href="RAW_editUser.php">Editar dados</a>
    <?php
        $resultado = $ctrlUser->getTodosOsDados($_SESSION['nif']);
        echo "Nome: ".$resultado['nome'];
        echo "<br>Sobre nome: ".$resultado['sobreNome'];
        echo "<br>Genero: ".$resultado['genero'];
        echo "<br>Email: ".$resultado['email'];
        echo "<br>Morada: ".$resultado['morada'];
        echo "<br>codigoPostal: ".$resultado['codigoPostal'];
        echo "<br>Ditrito: ".$ctrldistrict->getDistrictById($db, $resultado['distrito']);
        echo "<br>Concelho: ".$ctrldistrict->getConcelhoById($db, $resultado['concelho']);
        echo "<br>Data de Nascimento: ".$resultado['dataNascimento'];
        echo "<br>TipoDeConta: ". ($resultado['tipoDeConta']== 1?"Utilizador": ($resultado['tipoDeConta'] == 2?  "Fornecedor":($resultado['tipoDeConta'] == 3?  "Transportador": "Administrador" ) ));
        echo "<br>Telefone: ".$resultado['contato'];
        echo "<br>Mostrar Artigos Favoritos: ".$resultado['anuncios'];
        echo "<br>Chave API: <span><button id='btnAPI' onclick='mostrar()'>Mostrar</button></span><span id='ApiEscondida' hidden >".$resultado['apiKey']."</span>";
        echo "<br>Registado Desde: ".$resultado['dataRegisto'];
        echo "<br>Estado da sua Conta: ".($resultado['estadoConta']==0?"Normal":"Bloqueada");
        echo "<br>Observações: ".(trim($resultado['observacoes'])==""?"Sem observações":$resultado['observacoes']);




    ?>
    <br>

    
    <a href="RAW_deleteAcount.php">Eliminar a conta!</a>

    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>


    <center>
        <script>
             document.getElementsById("specialDiv").style.backgroundColor = "#00FF00";
        </script>
        <div id ='specialDiv' style="background-color:brown; width:500px; height:400px; border-radius:15px;">
            <h1>Edit me please!</h1>
            <p>I have a Dream.. A dream of becomming a beautiful website</p>
            <img src="https://www.eas.pt/wp-content/uploads/2017/08/LUTER-1-437x276.jpg"/>

        </div>
    </center>


</body>