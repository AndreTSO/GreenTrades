<?php 


include 'includes/config.php';   

include 'classes/user.php';
$ctrlUser=new user($db);


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
		echo $_POST['tipoConta'];
		
		if ($_POST['tipoConta'] == "2" or $_POST['tipoConta']== 2){
			$_SESSION['nif'] = $_POST['nif'];
			header('Location: RAW_fornecedorDados.php');
		}else if ($_POST['tipoConta'] == "3"  or $_POST['tipoConta']== 3 ){
			$_SESSION['nif'] = $_POST['nif'];
			header('Location: RAW_transportadorDados.php');
		}else{

			header('Location: login.php?status=1');
		}
	}else{
		header('Location: registar2.php?status=2');
	}

}

//3 == login
if (isset($_POST['codigo']) && $_POST['codigo'] == 3) {
	$resposta =  $ctrlUser->login($_POST['email'], $_POST['senha']);	
	
	if ($resposta){
		header('Location: landpage.php');

	}else{
		header('Location: login.php?status=3');
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
	header('Location: index.html');

}

//5 == Editar dados utilizador
if (isset($_POST['codigo']) && $_POST['codigo'] == 5) {

	$resposta =false;
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
			header('Location: RAW_editUser.php?status=4');
		}


	}

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