


<!DOCTYPE html>
<html lang="pt">
<head>

	<?php 
		include("includes/config.php");
		
		include'classes/district.php';
		$ctrldistrict=new handlerDistrict();	

        include 'classes/user.php';
        $ctrlUser=new user($db);

        if (!$ctrlUser->islogged())
	        header('Location: RAW_index.php');
            //EJECT
        if (isset($_SESSION['nif']) ){
            if (!$ctrlUser->isAuthorized(2,$_SESSION['nif'])){
                header('Location: RAW_index.php');
            }
        }

        require_once ('classes/fornecedor.php');
        $ctrlFornecedor = new fornecedor($db);
        if (!$ctrlFornecedor->existsEmpresa($_SESSION['nif'])) { 
            //A empresa nao foi criada nunca!
            header('Location: RAW_fornecedorDados.php');
        }

	?>
</head>


<body>
        
        <?php
                include 'showMsg.php';
        ?>

        
        <h1>Empresa</h1> 
        <?php
            $user = $ctrlUser -> getTodosOsDados($_SESSION['nif']);
           $empresa = $ctrlFornecedor -> getTodosOsDados($_SESSION['nif']);

        ?>
            Nome do representante: <?php echo $user['nome'] ?> <br>
            Email do representante:<?php echo $user['email'] ?><br>
            
            <hr>
            Nome da empresa: <?php echo $empresa['nomeEmpresa'] ?><br>
            Descrição:<br>
            <?php echo $empresa['descricao'] ?><br>

            Contacto:<?php echo $user['contato'] ?><br>
            Morada da sede: <?php echo $user['morada'] ?><br>
            Distrito da sede: <?php echo $ctrldistrict->getDistrictById($db, $user['distrito']) ?><br>
            Concelho da sede: <?php echo $ctrldistrict->getConcelhoById($db, $user['concelho']) ?><br>
            Codigo-Postal: <?php echo $user['codigoPostal'] ?><br>
            Pagina da empresa:<a href="<?php echo $empresa['webSite'] ?>"><?php echo $empresa['webSite'] ?></a><br>
            Categoria de artigos: <?php echo $empresa['categoriaProdutos'] ?><br>
            Devoluções até:<?php echo $empresa['PeriodoXDiasCancelar'] ?> Dias uteis<br>
            <hr>

            Poluição gerada até hoje: <?php echo $empresa['poluicaoGerada'] ?><br>
            Consumos de recursos até hoje: <?php echo $empresa['ConsumoRecursos'] ?><br>


        <hr />

        <a href = "RAW_fornecedorEditarDados">editar dados Empresa</a>

</body>



