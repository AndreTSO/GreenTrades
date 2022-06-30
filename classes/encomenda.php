<?php        
class encomenda{
	
	var $db;
	var $prefixo;
	
	function __construct($db){
		$this->db = $db;
		$this->prefixo = "ptr_";
	}

	function createEncomenda($idCliente, $nome, $sobreNome, $email, $telefone, $nif, $morada, $codigoPostal, $distrito,	$concelho, $dataEncomenda, $estadoEncomenda, $poluicaoTotalGerada=0,$mensagemAdicional, $nomeFicheiroFatura=NULL, $transportadora, $valorFinal){
		$dados = array();
        $dados[0]= $this-> geraChave(10);
		$dados[1]= $idCliente;
		$dados[2]= $nome;
		$dados[3]= $sobreNome;
		$dados[4]= $email;
		$dados[5]= $telefone;
		$dados[6]= $nif;
		$dados[7]= $morada;
		$dados[8]= $codigoPostal;
		$dados[9]= $distrito;
		$dados[10]= $concelho;
		$dados[11]= $dataEncomenda;
		$dados[12]= $estadoEncomenda;
		$dados[13]= $poluicaoTotalGerada;
		$dados[14]= $mensagemAdicional;
		$dados[15]= $nomeFicheiroFatura;
		$dados[16]= $transportadora;
		$dados[17]= $valorFinal;
        $registar = $this->db-> prepare("INSERT INTO ".$this->prefixo."encomenda (refEncomenda, idCliente, nome, sobreNome, email, telefone, nif, morada, codigoPostal, distrito, concelho, dataEncomenda, estadoEncomenda, poluicaoTotalGerada, mensagemAdicional, nomeFicheiroFatura, transportadora, valorFinal) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");
  

		$algo = $this->db->execute($registar, $dados);
		
		if ($algo)
			return $this->db->insert_Id();
		return false;

	}

	function geraChave($nCaracteres=1, $mapaCaracteres = ['A','B','C','D','E','F','G','H','I','J','L','M','N','O','P','Q','R','S','T','U','V','X','Z','K','Y','W','1','2','3','4','5','6','7','8','9','0']){
        $key="";
        for ($i = 0;$i <$nCaracteres; $i++) {
            $key.=$mapaCaracteres[rand(0, count($mapaCaracteres)-1)];
        }
        return $key;
    }

	function createSubEncomenda($idEncomendaPai, $estadoSubEncomenda, $poluicaoGerada, $idFornecedor){
		$dados = array();
        $dados[0]= $idEncomendaPai;
		$dados[1]= $estadoSubEncomenda;
		$dados[2]= $poluicaoGerada;
		$dados[3]= $idFornecedor;

		$registar = $this->db-> prepare("INSERT INTO ".$this->prefixo."subencomenda (idEncomendaPai, estadoSubEncomenda, poluicaoGerada, idFornecedor) 
        VALUES (?, ?, ?, ?) ");
  

		$algo = $this->db->execute($registar, $dados);
		
		if ($algo)
			return $this->db->insert_Id();
		return false;
	}

	function createArtigoSubEncomenda($idSubEncomenda, $idProdutoArmazem, $nome, $descricao, $quantidade, $valorArtigo, $poluicao, $idArtigo, $ivaArtigo){
		$dados = array();
        $dados[0]= $idSubEncomenda;
		$dados[1]= $idProdutoArmazem;
		$dados[2]= $nome;
		$dados[3]= $descricao;
		$dados[4]= $quantidade;
		$dados[5]= $valorArtigo;
		$dados[6]= $poluicao;
		$dados[7]= $idArtigo;
		$dados[8]= $ivaArtigo;

		$registar = $this->db-> prepare("INSERT INTO ".$this->prefixo."artigossubencomenda (idSubEncomenda, idProdutoArmazem, nome, descricao, quantidade, valorArtigo, poluicao, idArtigo, ivaArtigo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

		$algo = $this->db->execute($registar, $dados);
		
		if ($algo)
			return true;
		return false;
	}

    function getTodosOsDadosEncomenda($idEncomenda){
		$encomenda = $this->db-> prepare("SELECT * FROM ".$this->prefixo."encomenda WHERE idEncomenda= ".$idEncomenda); 
		$resultado = $this->db->Execute($encomenda);
		
		if ($resultado && $resultado->RecordCount()>0) { 
			$linha=$resultado->FetchRow();
			$resultado2 = array(
                "idEncomenda" => $linha['idEncomenda'],
				"refEncomenda" => $linha['refEncomenda'],
                "idCliente" => $linha['idCliente'],
                "nome" => $linha['nome'],
                "sobreNome" => $linha["sobreNome"],
                "email" => $linha["email"],
                "telefone" => $linha["telefone"],
                "nif" => $linha["nif"],
                "morada" => $linha["morada"],
                "codigoPostal" => $linha["codigoPostal"],
                "distrito" => $linha["distrito"],
                "concelho" => $linha["concelho"],
                "dataEncomenda" => $linha["dataEncomenda"],
                "estadoEncomenda" => $linha["estadoEncomenda"],
                "poluicaoTotalGerada" => $linha["poluicaoTotalGerada"],
                "mensagemAdicional" => $linha["mensagemAdicional"],
                "nomeFicheiroFatura" => $linha["nomeFicheiroFatura"],
				"transportadora" => $linha['transportadora']
			);
			return $resultado2;
		
			
		}
		return null;
	}

	function getTodosOsDadosSubEncomenda($idSubEncomenda){
		$subEncomenda = $this->db-> prepare("SELECT * FROM ".$this->prefixo."subencomenda WHERE idSubEncomenda= ".$idSubEncomenda); 
		$resultado = $this->db->Execute($subEncomenda);
		
		if ($resultado && $resultado->RecordCount()>0) { 
			$linha=$resultado->FetchRow();
			$resultado2 = array(
                "idSubEncomenda" => $linha['idSubEncomenda'],
				"idEncomendaPai" => $linha['idEncomendaPai'],
                "estadoSubEncomenda" => $linha['estadoSubEncomenda'],
                "poluicaoGerada" => $linha['poluicaoGerada'],
                "idFornecedor" => $linha["idFornecedor"],
                "idArtigo" => $linha["idArtigo"],
                "ivaArtigo" => $linha["ivaArtigo"]
			);
			return $resultado2;
		
			
		}
		return null;
	}

   function setEstadoEncomenda($estado, $idEncomenda){
		$resultado = $this->db->Execute("UPDATE ".$this->prefixo."encomenda SET estadoEncomenda = ".$estado." WHERE idEncomenda = ".$idEncomenda);
		return $resultado;
   }


   function getArtigosSubEncomenda($idEncomenda){
	   $q = "SELECT * FROM ".$this->prefixo."artigossubencomenda WHERE idSubEncomenda = 
	   										(SELECT idSubEncomenda FROM ".$this->prefixo."subencomenda WHERE idEncomendaPai = ".$idEncomenda.")";
		
		$resultado = $this->db->Execute($q);
		$artigos  =array();
		if ($resultado && $resultado->RecordCount()>0) {
			while($linha = $resultado ->FetchRow()){
				array_push($artigos, $linha);
			}
		} 
		return $artigos;

   }
		
}
?>