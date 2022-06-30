<!DOCTYPE html>
<html lang="pt">
<head>
<link rel="stylesheet" href="css/twitter.css">
	<?php 
		require_once ("includes/config.php");
        require_once ("classes/lib.php");
		require_once ('classes/district.php');
        require_once ('classes/user.php');
        require_once ('classes/armazem.php');
		$ctrldistrict=new handlerDistrict();	
        $ctrllib=new lib($db);	
        
        $ctrlUser=new user($db);
        $ctrlArmazem=new armazem($db);

        if (!$ctrlUser->islogged())
	        header('Location: RAW_index.php');
            //EJECT
        if (isset($_SESSION['nif']) ){
            if (!$ctrlUser->isAuthorized(2,$_SESSION['nif'])){
                header('Location: RAW_index.php');
            }
        }

	?>
</head>


<body>
           
        <?php                                    
            include 'showMsg.php';
        ?>
        <h2>Os seus armazens <h2>
        <br>
        <br>
        <table class='table table-condensed'>

        <?php 
            $vetorExternoArmazens = $ctrlArmazem->getTodosOsArmazens($_SESSION['nif']);
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
        
        
        ?>
        </table>


        <hr>

        <h2>Registo Armazens fornecedor</h2> 
        <a href="RAW_registarArmazem.php">Registar um novo armazem</a><br><br>
        <a href="landpage.php">Voltar</a>


</body>