<?php 
//Commit DiogoS

include ('includes/config.php');   

include ('classes/user.php');
$ctrlUser=new user($db);

require_once ('classes/mail.php');



//PEDIDO AJAX REGISTAR
if (isset($_POST['codigo']) && $_POST['codigo'] == 1) {
	$resposta =  $ctrlUser->registar($_POST['nif'],$_POST['nome'],$_POST['sobreNome'],$_POST['genero'],$_POST['email'],$_POST['senha'],$_POST['morada'],$_POST['codigoPostal'],$_POST['distrito'],$_POST['concelho'],$_POST['dataNascimento'],$_POST['tipoConta'],$_POST['contacto'],$_POST['anuncios']);	
	echo $resposta;
}



//FORM SUBMIT Com Redirect Page
// 2 == registar
if (isset($_POST['codigo']) && $_POST['codigo'] == 2) {
	$resposta =  $ctrlUser->registar($_POST['nif'],$_POST['nome'],$_POST['sobreNome'],$_POST['genero'],$_POST['email'],$_POST['senha'],$_POST['morada'],$_POST['codigoPostal'],$_POST['distrito'],$_POST['concelho'],$_POST['dataNascimento'],$_POST['tipoConta'],$_POST['contacto'],$_POST['anuncios']);
	if ($resposta){
	

		header('Location: login.php?status=1');
		
	}else{
		header('Location: registar.php?status=2');
	}

}

//3 == login
if (isset($_POST['codigo']) && $_POST['codigo'] == 3) {
	if($ctrlUser->isBlocked($ctrlUser->getUserIdByEmail($_POST['email']))){
		header('Location: login.php?status=13');
	}else {


		if(!$ctrlUser->isDeactivated($ctrlUser->getUserIdByEmail($_POST['email']))){
			
			$resposta =  $ctrlUser->login($_POST['email'], $_POST['senha']);	
			
			if ($resposta){
				header('Location: landpage.php');
			}else{
				header('Location: login.php?status=3');
			}
		}else{
			header('Location: login.php?status=14');
		}
	}
}

//Limpar sessao
if (isset($_GET['codigo']) && $_GET['codigo'] == 4) {
	$_SESSION = array();

	// If it's desired to kill the session, also delete the session cookie.
	// Note: This will destroy the session, and not just the session data!
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}

	// Finally, destroy the session.
	session_destroy();
	
	//EJECT
	header('Location: index.php');

}

//5 == Editar dados utilizador
if (isset($_POST['codigo']) && $_POST['codigo'] == 5) {
	$resposta = false;
	if ($ctrlUser->validaPassword($_POST['nif'], $_POST['passAntiga'])){
		$resposta = $ctrlUser->setTodosOsDados($_POST['nif'],$_POST['nome'],$_POST['sobreNome'],$_POST['genero'],$_POST['email'],$_POST['morada'],$_POST['codigoPostal'],$_POST['distrito'],$_POST['concelho'],$_POST['contacto'],$_POST['anuncios'],$_POST['password']);
	}

	if (isset($_POST['NOAUTH']) and $_POST['NOAUTH']){
		if ($resposta){
			header('Location: RAW_admin.php?status=5');
		}else{
			header('Location: RAW_admin.php?status=4');
		}

	}else{
		if ($resposta){
			header('Location: userAccount.php?status=5');
		}else{
			header('Location: editUser.php?status=4');
		}
	}
	/* $resposta =false;
	if (($ctrlUser->validaPassword($_POST['nif'], $_POST['passAntiga']) or ( isset($_POST['NOAUTH']) and $_POST['NOAUTH'])) )
		$resposta =  $ctrlUser->setTodosOsDados($_POST['nif'],$_POST['nome'],$_POST['sobreNome'],$_POST['genero'],$_POST['email'],$_POST['morada'],$_POST['codigoPostal'],$_POST['distrito'],$_POST['concelho'],$_POST['contacto'],$_POST['anuncios'],$_POST['senha']);	
	
	if (isset($_POST['NOAUTH']) and $_POST['NOAUTH']){
		if ($resposta){
			header('Location: RAW_admin.php?status=5');
		}else{
			header('Location: RAW_admin.php?status=4');
		}

	}else{
		if ($resposta){
			header('Location: userAccount.php?status=5');
		}else{
			header('Location: editUser.php?status=4');
		}


	} */

}

