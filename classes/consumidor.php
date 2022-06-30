<?php        
class consumidor{
	
	var $db;
	var $prefixo;
	var $idUser;
	
	function __construct($db, $idUser){
		$this->db = $db;
		$this->idUser = $idUser;
		$this->prefixo = "ptr_";
	}

	function getArtigosCesto(){
		$artigos = $this->db-> prepare("SELECT * FROM ".$this->prefixo."cesto WHERE idUser = ".$this->idUser);
		$algo = $this->db->execute($artigos);
		return $algo;
	}

	function getTotalPriceArtigosCesto(){}
        
    function getNumberArticlesOfCesto(){
		$artigos = $this->db-> prepare("SELECT SUM(quantidade) FROM ".$this->prefixo."cesto WHERE idUser = ".$this->idUser);
		$algo = $this->db->execute($artigos);
		return $algo;
	}


    function productInCesto($idP){
		$artigos = $this->db-> prepare("SELECT * FROM ".$this->prefixo."cesto WHERE idArtigo = ".$idP);
		$algo = $this->db->execute($artigos);
		if($algo && $algo->RecordCount()>0){
			return true;
		}
		return false;
	}

	function addArtigosCesto($idArtigo, $quantidade){
		if($this->productInCesto($idArtigo)){
			$artigos = $this->db-> prepare("UPDATE ".$this->prefixo."cesto SET quantidade = quantidade + ".(int)$quantidade." WHERE idUser =".$this->idUser." AND idArtigo =".$idArtigo);
		}else{
			$artigos = "INSERT INTO ".$this->prefixo."cesto (quantidade, idUser, idArtigo) VALUES (".(int)$quantidade.", ".$this->idUser.", ".$idArtigo.")";
		}
		$resultado = $this->db->execute($artigos);
		if ($resultado){
			return true;
		}else{
			return false;
		}
	}


    function remArtigosCesto($idArtigo, $quantidade){
		if($this->productInCesto($idArtigo)){
			$artigos = $this->db-> prepare("UPDATE ".$this->prefixo."cesto SET quantidade = quantidade - ".$quantidade." WHERE idUser =".$this->idUser." AND idArtigo =".$idArtigo);
			$algo = $this->db->execute($artigos);
		}
	}

    function remAllArtigosCesto($idArtigo){
		$artigos = $this->db-> prepare("DELETE FROM ".$this->prefixo."cesto WHERE idArtigo = ".$idArtigo." AND idUser =".$this->idUser);
		$algo = $this->db->execute($artigos);
	}



    function updQuantArtgCesto($idP, $newQuant){
		$artigos = $this->db-> execute("UPDATE ".$this->prefixo."cesto set quantidade = ".$newQuant." WHERE idArtigo = ".$idP);
		if ($artigos){
			return true;
		}else{
			return false;
		}
	}



	
    function wipeCesto(){
		$delete = $this->db-> prepare("DELETE FROM ".$this->prefixo."cesto WHERE idUser =".$this->idUser);
		$algo = $this->db->execute($delete);
		if ($algo){ return true; }else{ return false; }
	}

	function isCestoOcupied(){
		$resultdo =  $this->getNumberArticlesOfCesto();
		if (isset($resultdo)){
			$resultdo  = $resultdo->FetchRow();
			return (intval($resultdo[0]) != 0);
		}else{
			return true;
		}
	}


}

?>