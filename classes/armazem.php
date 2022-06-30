<?php        
class armazem{
	
	var $db;
	var $prefixo;
	
	function __construct($db){
		$this->db = $db;
		$this->prefixo = "ptr_";
	}

	function createArmazem($idFornecedor, $nome, $morada, $nPorta, $andar, $distrito, $concelho, $codigoPostal, $custoManutencao, $estado, $poluicaoGerada){
		$dados = array();
        $dados[0]= $idFornecedor;
		$dados[1]= $nome;
		$dados[2]= $morada;
		$dados[3]= $nPorta;
		$dados[4]= $andar;
		$dados[5]= $distrito;
		$dados[6]= $concelho;
		$dados[7]= $codigoPostal;
		$dados[8]= $custoManutencao;
		$dados[9]= $estado;
		$dados[10]= $poluicaoGerada;
        $registar = $this->db-> prepare("INSERT INTO ".$this->prefixo."armazemfornecedor (idFornecedor, nome, morada, nPorta, andar, distrito, concelho, codigoPostal, custoManutencao, estado, poluicaoGerada) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  

		$algo = $this->db->execute($registar, $dados);
		if ($algo)
			return true;
		return false;

	}

    function getTodosOsDados($idArmazemFornecedor){
		$armazem = $this->db-> prepare("SELECT * FROM ".$this->prefixo."armazemfornecedor WHERE idArmazemFornecedor=? "); 
		$bindVariables = array(0=>$idArmazemFornecedor);
		$resultado = $this->db->Execute($armazem, $bindVariables);
		
		if ($resultado && $resultado->RecordCount()>0) { 
			$linha=$resultado->FetchRow();
			$resultado2 = array(
				"idArmazemFornecedor"  => $linha['idArmazemFornecedor'],
				"idFornecedor" => $linha['idFornecedor'],
				"nome" => $linha['nome'],
				"morada" => $linha['morada'],
				"nPorta" => $linha['nPorta'],
				"andar" => $linha['andar'],
				"distrito" => $linha['distrito'],
				"concelho" => $linha['concelho'],
				"codigoPostal" => $linha['codigoPostal'],
				"custoManutencao" => $linha['custoManutencao'],
				"estado" => $linha['estado'],
				"poluicaoGerada" => $linha['poluicaoGerada'],
			);
			return $resultado2;
		
			
		}
		return null;
	}

    function setTodosOsDados($idArmazemFornecedor, $idFornecedor, $nome, $morada, $nPorta, $andar, $distrito, $concelho, $codigoPostal, $custoManutencao, $estado, $poluicaoGerada){
		$dados = array();
        $dados[0]= $idFornecedor;
		$dados[1]= $nome;
		$dados[2]= $morada;
		$dados[3]= $nPorta;
		$dados[4]= $andar;
		$dados[5]= $distrito;
		$dados[6]= $concelho;
		$dados[7]= $codigoPostal;
		$dados[8]= $custoManutencao;
		$dados[9]= $estado;
		$dados[11]= $poluicaoGerada;
		$dados[12]= $idArmazemFornecedor;
		
		$queryUpdate = $this->db-> prepare("UPDATE ".$this->prefixo."armazemfornecedor SET			
            idFornecedor = ?,
            nome = ?,
            morada = ?,
            nPorta = ?,
            andar = ?,
            distrito = ?,
            concelho = ?,
            codigoPostal = ?,
            custoManutencao = ?,
            estado = ?,
            poluicaoGerada = ? WHERE idArmazemFornecedor = ?");
		$algo = $this->db->execute($queryUpdate, $dados);
		if ($algo)
			return true;
		return false;
    }

	function getTodosOsArmazens($idFornecedor){
		$resultadoFim = array();
		$armazem = $this->db-> prepare("SELECT * FROM ".$this->prefixo."armazemfornecedor WHERE idFornecedor=".$idFornecedor); 
		$resultado = $this->db->Execute($armazem);
		
		if ($resultado && $resultado->RecordCount()>0) { 
			while($linha=$resultado->FetchRow()){
				$resultado2 = array(
					"idArmazemFornecedor"  => $linha['idArmazemFornecedor'],
					"idFornecedor" => $linha['idFornecedor'],
					"nome" => $linha['nome'],
					"morada" => $linha['morada'],
					"nPorta" => $linha['nPorta'],
					"andar" => $linha['andar'],
					"distrito" => $linha['distrito'],
					"concelho" => $linha['concelho'],
					"codigoPostal" => $linha['codigoPostal'],
					"custoManutencao" => $linha['custoManutencao'],
					"estado" => $linha['estado'],
					"poluicaoGerada" => $linha['poluicaoGerada']
				);
				array_push($resultadoFim, $resultado2);
			}
			return $resultadoFim;
		}
	}

	function existeArmazem($idFornecedor){
		$query = $this->db-> prepare("SELECT idArmazemFornecedor FROM ".$this->prefixo."armazemfornecedor WHERE idFornecedor = ".$idFornecedor);
		$resultado = $this->db->execute($query);
		return $resultado->RecordCount()>0;
	}

	function contarProdutosArmazem($idArmazemFornecedor){
		$counter = 0;
		$query = $this->db-> prepare("SELECT * FROM ".$this->prefixo."produto_armazem WHERE idArmazemFornecedor = ".$idArmazemFornecedor);
		$resultado = $this->db->execute($query);
		if ($resultado && $resultado->RecordCount()>0) { 
			while($linha=$resultado->FetchRow()){
				$counter += 1;
			}
		}
		return $counter;
	}

	function eliminarArmazem($idArmazemFornecedor){
		$pro = $this->db-> prepare("UPDATE ".$this->prefixo."armazemfornecedor SET estado = 37 WHERE idArmazemFornecedor =".$idArmazemFornecedor);
		$res = $this->db->execute($pro);
		if ($res)
			return true;
		return false;
	}

	function removerProdutoArmazem($idProduto, $idArmazemFornecedor){
		$pro = $this->db-> prepare("DELETE FROM ".$this->prefixo."produto_armazem WHERE idProduto =".$idProduto." AND idArmazemFornecedor =".$idArmazemFornecedor);
		$res = $this->db->execute($pro);
		if ($res)
			return true;
		return false;
	}

	function getStockandLoc($idProduto){
		$query = $this->db-> prepare("SELECT * FROM ".$this->prefixo."produto_armazem WHERE idProduto = ".$idProduto." LIMIT 1");
		$resultado = $this->db->execute($query);
		if ($resultado && $resultado->RecordCount()>0) { 
			$linha=$resultado->FetchRow();
				$resultado2 = array(
					"idArmazemFornecedor"  => $linha['idArmazemFornecedor'],
					"stock" => $linha['stock']
				);
				return $resultado2;
		}
		$resultado2 = array();
		return $resultado2;
		
	}

}
?>