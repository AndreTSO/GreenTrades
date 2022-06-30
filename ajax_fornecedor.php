<?php 
include 'includes/config.php';   

include 'classes/fornecedor.php';
include 'classes/armazem.php';
include 'classes/produto.php';
include 'classes/user.php';
$ctrlFornecedor=new fornecedor($db);
$ctrlArmazem=new armazem($db);
$ctrlUser=new user($db);
$ctrlProduto=new produto($db);


//PEDIDO AJAX FORNECEDOR
if (isset($_POST['codigo']) && $_POST['codigo'] == 1) {
	$resposta =  $ctrlFornecedor->createFornecedor($_POST['idFornecedor'], $_POST['descricao'],$_POST['nomeEmpresa'],$_POST['morada'],$_POST['codigoPostal'],$_POST['distrito'],$_POST['concelho'],$_POST['contacto'],$_POST['webSite'],$_POST['xDias'],$_POST['poluicaoGerada'],$_POST['consumoRecursos'],$_POST['estado']);	
	if ($resposta == 1){
		header('Location: mostrarDadosEmpresa.php?status=7');
	}else{
		header('Location: fornecedorDados.php?status=8');
	}
}

if (isset($_POST['codigo']) && $_POST['codigo'] == 2) {
	$resposta =  $ctrlArmazem->createArmazem($_POST['idFornecedor'], $_POST['nome'], $_POST['morada'], $_POST['nPorta'], $_POST['andar'], $_POST['distrito'], $_POST['concelho'], $_POST['codigoPostal'], $_POST['custoManutencao'], $_POST['estado'], $_POST['poluicaoGerada']);
	
	if ($resposta == 1){
		header('Location: showArmazem.php?status=17');
	}else{
		header('Location: showArmazem.php?status=18');
	}
}
/*
if (isset($_POST['codigo']) && $_POST['codigo'] == 3) {

	
	$resposta =  $ctrlProduto->createProduto($_POST['idFornecedor'], $_POST['nome'], $_POST['descricao'], $_POST['tipo'], $_POST['tags'],
	 $_POST['precoSemIva'], $_POST['recursosConsumidos'], $_POST['custoManutencao'], $_POST['estado'], $_POST['tipoIVA'],
	  $_POST['modoDeVenda'], $_POST['pesoPorVenda'], $_POST['arquivado'],  $_POST['notasInternasAoFornecedor'], $_POST['dataCriacaoTimeStamp']);
	
	if ($resposta == 1){
		header('Location: RAW_inserirImagem.php?status=19');
	}else{
		header('Location: RAW_registarProduto.php?status=20');
	}
}  FUNÇÂO NO INTERIR IMAGEM.PHP

*/

if (isset($_POST['codigo']) && $_POST['codigo'] == 4) {

	
	$resposta =  $ctrlFornecedor->setTodosOsDados($_POST['idFornecedor'], $_POST['descricao'], $_POST['nome'],$_POST['morada'],$_POST['codigoPostal'],$_POST['distrito'],$_POST['concelho'],$_POST['contacto'],$_POST['webSite'],$_POST['PeriodoXDiasCancelar'],$_POST['poluicaoGerada'],$_POST['recursosConsumidos'],$_POST['estado']);
	if ($resposta == 1){
		header('Location: mostrarDadosEmpresa.php?status=23');
	}else{
		header('Location: mostrarDadosEmpresa.php?status=24');
	}
}

if (isset($_POST['codigo']) && $_POST['codigo'] == 5) {

	$resposta =  $ctrlArmazem->setTodosOsDados($_POST['idArmazemFornecedor'], $_POST['idFornecedor'], $_POST['nome'],$_POST['morada'],$_POST['nPorta'],$_POST['andar'],$_POST['distrito'],$_POST['concelho'],$_POST['codigoPostal'],$_POST['custoManutencao'],$_POST['estado'],$_POST['poluicaoGerada']);
	

	if ($resposta == 1){
		header('Location: showArmazem.php?status=23');
	}else{
		header('Location: showArmazem.php?status=24');
	}
}

if (isset($_POST['codigo']) && $_POST['codigo'] == 6) {
	$resposta = $ctrlProduto->setTodosOsDados($_POST['idProduto'],$_POST['idFornecedor'], $_POST['nome'], $_POST['descricao'], $_POST['tipo'], $_POST['tags'],
			 $_POST['precoSemIva'], $_POST['recursosConsumidos'], $_POST['custoManutencao'], $_POST['estado'], $_POST['tipoIVA'],
			  $_POST['modoDeVenda'], $_POST['pesoPorVenda'], $_POST['arquivado'],$_POST['notasInternasAoFornecedor'], $_POST['dataCriacaoTimeStamp'], (isset($_POST['validade'])?$_POST['validade']:NULL));
	
	if ($resposta == 1){
		header('Location: verProduto.php?status=33');
	}else{
		header('Location: verProduto.php?status=34');
	}
}

if (isset($_POST['codigo']) && $_POST['codigo'] == 7) {
	$verificar = $ctrlProduto->existeProdutoArmazem($_POST['idProduto']);

	if ($verificar == 0){
		$resposta = $ctrlProduto->eliminarProduto($_POST['idProduto']);
		if ($resposta == 1){
			header('Location: verProduto.php?status=35');
		}else{
			header('Location: verProduto.php?status=36');
		}
	}else{
		header('Location: verProduto.php?status=39');
	}

	
}



if (isset($_POST['codigo']) && $_POST['codigo'] == 8) {
	//$_POST['quantArmazens'] // isto é um array
		
	


		
	$resultado = $ctrlProduto->atualizaStock($_POST['idProduto'], $_POST['idArmazem'], $_POST['stock']);

	


	if ($resultado != 0){
		header('Location: verProduto.php?status=37');
	}else{
		header('Location: verProduto.php?status=38');
	}
}

if (isset($_POST['codigo']) && $_POST['codigo'] == 9) {
	$verificar = $ctrlArmazem->contarProdutosArmazem($_POST['idArmazem']);
	if ($verificar == 0){
		$resposta = $ctrlArmazem->eliminarArmazem($_POST['idArmazem']);
		if ($resposta){
			header('Location: showArmazem.php?status=40');
		}else{
			header('Location: showArmazem.php?status=41');
		}
	}else{
		header('Location: showArmazem.php?status=42');
	}
}

if (isset($_POST['codigo']) && $_POST['codigo'] == 10) {
	$eliminar = $ctrlArmazem->removerProdutoArmazem($_POST['idProduto'],$_POST['idArmazem']);
	if ($eliminar){
		header('Location: verProdutosArmazem.php?status=43');
	}else{
		header('Location: verProdutosArmazem.php?status=44');
	}
}