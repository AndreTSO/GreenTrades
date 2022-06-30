<?php        
class user{
	
	var $db;
	var $prefixo;
		
	function __construct($db){
		$this->db = $db;
		$this->prefixo = "ptr_";
		
	}
	/**
	 * Regista 
	 */
	function registar($nif, $nome, $sobreNome, $genero, $email, $senha, $morada, $codigoPostal, $distrito, $concelho, $dataNascimento, $tipoDeConta, $contacto, $anuncios){
        $dados = array();
		$dados[0]= $nif;
		$dados[1]= $nome;
		$dados[2]= $sobreNome;
		$dados[3]= $genero;
		$dados[4]= $email;
		$dados[5]= "$".password_hash(md5(md5($senha).SENHA), PASSWORD_BCRYPT);
		$dados[6]= $morada;
		$dados[7]= $codigoPostal;
		$dados[8]= $distrito;
		$dados[9]= $concelho;
		$dados[10]=$dataNascimento;
		$dados[11]=$tipoDeConta;
		$dados[12]=$contacto;
		$dados[13]=$anuncios;
        $dados[14]=$this-> geraChave(45);
        $registar = $this->db-> prepare("INSERT INTO ".$this->prefixo."userregistado (nif, nome, sobreNome, genero, email, password, morada, codigoPostal, distrito, concelho, dataNascimento, tipoDeConta, contato, anuncios, apiKey) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  

		$algo = $this->db->execute($registar, $dados);
		if ($algo){
			require_once ('mail.php');
			$ctrlEmail = new enviadorDeEmail();
			$ctrlEmail -> activarConta($email,"ptr.emanuelnunes.pt", $nome, $nif);
			return true;
		}
		return false;

		//INSERT INTO ptr_userreistado (nif, nome, sobreNome, genero, email, senha, morada, codigoPostal, distrito, concelho, dataNascimento, tipoDeConta, contacto, anuncios, apiKey)  VALUES (596, "ema", "nunes", "M", "emanuel@gmail.com", "$$2y$10$SMM5OxvWQbUpcsR4RbhhmuYiNT1G2EtuwDew6tLTMshJElCBOvvNy", "123123", "2660-368", 1, 1, "2022-04-20", 1, 965, 1, "2MB9IMMY0Q7I0C80G5D7E9RK1IJQOWB0OG1BFPX5WU25G");

    }

    function geraChave($nCaracteres=1, $mapaCaracteres = ['A','B','C','D','E','F','G','H','I','J','L','M','N','O','P','Q','R','S','T','U','V','X','Z','K','Y','W','1','2','3','4','5','6','7','8','9','0']){
        $key="";
        for ($i = 0;$i <$nCaracteres; $i++) {
            $key.=$mapaCaracteres[rand(0, count($mapaCaracteres)-1)];
        }
        return $key;
    }

	function login($email, $password){

		$login = $this->db-> prepare("SELECT * FROM ".$this->prefixo."userregistado  WHERE email=? "); 
		$bindVariables = array(0=>$email);
		$resultado = $this->db->Execute($login, $bindVariables);
		
		if ($resultado && $resultado->RecordCount()>0) { 

			$linha=$resultado->FetchRow();
			
			if (password_verify(md5(md5($password).SENHA), substr($linha['password'], 1))){
				
				$_SESSION["nif"] = $linha['nif'];
				$_SESSION["nome"] = $linha['nome'];
				$_SESSION["sobreNome"] = $linha['sobreNome'];
				$_SESSION["tipoDeConta"] = $linha['tipoDeConta'];

				$_SESSION["anuncios"] = $linha['anuncios'];
				$_SESSION["estadoConta"] = $linha['estadoConta'];

				//nif, nome, sobreNome, email, genero, morada, codigoPostal, distrito, concelho, dataNascimento, tipoDeConta, contato, anuncios, apiKey
				return true;
			}
			return false;
		}
		return False;
	}


	function validaPassword($nif, $passAntiga){

		$login = $this->db-> prepare("SELECT * FROM ".$this->prefixo."userregistado  WHERE nif=? "); 
		$bindVariables = array(0=>$nif);
		$resultado = $this->db->Execute($login, $bindVariables);
		
		if ($resultado && $resultado->RecordCount()>0) { 

			$linha=$resultado->FetchRow();
			
			if (password_verify(md5(md5($passAntiga).SENHA), substr($linha['password'], 1))){
		
				return true;
			}
		}
		return False;
	}

	function mudarPassword($nif, $passAntiga, $passNova){
		
		$login = $this->db-> prepare("SELECT * FROM ".$this->prefixo."userregistado  WHERE nif=? "); 
		$bindVariables = array(0=>$nif);
		$resultado = $this->db->Execute($login, $bindVariables);
		if ($resultado && $resultado->RecordCount()>0) { 
			
			$linha=$resultado->FetchRow();

			if (password_verify(md5(md5($passAntiga).SENHA), substr($linha['password'], 1))){

				$pass = $this->db-> prepare("UPDATE ".$this->prefixo."userregistado SET password = '"."$".password_hash(md5(md5($passNova).SENHA), PASSWORD_BCRYPT)."' WHERE nif=".$nif); 

				$resultado2 = $this->db->Execute($pass);
		
				if ($resultado2) {
					return true;
				}

				return false;
			}
			return false;
		}
		return False;
	}

	/**
	 * requires idUSer NIF
	 * return Array Com dados user
	 */
	function getTodosOsDados($iduser){
		$login = $this->db-> prepare("SELECT * FROM ".$this->prefixo."userregistado  WHERE nif=? "); 
		$bindVariables = array(0=>$iduser);
		$resultado = $this->db->Execute($login, $bindVariables);
		
		if ($resultado && $resultado->RecordCount()>0) { 
			$linha=$resultado->FetchRow();
			$resultado2 = array(
				"nif"  => $linha['nif'],
				"nome" => $linha['nome'],
				"sobreNome" => $linha['sobreNome'],
				"email" => $linha['email'],
				"genero" => $linha['genero'],
				"morada" => $linha['morada'],
				"codigoPostal" => $linha['codigoPostal'],
				"distrito" => $linha['distrito'],
				"concelho" => $linha['concelho'],
				"dataNascimento" => $linha['dataNascimento'],
				"tipoDeConta" => $linha['tipoDeConta'],
				"contato" => $linha['contato'],
				"anuncios" => $linha['anuncios'],
				"apiKey" => $linha['apiKey'],
				"dataRegisto" => $linha['dataRegistoTimeStamp'],
				"estadoConta" => $linha['estadoConta'],
				"observacoes" => $linha['observacoes']

			);
			//nif, nome, sobreNome, email, genero, morada, codigoPostal, distrito, concelho, dataNascimento, tipoDeConta, contato, anuncios, apiKey
			return $resultado2;
		
			
		}
		return null;
	}


	/*
		browserFunction not For API
		Verifica se um user tem a sessao Iniciada
	*/
	function islogged(){
		return isset($_SESSION['nif']);
	}

	/*
		Check if a user has authorization
		1 = Utilizador
		2 = Fornecedor
		3 = Transportador
		4 = ADMIN

		for BROWSER WEBSITE
			Second Param NOT REQUIRED

		For API
			Second Param REQUIRED~

		return boolean True or false

	*/
	function isAuthorized($requiredLevel, $userID =""){
		if (isset($userId) and $userId != "")
			return $this->getTodosOsDados($userID) == $requiredLevel;
		return $_SESSION['tipoDeConta'] == $requiredLevel;
	}


	/*
	Verifica se um utilizador se encontra Bloqueado
	Return True or False
	*/
	function isBlocked($userId){
		return $this->getTodosOsDados($userId)['estadoConta'] == 32;
	}

	/*
	Verifica se a chave API é VALIDA para o User X
	Requires User id 
	Requires HASH API
	Return true or false
	*/
	function isAPIKeyValid($idUser, $apiKey){
		return $this->getTodosOsDados($idUser)['apiKey'] == $apiKey;
	}


	function isDeactivated($userid){
		return $this->getTodosOsDados($userid)['estadoConta'] == 33;
	}


	/**
	 * Procura o id de um utilizador Pelo Email
	 * requires Email
	 * returns ID User
	 */
	function getUserIdByEmail($email){
		$query = $this->db-> prepare("SELECT nif FROM ".$this->prefixo."userregistado WHERE email = '".$email."'");
		$resultado = $this->db->execute($query);
		if ($resultado && $resultado->RecordCount()>0){
			$linha=$resultado->FetchRow();
			return $linha['nif'];
		}
		return 0;
	}

	/**
	 * Requires user ID
	 * retorna o estado da Conta
	 */
	function getAcountStatus($userid){
		$vetor =  $this->getTodosOsDados($userid);
		if ($vetor!=null)
			return $vetor['estadoConta'].";".$vetor["observacoes"];
		return "User not found";
	}

	

	/**
	 * Devolve o nivel da conta
	 * 
	 * 
	 */
	function getTypeAccount($userId){
		return $this->getTodosOsDados($userId)['tipoDeConta'];
	}


	/**
	 *  
	 * BLoqueia uma conta de utilizador
	 * Parametro State opcional
	 * 1 BLOQUEADO
	 * 0 DES-BLOQUEADO
	 * */ 
	function bloquear($userId, $reason, $state=32){
		$dados = array();
		$dados[1]= $reason;
		$dados[2]= $state;
		$dados[3]= $userId;
		
		$queryUpdate = $this->db-> prepare("UPDATE ".$this->prefixo."userregistado set observacoes = ?, estadoConta = ? where nif = ? ");
		$algo = $this->db->execute($queryUpdate, $dados);
		if ($algo)
			return true;
		return false;

	}


	/**
	 * 
	 * RECEBE TODOS OS DADOS do user para os REDEFINIR
	 * enviar a senha a vazio "" para manter a antiga senha
	 * 
	 */

	function setTodosOsDados($nif, $nome, $sobreNome, $genero, $email, $morada, $codigoPostal, $distrito, $concelho,  $contacto, $anuncios, $senha=""){
		$dados = array();
		
		$dados[1]= $nome;
		$dados[2]= $sobreNome;
		$dados[3]= $genero;
		$dados[4]= $email;
		$dados[5]= $morada;
		$dados[6]= $codigoPostal;
		$dados[7]= $distrito;
		$dados[8]= $concelho;


		$dados[9]=$contacto;
		$dados[10]=$anuncios;
		
		$extraQuery="";

		if (trim($senha) != ""){
			$extraQuery = ", password = ? ";
			array_push($dados, "$".password_hash(md5(md5($senha).SENHA), PASSWORD_BCRYPT) );
		}
		
		$queryUpdate = $this->db-> prepare("UPDATE ".$this->prefixo."userregistado set			
			nome = ? ,
			sobreNome = ?,
			genero = ?,
			email = ?,
			morada = ?,
			codigoPostal = ?,
			distrito = ?,
			concelho = ?,

			contato = ?, 
			anuncios = ?
			".$extraQuery." 
			where nif = ? ");

		array_push($dados, $nif);
		
		$algo = $this->db->execute($queryUpdate, $dados);
		if ($algo)
			return true;
		return false;

		/**
		 
		UPDATE ptr_userregistado SET 
		nome = 'ALTERADO',
		sobreNome = 'ALTERADO',
		genero = 'F',
		email = 'teste@fff.com',
		morada = 'ALTERADO',
		codigoPostal='2554-368',
		distrito = 4,
		concelho = 4,
		dataNascimento = '2021-04-21',
		contato = 96655,
		anuncios = false
		where nif = 596
		 
		 */
	}



	
	/**
	 * 
	 * Define observaçoes internas para os administradores
	 */
	function setObservacoes($userId, $reason){
		$dados = array();
		$dados[1]= $reason;
		$dados[3]= $userId;
		
		$queryUpdate = $this->db-> prepare("UPDATE ".$this->prefixo."userregistado set observacoes = ? where nif = ? ");

		$algo = $this->db->execute($queryUpdate, $dados);
		if ($algo)
			return true;
		return false;

	}

	function getAllUser(){
		$resultadoFim = array();
		$login = $this->db-> prepare("SELECT * FROM ".$this->prefixo."userregistado"); 
		//$bindVariables = array(0=>$iduser);
		$resultado = $this->db->Execute($login);
		
		if ($resultado && $resultado->RecordCount()>0) { 
			while($linha=$resultado->FetchRow()){
				$resultado2 = array(
					"nif"  => $linha['nif'],
					"nome" => $linha['nome'],
					"sobreNome" => $linha['sobreNome'],
					"tipoDeConta" => $linha['tipoDeConta'],
					"dataRegisto" => $linha['dataRegistoTimeStamp'],
					"estadoConta" => $linha['estadoConta'],
					"observacoes" => $linha['observacoes']
				);
				array_push($resultadoFim, $resultado2);
			}
			return $resultadoFim;
		
		}

	}

	function ActivetAccount($idUser, $email, $code){

		$resultado = false;
		if ($code == md5(md5($idUser.$email).SENHA)){
			$activate = $this->db-> prepare("UPDATE ".$this->prefixo."userregistado set estadoConta = 31 WHERE nif = ".$idUser); 
			$resultado = $this->db->Execute($activate);
		}
		return $resultado;
	}



	function newPassword($idUser, $email, $code ,$passNova){



		if ($code == md5(md5($idUser.$email).SENHA)){

			$dados = array();
			$dados[1]= "$".password_hash(md5(md5($passNova).SENHA), PASSWORD_BCRYPT);
			$dados[2]= $idUser;
			
			$queryUpdate = $this->db-> prepare("UPDATE ".$this->prefixo."userregistado set password = ? where nif = ? ");
			$algo = $this->db->execute($queryUpdate, $dados);
			if ($algo)
				return true;
			return false;
		}

	}



	function getAllFornecedores(){
		$resultadoFim = array();
		$fornecedores = $this->db-> prepare("SELECT * FROM ".$this->prefixo."userregistado where tipoDeConta = 2 and estadoConta = 31 "); 
		//$bindVariables = array(0=>$iduser);
		$resultado = $this->db->Execute($fornecedores);
		
		if ($resultado && $resultado->RecordCount()>0) { 
			while($linha=$resultado->FetchRow()){
				$resultado2 = array(
					"nif"  => $linha['nif'],
					"nome" => $linha['nome'],
					"email" => $linha['email'],
					"sobreNome" => $linha['sobreNome'],
					"tipoDeConta" => $linha['tipoDeConta'],
				);
				array_push($resultadoFim, $resultado2);
			}
			return $resultadoFim;
		
		}
	
	}


	function setNotify($target, $mensagem, $titulo){
        $dados = array();
		$dados[0]= $target;
		$dados[1]= $mensagem;
		$dados[2]= $titulo;
		$dados[3]= date("d/m/Y");
        $registar = $this->db-> prepare("INSERT INTO ".$this->prefixo."avisos (idUser, mensagem, title, data) 
        VALUES (?, ?, ?, ?)");
		$algo = $this->db->execute($registar, $dados);
		if ($algo){
			return true;
		}
		return false;
    }

	function clearNotify($notifi){
		$resultado = false;
		$resultado = $this->db-> execute("UPDATE ".$this->prefixo."avisos set visto = 1 WHERE idAviso = ".$notifi); 
		return $resultado;
	}

	function getNotify($idUser){
		$resultadoFim = array();
		$getNotify = $this->db-> prepare("SELECT * FROM ".$this->prefixo."avisos where idUser=".$idUser." and visto = 0"); 
		
		$resultado = $this->db->Execute($getNotify);
		
		if ($resultado && $resultado->RecordCount()>0) { 
			while($linha=$resultado->FetchRow()){
				$resultado2 = array(
					"idAviso"  => $linha['idAviso'],
					"mensagem" => $linha['mensagem'],
					"title" => $linha['title'],
					"data" => $linha['data'],
				);
				array_push($resultadoFim, $resultado2);
			}
			return $resultadoFim;
		}
	}

}


/**
 * 
 * if ($resultado && $resultado->RecordCount()>0){
 *					
 *	while ($linha=$resultado->FetchRow()){
 *		echo "<option value='".$linha['id']."'  >".$linha['name']."</option>";
 *	}
 * 
 * 
 * 
 */

?>