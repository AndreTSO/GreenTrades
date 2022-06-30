<?php        
class produto{
	
	var $db;
	var $prefixo;
	
	function __construct($db){
		$this->db = $db;
		$this->prefixo = "ptr_";
	}

	function createProduto($idFornecedor, $nome, $descricao, $tipo, $tags, $precoSemIva, $recursosConsumidos, $custoManutencao, $estado, $tipoIVA, $modoDeVenda, $pesoPorVenda, $arquivado, $notasInternasAoFornecedor, $dataCriacaoTimeStamp, $validade=NULL){
		$dados = array();
        $dados[0]= $idFornecedor;
		$dados[1]= $nome;
		$dados[2]= $descricao;
		$dados[3]= $tipo;
		$dados[4]= $tags;
		$dados[5]= $precoSemIva;
		$dados[6]= $recursosConsumidos;
		$dados[7]= $custoManutencao;
		$dados[8]= $estado;
		$dados[9]= $tipoIVA;
		$dados[10]= $modoDeVenda;
		$dados[11]= $pesoPorVenda;
		$dados[12]= $arquivado;
		$dados[13]= $notasInternasAoFornecedor;
		$dados[14]= $dataCriacaoTimeStamp;
		$dados[15]= $validade;
        $registar = $this->db-> prepare("INSERT INTO ".$this->prefixo."produto (idFornecedor, nome, descricao, tipo, tags, precoSemIva, recursosConsumidos, custoManutencao, estado, tipoIVA, modoDeVenda, pesoPorVenda, arquivado, notasInternasAoFornecedor, dataCriacaoTimeStamp,validade) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");
  

		$algo = $this->db->execute($registar, $dados);
		
		if ($algo)
			return $this->db->insert_Id();
		return false;

	}

    function getTodosOsDados($idProduto){
		$armazem = $this->db-> prepare("SELECT * FROM ".$this->prefixo."produto WHERE idProduto= ".$idProduto); 
		$resultado = $this->db->Execute($armazem);
		
		if ($resultado && $resultado->RecordCount()>0) { 
			$linha=$resultado->FetchRow();
			$resultado2 = array(
                "idProduto" => $linha['idProduto'],
				"idFornecedor" => $linha['idFornecedor'],
                "nome" => $linha['nome'],
                "descricao" => $linha['descricao'],
                "tipo" => $linha["tipo"],
                "tags" => $linha["tags"],
                "precoSemIva" => $linha["precoSemIva"],
                "recursosConsumidos" => $linha["recursosConsumidos"],
                "custoManutencao" => $linha["custoManutencao"],
                "estado" => $linha["estado"],
                "tipoIVA" => $linha["tipoIVA"],
                "modoDeVenda" => $linha["modoDeVenda"],
                "pesoPorVenda" => $linha["pesoPorVenda"],
                "arquivado" => $linha["arquivado"],
                "notasInternasAoFornecedor" => $linha["notasInternasAoFornecedor"],
                "dataCriacaoTimeStamp" => $linha["dataCriacaoTimeStamp"],
				"validade" => $linha['validade']
			);
			return $resultado2;
		
			
		}
		return null;
	}

