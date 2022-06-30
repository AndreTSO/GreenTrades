<?php        
	class handlerDistrict{
		
		function __construct(){
			$this->prefixo = "ptr_";
		}
		
		function getDistrict($db) {
			$districts = $db->prepare("SELECT id,name FROM ".$this->prefixo."district ORDER BY name ASC");
			$result = $db->execute($districts);
			return $result;
		}
		
		function getConcelho($db) {
			$conselhos = $db->prepare("SELECT id,name FROM ".$this->prefixo."concelho ORDER BY name ASC");
			$result = $db->execute($conselhos);
			return $result;
		}
		
		function getDistrictById($db, $idDistrict) {
			$district = $db-> prepare("SELECT name FROM ".$this->prefixo."district WHERE id=?");
			$bindVariables = array(0=>$idDistrict);
			$resultado = $db->execute($district, $bindVariables);
			if ($resultado && $resultado->RecordCount()>0){
				$linha=$resultado->FetchRow();
				return $linha['name'];
			}
		}
		
		function getConcelhoById($db, $idMunicipality) {
			$concelho = $db-> prepare("SELECT name FROM ".$this->prefixo."concelho WHERE id=?");
			$bindVariables = array(0=>$idMunicipality);
			$resultado = $db->execute($concelho, $bindVariables);
			if ($resultado && $resultado->RecordCount()>0){
				$linha=$resultado->FetchRow();
				return $linha['name'];
			}
		}

		function getConcelhoByDistrictId($db, $idDistrict) {
			$concelho = $db-> prepare("SELECT id,name FROM ".$this->prefixo."concelho WHERE district=? ORDER BY name ASC");
			$result = $db->execute($concelho, $idDistrict);
			return $result;
		}
	}
?>