if (isset($_POST['codigo']) && $_POST['codigo'] == 6) {

	$resposta =false;
	if ($ctrlUser->validaPassword($_POST['nif'], $_POST['password']))
		$resposta =  $ctrlUser->bloquear($_POST['nif'], "user apagou a conta", 5);
	if ($resposta){
		header('Location: ajax_user.php?codigo=4');
	}else{
		header('Location: RAW_userAccount.php?status=6');
	}

}

if (isset($_GET['codigo']) && $_GET['codigo'] == 7) {
	//Ativar Email Account
	$resposta = false;
	$resposta = $ctrlUser->ActivetAccount($_GET['value'], $_GET['email'], $_GET['id']);
		
	if ($resposta){
		header('Location: login.php?status=9');
	}else{
		header('Location: login.php?status=10');
	}

}


if (isset($_POST['codigo']) && $_POST['codigo'] == 8) {
	//recuperar senha parte 1
	$idUser = null;
	$idUser = $ctrlUser->getUserIdByEmail($_POST['email']);
	$resposta = false;

	
	if ($idUser != null) {
		//Ver se está bloqueado
		if ($ctrlUser->isBlocked($idUser)){
			header('Location: recuperar.php?status=13');
		}
		//Ver se foi desativada a conta
		if ($ctrlUser->isDeactivated($idUser)){
			
			header('Location: recuperar.php?status=14');
		}

		$nome = $ctrlUser->getTodosOsDados($idUser)['nome'];
		$ctrlEmail = new enviadorDeEmail();
		$resposta = $ctrlEmail -> recuperarSenha($_POST['email'],"ptr.emanuelnunes.pt",$idUser, $nome );
	}

	if ($resposta){
		header('Location: recuperar.php?status=11');
	}else{
		header('Location: recuperar.php?status=12');
	}

}


if (isset($_GET['codigo']) && $_GET['codigo'] == 9) {
	
	$resposta = false;
	//value = idUser
	//id = HASH de validaçao // Estao trocados :/

	$novaPass = $ctrlUser->geraChave(12);
	$nome = $ctrlUser->getTodosOsDados($idUser)['nome'];
	$resposta = $ctrlUser->newPassword($_GET['value'], $_GET['email'], $_GET['id'], $novaPass);
	if ($resposta){
		$ctrlEmail = new enviadorDeEmail();
		$resposta = $ctrlEmail -> enviarSenha("ptr.emanuelnunes.pt",$novaPass, $_POST['email'], $nome );
	}	
	if ($resposta){
		header('Location: repor.php?status=15');
	}else{
		header('Location: repor.php?status=16');
	}

}

if (isset($_POST['codigo']) && $_POST['codigo'] == 10) {
	$resposta = false;
	//value = idUser
	//id = HASH de validaçao // Estao trocados :/
	$resposta = $ctrlUser->mudarPassword($_POST['nif'],$_POST['passAntiga'],$_POST['senha']);
	header('Location: userAccount.php?status=21&'.$resposta);
	if ($resposta){
		header('Location: userAccount.php?status=21&'.$resposta);
	}else{
		header('Location: userAccount.php?status=22&'.$resposta);
	}

}


if (isset($_POST['codigo']) && $_POST['codigo'] == 11){

	$resposta = $ctrlUser->clearNotify($_POST['notify']);

	if ($resposta){
		echo "1";
	}else{
		echo "-1";
	}
}


/*$array = $ctrlUser->bloquear(596, "BLOQUEADO");
echo $array;

$array = $ctrlUser->getTodosOsDados(596);
print_r($array);

$array = $ctrlUser->bloquear(596, "DESBLOQUEADO", 0);
echo $array;

$array = $ctrlUser->getTodosOsDados(596);
print_r($array);*/


//echo $ctrlUser->setTodosOsDados(596, "asdfasdf", "AssssssLTERADO", "F", "tesasdasdte@fff.com", "ALTaaaaaERADO", "2114-368", 4, 4, '2021-04-01', 96655666, 0); 
//echo $ctrlUser->getAcountStatus(596);
?>