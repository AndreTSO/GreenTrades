<?php        
class lib{
	
	var $db;
	var $prefixo;
		
	function __construct($db){
		$this->db = $db;
		$this->prefixo = "ptr_";
		
	}


	function getEstados($tipo){
		$query = $this->db-> prepare("SELECT * FROM ".$this->prefixo."estados  WHERE tipo=? "); 
		$bindVariables = array(0=>$tipo);
		$resultado = $this->db->Execute($query, $bindVariables);
		
        $resultado2 = array();

		if ($resultado && $resultado->RecordCount()>0) { 
            while($linha=$resultado->FetchRow()){
                array_push($resultado2, $linha);
            }
		}
		return $resultado2;
	}

    function getEstadosById($id){
		$query = $this->db-> prepare("SELECT * FROM ".$this->prefixo."estados  WHERE idEstado=? "); 
		$bindVariables = array(0=>$id);
		$resultado = $this->db->Execute($query, $bindVariables);
		
		if ($resultado && $resultado->RecordCount()>0) { 
            $linha=$resultado->FetchRow();
            return $linha['estado'];
		}
         return "None";
	}



	function getCategoria($db) {
		$districts = $db->prepare("SELECT idCategoria,categoria FROM ".$this->prefixo."categorias ORDER BY categoria ASC");
		$result = $db->execute($districts);
		return $result;
	}
	
	function getSubCategoria($db) {
		$conselhos = $db->prepare("SELECT idsubcategoria ,subcategoria FROM ".$this->prefixo."subcategorias ORDER BY subcategoria ASC");
		$result = $db->execute($conselhos);
		return $result;
	}
	
	function getCategoriaById($db, $idCat) {
		$district = $db-> prepare("SELECT categoria FROM ".$this->prefixo."categorias WHERE idCategoria=?");
		$bindVariables = array(0=>$idCat);
		$resultado = $db->execute($district, $bindVariables);
		if ($resultado && $resultado->RecordCount()>0){
			$linha=$resultado->FetchRow();
			return $linha['categoria'];
		}
	}
	
	function getSubCategoriaById($db, $idCat) {
		$concelho = $db-> prepare("SELECT subcategoria FROM ".$this->prefixo."subcategorias WHERE idsubCategoria=?");
		$bindVariables = array(0=>$idCat);
		$resultado = $db->execute($concelho, $bindVariables);
		if ($resultado && $resultado->RecordCount()>0){
			$linha=$resultado->FetchRow();
			return $linha['subcategoria'];
		}
	}

	function getSubCategoriaByCategoriaId($db, $idCat) {
		$concelho = $db-> prepare("SELECT idsubcategoria,subcategoria FROM ".$this->prefixo."subcategorias WHERE idCategoria=? ORDER BY subcategoria ASC");
		$bindVariables = array(0=>$idCat);
		$result = $db->execute($concelho, $bindVariables);
		return $result;
	}

	function getSubCategoriaNome($idSubCategoria){
		$query = $this->db-> prepare("SELECT * FROM ".$this->prefixo."subcategorias WHERE idsubCategoria=? "); 
		$bindVariables = array(0=>$idSubCategoria);
		$resultado = $this->db->Execute($query, $bindVariables);
		if ($resultado && $resultado->RecordCount()>0) { 
            while($linha=$resultado->FetchRow()){
                return $linha[2];
            }
		}
		return 0;
	}

	function getCategoriaNome($idCategoria){
		$query = $this->db-> prepare("SELECT * FROM ".$this->prefixo."categorias WHERE idCategoria=? "); 
		$bindVariables = array(0=>$idCategoria);
		$resultado = $this->db->Execute($query, $bindVariables);
		if ($resultado && $resultado->RecordCount()>0) { 
            while($linha=$resultado->FetchRow()){
                return $linha[1];
            }
		}
		return 0;
	}

	/**Do not use in API*/
	function rotina($args){
		$resultado = $this->db->Execute("SELECT * FROM ".$this->prefixo."notify WHERE dia = '".date("Y-m-d")."' and tipo = '".$args."' ");
		return (($resultado && $resultado->RecordCount()>0)?1:0);
	}
	/**Do not use in API*/
	function executaRotina($args){
		return $this->db->Execute("INSERT INTO ".$this->prefixo."notify (tipo, dia) VALUES ( '".$args."', '".date("Y-m-d")."')");
	}


}




?>