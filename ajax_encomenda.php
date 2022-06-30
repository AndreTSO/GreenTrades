<?php 
require_once 'includes/config.php';   
require_once 'classes/consumidor.php';
require_once 'classes/encomenda.php';
require_once 'classes/user.php';
require_once("classes/produto.php");


$ctrlConsumidor = new consumidor($db, $_SESSION['nif']); 
$ctrlEncomenda=new encomenda($db);
$ctrlUser = new user($db); 
$ctrlProd = new produto($db);




//PEDIDO AJAX FORNECEDOR
if (isset($_POST['codigo']) && $_POST['codigo'] == 1) {
	$resposta =  $ctrlConsumidor->addArtigosCesto($_POST['idArtigo'], $_POST['quantidade']);	
	if ($resposta == 1){
        echo "99";
	}else{
		echo "false";
	}
}


if (isset($_GET['codigo']) && $_GET['codigo'] == 2) {
	$resposta =  $ctrlConsumidor->wipeCesto();	
	if ($resposta == 1){
        header("Location: cesto.php");
	}else{
		header("Location: cesto.php");
	}
}




if (isset($_POST['codigo']) && $_POST['codigo'] == 5745) {
	$resposta =  $ctrlEncomenda->setEstadoEncomenda(3, $_POST['idEncomenda']);	
	echo 1;
}



/*
if (isset($_POST['codigo']) && $_POST['codigo'] == 3) {
	
	
	$resposta =  $ctrlEncomenda->createEncomenda($_SESSION['nif'], $_POST['nome'], $_POST['sobreNome'], $_POST['email'],$_POST['contacto'], $_POST['nif'], $_POST['morada'], $_POST['codigoPostal'], $_POST['distrito'], $_POST['concelho'], date("d-m-Y"), 1, 0 , $_POST['aditional'],"", $_POST['trans']);

	if ($resposta != false){

		//IR PRODUTO A PRODUTO VER O OWNER ... I WANNA CrY

		$resultadoBDGROSSO = $ctrlConsumidor->getArtigosCesto();// Saca todos os artigos

		if ($resultadoBDGROSSO && $resultadoBDGROSSO->RecordCount() > 0) {
			$cestoSplited = array();
			while ($linha = $resultadoBDGROSSO->FetchRow()) {
				array_push($cestoSplited,  $linha['idArtigo'] . ":" . $linha['quantidade']);
			}

			$fornecedores = array();

			foreach($cestoSplited as $artigo){
				
				$artigo2 = explode(":", $artigo);
				
				$forn = $ctrlProd->getTodosOsDados($artigo2[0])['idFornecedor'];
				if (empty($fornecedores)){
					array_push($fornecedores, $forn);
				}else{
					$flagExiste = false;
					foreach($fornecedores as $forni){
						if ($forni == $forn){
							$flagExiste = true;
						}
					}
					if (!$flagExiste){
						array_push($fornecedores, $forn);
					}
				}
			}

			foreach ($fornecedores as $forn){
				$subEncomenda = $ctrlEncomenda->createSubEncomenda($resposta ,1,0,$forn);

				foreach ($resultadoBDGROSSO as $produto) {
					$idArmazem = $ctrlProd->existeProdutoArmazem2($produto['idArtigo']);
					$dadosProduto = $ctrlProd->getTodosOsDados($produto['idArtigo']);
					
					if ($forn == $dadosProduto['idFornecedor']){
						$finalStep = $ctrlEncomenda->createArtigoSubEncomenda($subEncomenda, $idArmazem['idArmazemFornecedor'],$dadosProduto['nome'],$dadosProduto['descricao'],$produto['quantidade'], $dadosProduto['precoSemIva'] , 0);
					}
				}
				
				$ctrlUser->setNotify($forn, "Tem uma nova encomenda", "Tem uma nova encomenda");
			}

			

		}
	}else{
		//Nao foram encontrados artigos RISE ERROR
	}
	


		
}*/



