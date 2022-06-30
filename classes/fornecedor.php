<?php        
class fornecedor{
	
	var $db;
	var $prefixo;
	
	function __construct($db){
		$this->db = $db;
		$this->prefixo = "ptr_";
	}

	function createFornecedor($idFornecedor,$descricao,$nomeEmpresa,$morada,$codigoPostal,$distrito,$concelho,$contacto,$webSite,$periodoXDiasCancelar,$poluicaoGerada,$consumoRecursos,$estado){
		$dados = array();
		$dados[0]= $idFornecedor;
		$dados[1]= $descricao;
		$dados[2]= $nomeEmpresa;
		$dados[3]= $morada;
		$dados[4]= $codigoPostal;
		$dados[5]= $distrito;
		$dados[6]= $concelho;
		$dados[7]= $contacto;
		$dados[8]= $webSite;
		$dados[9]= $periodoXDiasCancelar;
		$dados[10]= $poluicaoGerada;
		$dados[11]= $consumoRecursos;
		$dados[12]= $estado;
        $registar = $this->db-> prepare("INSERT INTO ".$this->prefixo."fornecedor (idFornecedor, descricao, nomeEmpresa, morada,codigoPostal,distrito,concelho,contato, webSite, PeriodoXDiasCancelar, poluicaoGerada, consumoRecursos, estado) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  

		$algo = $this->db->execute($registar, $dados);
		if ($algo)
			return true;
		return false;

	}

	function existsEmpresa($idUserFornecedor){
		
		$query = $this->db-> prepare("SELECT idFornecedor FROM ".$this->prefixo."fornecedor WHERE idFornecedor = ".$idUserFornecedor);
		$resultado = $this->db->execute($query);
		return $resultado->RecordCount()>0;	
		
	}

	function getTodosOsDados($idUserFornecedor){
		$query = $this->db-> prepare("SELECT * FROM ".$this->prefixo."fornecedor WHERE idFornecedor = ".$idUserFornecedor);
		$resultado = $this->db->execute($query);
		$resultado2 = null;
		if ($resultado && $resultado -> RecordCount()>0){
			$linha = $resultado->FetchRow();
			$resultado2 = array(
				"idFornecedor"  => $linha['idFornecedor'],
				"descricao" => $linha['descricao'],
				"nomeEmpresa" => $linha['nomeEmpresa'],
				"morada" => $linha['morada'],
				"codigoPostal" => $linha['codigoPostal'],
				"distrito" => $linha['distrito'],
				"concelho" =>  $linha['concelho'],
				"contacto"=> $linha['contato'],
				"webSite" => $linha['webSite'],
				"PeriodoXDiasCancelar" => $linha['PeriodoXDiasCancelar'],
				"poluicaoGerada" => $linha['poluicaoGerada'],
				"consumoRecursos" => $linha['consumoRecursos'],
				"estado" => $linha['estado']
			);
			

		}
		return $resultado2;
	}

	function setTodosOsDados($idFornecedor,$descricao,$nomeEmpresa,$morada,$codigoPostal,$distrito,$concelho,$contacto,$webSite,$periodoXDiasCancelar,$poluicaoGerada,$consumoRecursos,$estado){
		$dados = array();

		$dados[0]= $descricao;
		$dados[1]= $nomeEmpresa;
		$dados[2]= $morada;
		$dados[3]= $codigoPostal;
		$dados[4]= $distrito;
		$dados[5]= $concelho;
		$dados[6]= $contacto;
		$dados[7]= $webSite;
		$dados[8]= $periodoXDiasCancelar;
		$dados[9]= $poluicaoGerada;
		$dados[10]= $consumoRecursos;
		$dados[11]= $estado;
		
		$queryUpdate = $this->db-> prepare("UPDATE ".$this->prefixo."fornecedor set			
			descricao = ? ,
			nomeEmpresa = ?,
			morada = ?,
			codigoPostal = ?,
			distrito = ?,
			concelho = ?,
			contato = ?,
			webSite = ?,
			PeriodoXDiasCancelar = ?,
			poluicaoGerada = ?,
			ConsumoRecursos = ?,
			estado = ? WHERE idFornecedor = ?");

		array_push($dados, $idFornecedor);
		
		$algo = $this->db->execute($queryUpdate, $dados);
		if ($algo)
			return true;
		return false;
	}

}
?>