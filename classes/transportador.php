<?php        
class transportador{
	
	var $db;
	var $prefixo;
	
	function __construct($db){
		$this->db = $db;
		$this->prefixo = "ptr_";
	}

	function createTransportador($idUserNif,$nomeEmpresa,$sedeMorada,$sedeCodigoPostal,$distrito,$concelho,$contacto,$garantiaEntregaXHoras,$webSite,$estado=0,$descricao){
		$dados = array();
		$dados[0]= $idUserNif;
		$dados[1]= $nomeEmpresa;
		$dados[2]= $descricao;
		$dados[3]= $sedeMorada;
		$dados[4]= $sedeCodigoPostal;
		$dados[5]= $distrito;
		$dados[6]= $concelho;
		$dados[7]= $contacto;
		$dados[8]= $garantiaEntregaXHoras;
        $dados[9]= $webSite;
		$dados[10]= $estado;
        $registar = $this->db-> prepare("INSERT INTO ".$this->prefixo."transportador (idUserNif, nomeEmpresa, descricao, sedeMorada, sedeCodigoPostal, distrito, concelho, contacto, garantiaEntregaXHoras, website, estado) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

		$algo = $this->db->execute($registar, $dados);
		if ($algo)
			return true;
		return false;
	}

	function existsEmpresa($idUserFornecedor){
		$query = $this->db-> prepare("SELECT idUserNif FROM ".$this->prefixo."transportador WHERE idUserNif = ".$idUserFornecedor);
		$resultado = $this->db->execute($query);
		return $resultado->RecordCount()>0;	
		
	}

	function getTodosOsDados($idUserFornecedor){
		$query = $this->db-> prepare("SELECT * FROM ".$this->prefixo."transportador WHERE idUserNif = ".$idUserFornecedor);
		$resultado = $this->db->execute($query);
		$resultado2 = null;
		if ($resultado && $resultado -> RecordCount()>0){
			$linha = $resultado->FetchRow();
			$resultado2 = array(
				"idTransportador"  => $linha['idUserNif'],
				"nomeEmpresa" => $linha['nomeEmpresa'],
				"descricao" => $linha['descricao'],
				"morada" => $linha['sedeMorada'],
				"codigoPostal" => $linha['sedeCodigoPostal'],
				"distrito" => $linha['distrito'],
				"concelho" =>  $linha['concelho'],
				"contato"=> $linha['contacto'],
				"garantiaEntregaXHoras"=> $linha['garantiaEntregaXHoras'],
				"webSite" => $linha['website'],
				"estado" => $linha['estado']
			);
			

		}
		return $resultado2;
	}

	function setTodosOsDados($idUserNif,$nomeEmpresa,$descricao,$sedeMorada,$sedeCodigoPostal,$distrito,$concelho,$contacto,$garantiaEntregaXHoras,$website,$estado){
		$dados = array();
		$dados[0]= $nomeEmpresa;
		$dados[1]= $descricao;
		$dados[2]= $sedeMorada;
		$dados[3]= $sedeCodigoPostal;
		$dados[4]= $distrito;
		$dados[5]= $concelho;
		$dados[6]= $contacto;
		$dados[7]= $garantiaEntregaXHoras;
		$dados[8]= $website;
		$dados[9]= $estado;
		
		$queryUpdate = $this->db-> prepare("UPDATE ".$this->prefixo."transportador set			
			nomeEmpresa = ? ,
			descricao = ? ,
			sedeMorada = ?,
			sedeCodigoPostal = ?,
			distrito = ?,
			concelho = ?,
			contacto = ?,
			garantiaEntregaXHoras = ?,
			website = ?,
			estado = ? WHERE idUserNif = ?");

		array_push($dados, $idUserNif);
		
		$algo = $this->db->execute($queryUpdate, $dados);
		if ($algo)
			return true;
		return false;
	}

	function getTodasTransportadoraDados(){
		$query = $this->db-> prepare("SELECT * FROM ".$this->prefixo."transportador ");
		$resultado = $this->db->execute($query);
		$resultado2 = null;
		$retorno = array();
		if ($resultado && $resultado -> RecordCount()>0){
			while ($linha = $resultado->FetchRow()){
				$resultado2 = array(
					"idTransportador"  => $linha['idUserNif'],
					"nomeEmpresa" => $linha['nomeEmpresa'],
					"descricao" => $linha['descricao'],
					"morada" => $linha['sedeMorada'],
					"codigoPostal" => $linha['sedeCodigoPostal'],
					"distrito" => $linha['distrito'],
					"concelho" =>  $linha['concelho'],
					"contato"=> $linha['contacto'],
					"garantiaEntregaXHoras"=> $linha['garantiaEntregaXHoras'],
					"webSite" => $linha['website'],
					"estado" => $linha['estado']
				);
				array_push($retorno, $resultado2);
			}

		}
		return $retorno;
	}

}
?>