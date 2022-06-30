<?php        
class baseTransportador{
	
	var $db;
	var $prefixo;
	
	function __construct($db){
		$this->db = $db;
		$this->prefixo = "ptr_";
	}

	function createBaseTransportador($idTransportador,$nome,$morada,$distrito,$concelho,$codigoPostal,$custoManutencao,$poluicaoGerada,$estado){
		$dados = array();
		$dados[0]= $idTransportador;
		$dados[1]= $nome;
		$dados[2]= $morada;
		$dados[3]= $distrito;
		$dados[4]= $concelho;
		$dados[5]= $codigoPostal;
		$dados[6]= $custoManutencao;
		$dados[7]= $poluicaoGerada;
        $dados[8]= $estado;
        $registar = $this->db-> prepare("INSERT INTO ".$this->prefixo."basestransportador (idTransportador,nome,morada,distrito,concelho,codigoPostal,custoManutencao,poluicaoGerada,estado) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  

		$algo = $this->db->execute($registar, $dados);
		if ($algo)
			return true;
		return false;

	}

	function existsBase($idTransportador){
		$query = $this->db-> prepare("SELECT idBase FROM ".$this->prefixo."basestransportador WHERE idTransportador = ".$idTransportador);
		$resultado = $this->db->execute($query);
		return $resultado->RecordCount()>0;	
		
	}

	function getTodosOsDados($idTransportador){
		$query = $this->db-> prepare("SELECT * FROM ".$this->prefixo."basestransportador WHERE idTransportador = ".$idTransportador);
		$resultado = $this->db->execute($query);
		$resultado2 = null;
		$retorno = array();
		if ($resultado && $resultado -> RecordCount()>0){
			while($linha = $resultado->FetchRow()){
				$resultado2 = array(
				"idBase"  => $linha['idBase'],
				"idTransportador" => $linha['idTransportador'],
				"nome" => $linha['nome'],
				"morada" => $linha['morada'],
				"distrito" => $linha['distrito'],
				"concelho" =>  $linha['concelho'],
				"codigoPostal" => $linha['codigoPostal'],
				"custoManutencao"=> $linha['custoManutencao'],
				"poluicaoGerada"=> $linha['poluicaoGerada'],
				"estado" => $linha['estado']
				);
				array_push($retorno, $resultado2);
			}
		}
		return $retorno;
	}

	function setTodosOsDados($idBase,$idTransportador,$nome,$morada,$distrito,$concelho,$codigoPostal,$custoManutencao,$poluicaoGerada,$estado){
		$dados = array();
		$dados[0]= $idTransportador;
		$dados[1]= $nome;
		$dados[2]= $morada;
		$dados[4]= $distrito;
		$dados[5]= $concelho;
		$dados[6]= $codigoPostal;
		$dados[7]= $custoManutencao;
		$dados[8]= $poluicaoGerada;
		$dados[9]= $estado;
		
		$queryUpdate = $this->db-> prepare("UPDATE ".$this->prefixo."basestransportador set			
			idTransportador = ? ,
			nome = ? ,
			morada = ?,
			distrito = ?,
			concelho = ?,
			codigoPostal = ?,
			custoManutencao = ?,
			poluicaoGerada = ?,
			estado = ? WHERE idBase = ?");

		array_push($dados, $idBase);
		
		$algo = $this->db->execute($queryUpdate, $dados);
		if ($algo)
			return true;
		return false;
	}

	function getTipoVeiculo(){
		$tipo = $this->db->prepare("SELECT idTipo,tipo FROM ".$this->prefixo."tipoVeiculo");
		$result = $this->db->execute($tipo);
		return $result;
	}

	function getBase($idBase){
		$veiculo = $this->db-> prepare("SELECT * FROM ".$this->prefixo."basestransportador WHERE idBase= ".$idBase); 
		$resultado = $this->db->Execute($veiculo);
		
		if ($resultado && $resultado->RecordCount()>0) { 
			$linha=$resultado->FetchRow();
			$resultado2 = array(
				"idBase"  => $linha['idBase'],
				"idTransportador" => $linha['idTransportador'],
				"nome" => $linha['nome'],
				"morada" => $linha['morada'],
				"distrito" => $linha['distrito'],
				"concelho" =>  $linha['concelho'],
				"codigoPostal" => $linha['codigoPostal'],
				"custoManutencao"=> $linha['custoManutencao'],
				"poluicaoGerada"=> $linha['poluicaoGerada'],
				"estado" => $linha['estado']
			);
			return $resultado2;
		}
		return null;
	}
	
	
}
?>