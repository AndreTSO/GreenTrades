<?php 
include 'includes/config.php';   

include 'classes/transportador.php';


include 'classes/user.php';
$ctrlTrans=new transportador($db);

include 'classes/baseTransportador.php';
$ctrlBaseTrans=new baseTransportador($db);

include 'classes/veiculos.php';
$ctrlVeiculo=new veiculo($db);

$ctrlUser=new user($db);



//PEDIDO AJAX FORNECEDOR
if (isset($_POST['codigo']) && $_POST['codigo'] == 1) {
	$resposta =  $ctrlTrans->createTransportador($_POST['idTransportador'],$_POST['nomeEmpresa'],$_POST['descricao'],$_POST['morada'],$_POST['codigoPostal'],$_POST['distrito'],$_POST['concelho'],$_POST['contacto'],$_POST['entrega'],$_POST['webSite'],$_POST['estado']);	
	if ($resposta == 1){
		header('Location: mostrarDadosTransportador.php?status=7'); // Sucesso RegistoTransportadora
	}else{
		header('Location: transportadorDados.php?status=8'); //erro  registar da transportadora
	}
}



if (isset($_POST['codigo']) && $_POST['codigo'] == 2) {
	$resposta =  $ctrlTrans->setTodosOsDados($_POST['idTransportador'], $_POST['nome'],$_POST['descricao'],$_POST['morada'],$_POST['codigoPostal'],$_POST['distrito'],$_POST['concelho'],$_POST['contacto'],$_POST['garantiaEntregaXHoras'],$_POST['webSite'],$_POST['estado']);
	
	if ($resposta == 1){
		header('Location: mostrarDadosTransportador.php?status=23');
	}else{
		header('Location: mostrarDadosTransportador.php?status=24');
	}
}

if (isset($_POST['codigo']) && $_POST['codigo'] == 3) {
	$resposta =  $ctrlBaseTrans->createBaseTransportador($_POST['idTransportador'], $_POST['nome'],$_POST['morada'],$_POST['distrito'],$_POST['concelho'],$_POST['codigoPostal'],$_POST['custoManutencao'],$_POST['poluicaoGerada'],$_POST['estado']);
	
	if ($resposta == 1){
		header('Location: showBaseTransportador.php?status=23');
	}else{
		header('Location: showBaseTransportador.php?status=24');
	}
}

if (isset($_POST['codigo']) && $_POST['codigo'] == 4) {
	$resposta =  $ctrlVeiculo->createVeiculo($_POST['idBaseTransportador'],$_POST['matricula'],$_POST['ano'],$_POST['tipo'],$_POST['marca'],$_POST['consumo'],$_POST['combustivel'],$_POST['carga'],$_POST['estado'],$_POST['frigorifico']);
	if ($resposta == 1){
		header('Location: verVeiculos.php?status=23');
	}else{
		header('Location: verVeiculos.php?status=24');
	}
}

if (isset($_POST['codigo']) && $_POST['codigo'] == 5) {
	$resposta =  $ctrlVeiculo->deleteVeiculo($_POST['idVeiculo']);
	if ($resposta == 1){
		header('Location: verVeiculos.php?status=45');
	}else{
		header('Location: verVeiculos.php?status=46');
	}
}

if (isset($_POST['codigo']) && $_POST['codigo'] == 6) {
	$resposta =  $ctrlVeiculo->setTodosOsDados($_POST['idVeiculo'],$_POST['idBaseTransportador'],$_POST['matricula'],$_POST['ano'],$_POST['tipoVeiculo'],$_POST['marca'],$_POST['consumo'],$_POST['combustivel'],$_POST['carga'],$_POST['estado'],$_POST['frigorifico']);
	if ($resposta == 1){
		header('Location: verVeiculos.php?status=47');
	}else{
		header('Location: verVeiculos.php?status=48');
	}
}