    function setTodosOsDados($idProduto, $idFornecedor, $nome, $descricao, $tipo, $tags, $precoSemIva, $recursosConsumidos, $custoManutencao, $estado, $tipoIVA, $modoDeVenda, $pesoPorVenda, $arquivado, $notasInternasAoFornecedor, $dataCriacaoTimeStamp, $validade=NULL){
		$dados = array();
        $dados[0]= $idFornecedor;
		$dados[1]= $nome;
		$dados[2]= $descricao;
		$dados[3]= $tipo;
		$dados[4]= $tags;
		$dados[5]= $precoSemIva;
		$dados[6]= $recursosConsumidos;
		$dados[7]= $custoManutencao;
		$dados[8]= $estado;
		$dados[9]= $tipoIVA;
		$dados[10]= $modoDeVenda;
		$dados[11]= $pesoPorVenda;
		$dados[12]= $arquivado;
		$dados[13]= $notasInternasAoFornecedor;
		$dados[14]= $dataCriacaoTimeStamp;
		$dados[15]=	$validade;	
		$dados[16]= $idProduto;

		$queryUpdate = $this->db-> prepare("UPDATE ".$this->prefixo."produto SET			
            idFornecedor = ?,
            nome = ?,
            descricao = ?,
            tipo = ?,
            tags = ?,
            precoSemIva = ?,
            recursosConsumidos = ?,
            custoManutencao = ?,
            estado = ?,
            tipoIVA = ?,
            modoDeVenda = ?,
            pesoPorVenda = ?,
            arquivado = ?,
            notasInternasAoFornecedor = ?,
            dataCriacaoTimeStamp = ?,
			validade = ?
			WHERE idProduto = ?");

		$algo = $this->db->execute($queryUpdate, $dados);


		if ($algo)
			return true;
		return false;
    }

    function addImg($idProduto, $idFoto){
		$dados = array();
        $dados[0]= $idProduto;
		$dados[1]= $idFoto;
        $registar = $this->db-> prepare("INSERT INTO ".$this->prefixo."img_produto (idProduto, idImagem) 
        VALUES (?, ?)");
		$algo = $this->db->execute($registar, $dados);
		
		if ($algo)
			return $this->db->insert_Id();
		return false;
	}

	function remImg($idProduto, $idFoto){
        $registar = $this->db-> prepare("DELETE FROM ".$this->prefixo."img_produto WHERE idProduto = ".$idProduto." AND idImagem like '".$idFoto."'");
		$algo = $this->db->execute($registar);
		if ($algo)
			return $this->db->insert_Id();
		return false;
	}

	/**
	 * Devolve todas as imagens de um produto num array
	 */
	function getImg($idProduto){
		$imagem = $this->db-> prepare("SELECT * FROM ".$this->prefixo."img_produto WHERE idProduto= ".$idProduto); 
		$resultado = $this->db->Execute($imagem);
		$resultado2 = array();
		if ($resultado && $resultado->RecordCount()>0) { 
			while($linha=$resultado->FetchRow()){
				array_push($resultado2, $linha[1]);
			}
		}
		return $resultado2;
	}

	function getImgById($idProduto, $idImagem){
		$imagem = $this->db-> prepare("SELECT * FROM ".$this->prefixo."img_produto WHERE idProduto= ".$idProduto." AND idImagem LIKE '".$idImagem."'"); 
		$resultado = $this->db->Execute($imagem);
		if ($resultado && $resultado->RecordCount()>0) {
			return true;
		}
		return false;
	}

	function existeProduto($idFornecedor){
		$query = $this->db-> prepare("SELECT idProduto FROM ".$this->prefixo."produto WHERE idFornecedor = ".$idFornecedor." AND arquivado = 0");
		$resultado = $this->db->execute($query);
		return $resultado->RecordCount()>0;
	}

	function getTodosOsProdutos($idFornecedor){
	
		$resultadoFim = array();
		$produto = $this->db-> prepare("SELECT * FROM ".$this->prefixo."produto WHERE idFornecedor=".$idFornecedor); 
		$resultado = $this->db->Execute($produto);
		
		if ($resultado && $resultado->RecordCount()>0) { 
			while($linha=$resultado->FetchRow()){
				$resultado2 = array(
					"idProduto"  => $linha['idProduto'],
					"idFornecedor" => $linha['idFornecedor'],
					"nome" => $linha['nome'],
					"descricao" => $linha['descricao'],
					"tipo" => $linha['tipo'],
					"tags" => $linha['tags'],
					"precoSemIva" => $linha['precoSemIva'],
					"recursosConsumidos" => $linha['recursosConsumidos'],
					"custoManutencao" => $linha['custoManutencao'],
					"estado" => $linha['estado'],
					"tipoIVA" => $linha['tipoIVA'],
					"modoDeVenda" => $linha['modoDeVenda'],
					"pesoPorVenda" => $linha['pesoPorVenda'],
					"arquivado" => $linha['arquivado'],
					"notasInternasAoFornecedor" => $linha['notasInternasAoFornecedor'],
					"dataCriacaoTimeStamp" => $linha['dataCriacaoTimeStamp'],
					"validade" => $linha['validade']
				);
				array_push($resultadoFim, $resultado2);
			}
			return $resultadoFim;
		}
	}

	function getTodosOsProdutosDoArmazem($idProduto, $idArmazem){
		$produto = $this->db-> prepare("SELECT stock FROM ".$this->prefixo."produto_armazem WHERE idProduto=".$idProduto." AND idArmazemFornecedor=".$idArmazem);
		
		$resultado = $this->db->execute($produto);
		if ($resultado && $resultado->RecordCount()>0) {
			$linha = $resultado->FetchRow();
			return $linha[0];
		}
		return 0;
	}

	function eliminarProduto($idProduto){
		$produto = $this->db-> prepare("UPDATE ".$this->prefixo."produto SET arquivado = 1 WHERE idProduto=".$idProduto);
		$algo = $this->db->execute($produto);
		if ($algo)
			return true;
		return false;
	}

	function atualizaStock($idProduto, $idArmazem, $stock){
		if($stock == 0){
			$pro = $this->db-> prepare("DELETE FROM ".$this->prefixo."produto_armazem WHERE idProduto=".$idProduto." AND idArmazemFornecedor=".$idArmazem);
			$res = $this->db->execute($pro);
			if ($res)
				return true;
			return false;
		}else{
			$produto = $this->db-> prepare("SELECT stock FROM ".$this->prefixo."produto_armazem WHERE idProduto=".$idProduto." AND idArmazemFornecedor=".$idArmazem);
			$resultado = $this->db->execute($produto);
			if ($resultado && $resultado->RecordCount()>0) {
				$produto2 = $this->db-> prepare("UPDATE ".$this->prefixo."produto_armazem SET stock=".$stock." WHERE idProduto=".$idProduto." AND idArmazemFornecedor=".$idArmazem);
				$algo = $this->db->execute($produto2);
				if ($algo)
					return true;
				return false;
			}else{
				$dados = array();
				$dados[0]= $idProduto;
				$dados[1]= $idArmazem;
				$dados[2]= $stock;
				$dados[3]= 0;
				$registar = $this->db-> prepare("INSERT INTO ".$this->prefixo."produto_armazem (idProduto, idArmazemFornecedor, stock, quantReservada) 
				VALUES (?, ?, ?, ?)");

				$algo2 = $this->db->execute($registar, $dados);
				
				if ($algo2)
					return true;
				return false;

			}
		}
	}

	function existeProdutoArmazem($idProduto){
		$query = $this->db-> prepare("SELECT * FROM ".$this->prefixo."produto_armazem WHERE idProduto = ".$idProduto);
		$resultado = $this->db->execute($query);
		if ($resultado && $resultado->RecordCount()>0) {
			return true;
		}
		return false;
	}

	function existeProdutoArmazem2 ($idProduto){
		$query = $this->db-> prepare("SELECT * FROM ".$this->prefixo."produto_armazem WHERE idProduto = ".$idProduto);
		$resultado = $this->db->execute($query);
		if ($resultado && $resultado->RecordCount()>0) {
			return $resultado -> FetchRow();
		}
		return false;
	}

	function getRealPrice($idProduto){
		$query = $this->db-> prepare("SELECT * FROM ".$this->prefixo."produto WHERE idProduto = ".$idProduto);
		$resultado = $this->db->execute($query);
		if ($resultado && $resultado->RecordCount()>0) {
			while($linha=$resultado->FetchRow()){
				return round($linha['precoSemIva'] + ($linha['precoSemIva']*(intval($linha['tipoIVA'])/100)), 2);
			}
		}
		return 0;
	}

	function getTodosOsProdutosDoArmazemId($idArmazem){
		$resultadoFim = array();
		$produto = $this->db-> prepare("SELECT idProduto FROM ".$this->prefixo."produto_armazem WHERE idArmazemFornecedor=".$idArmazem); 
		$resultado = $this->db->Execute($produto);
		
		if ($resultado && $resultado->RecordCount()>0) { 
			while($linha=$resultado->FetchRow()){
				array_push($resultadoFim, $this->getTodosOsDados($linha[0]));
			}
		}
		return $resultadoFim;
	}

	function getStockdoProduto($idProduto,$idArmazem){
		$counter = 0;
		$produto = $this->db-> prepare("SELECT stock FROM ".$this->prefixo."produto_armazem WHERE idArmazemFornecedor=".$idArmazem." AND idProduto=".$idProduto); 
		$resultado = $this->db->Execute($produto);
		if ($resultado && $resultado->RecordCount()>0) {
			while($linha=$resultado->FetchRow()){
				$counter = $counter + intval($linha[0]);
			}
		}
		return $counter;
	}

	function getRandomProducts($limiteMin=0, $limiteMax=8, $extraQuery="", $random=true){
		$addRandom="";
		if ($random){
			$addRandom = "ORDER BY RAND()";
		}
		$resultadoFim = array();
		$produto = $this->db-> prepare("SELECT * FROM ".$this->prefixo."produto ".$addRandom." LIMIT ".$limiteMax); 
		$resultado = $this->db->Execute($produto);
		
		if ($resultado && $resultado->RecordCount()>0) { 
			while($linha=$resultado->FetchRow()){
				$resultado2 = array(
					"idProduto"  => $linha['idProduto'],
					"idFornecedor" => $linha['idFornecedor'],
					"nome" => $linha['nome'],
					"descricao" => $linha['descricao'],
					"tipo" => $linha['tipo'],
					"tags" => $linha['tags'],
					"precoSemIva" => $linha['precoSemIva'],
					"recursosConsumidos" => $linha['recursosConsumidos'],
					"custoManutencao" => $linha['custoManutencao'],
					"estado" => $linha['estado'],
					"tipoIVA" => $linha['tipoIVA'],
					"modoDeVenda" => $linha['modoDeVenda'],
					"pesoPorVenda" => $linha['pesoPorVenda'],
					"arquivado" => $linha['arquivado'],
					"notasInternasAoFornecedor" => $linha['notasInternasAoFornecedor'],
					"dataCriacaoTimeStamp" => $linha['dataCriacaoTimeStamp'],
					"validade" => $linha['validade']
				);
				array_push($resultadoFim, $resultado2);
			}
			return $resultadoFim;
		}

	}

	function getProductsSite($categoriaPapi = null, $paramPesquisa=null , $paramSubCategoria =null, $random = false ){

		$extra = "";
		$extra2 = "";
		$extra3 = "";
		if ($categoriaPapi != null){
			$extra = "and tipo =".$categoriaPapi;
		}
		if ($paramPesquisa != null){
			$extra2 = "and nome like '%".$paramPesquisa."%' and descricao like '%".$paramPesquisa."%'";
		}

		if ($paramSubCategoria != null){
			$extra3 = "and tags =".$paramSubCategoria;
		}



		$addRandom="";
		if ($random){
			$addRandom = "ORDER BY RAND()";
		}
		$resultadoFim = array();
		$q  = "SELECT * FROM ".$this->prefixo."produto  where 1=1 ".$extra." ".$extra2." ".$extra3." ".$addRandom;
		$produto = $this->db-> prepare($q); 
		$resultado = $this->db->Execute($produto);
		
		if ($resultado && $resultado->RecordCount()>0) { 
			while($linha=$resultado->FetchRow()){
				$resultado2 = array(
					"idProduto"  => $linha['idProduto'],
					"idFornecedor" => $linha['idFornecedor'],
					"nome" => $linha['nome'],
					"descricao" => $linha['descricao'],
					"tipo" => $linha['tipo'],
					"tags" => $linha['tags'],
					"precoSemIva" => $linha['precoSemIva'],
					"recursosConsumidos" => $linha['recursosConsumidos'],
					"custoManutencao" => $linha['custoManutencao'],
					"estado" => $linha['estado'],
					"tipoIVA" => $linha['tipoIVA'],
					"modoDeVenda" => $linha['modoDeVenda'],
					"pesoPorVenda" => $linha['pesoPorVenda'],
					"arquivado" => $linha['arquivado'],
					"notasInternasAoFornecedor" => $linha['notasInternasAoFornecedor'],
					"dataCriacaoTimeStamp" => $linha['dataCriacaoTimeStamp'],
					"validade" => $linha['validade']
				);
				array_push($resultadoFim, $resultado2);
			}
			return $resultadoFim;
		}

	}

		
}
?>