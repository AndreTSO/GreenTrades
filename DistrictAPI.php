<?php
    class DistrictAPI {
        
        function __construct(){
            $this->prefixo = "ptr_";
        }

        function getDistrictAPI($db) {
            $districts = $db->prepare("SELECT id,name FROM ".$this->prefixo."district ORDER BY name ASC");
            $result = $db->execute($districts);
            $newArr = array();
            foreach ($result as $key) {
                array_push($newArr, array("id"=>$key["id"], "name"=>$key["name"]));
            }
            return $newArr;
        }

        function getConcelhoAPI($db) {
            $conselhos = $db->prepare("SELECT id,name FROM ".$this->prefixo."concelho ORDER BY name ASC");
            $result = $db->execute($conselhos);
            $newArr = array();
            foreach ($result as $key) {
                array_push($newArr, array("id"=>$key["id"],"name"=>$key["name"]));
            }
            return $newArr;
        }

        function getDistrictByIdAPI($db, $idDistrict) {
            $district = $db-> prepare("SELECT name FROM ".$this->prefixo."district WHERE id=?");
            $bindVariables = array(0=>$idDistrict);
            $resultado = $db->execute($district, $bindVariables);
            if ($resultado && $resultado->RecordCount()>0){
                $linha=$resultado->FetchRow();
                return $linha['name'];
            }
        }

        function getConcelhoByIdAPI($db, $idMunicipality) {
            $concelho = $db-> prepare("SELECT name FROM ".$this->prefixo."concelho WHERE id=?");
            $bindVariables = array(0=>$idMunicipality);
            $resultado = $db->execute($concelho, $bindVariables);
            if ($resultado && $resultado->RecordCount()>0){
                $linha=$resultado->FetchRow();
                return $linha['name'];
            }
        }

        function getConcelhoByDistrictIdAPI($db, $idDistrict) {
            $concelho = $db-> prepare("SELECT id,name FROM ".$this->prefixo."concelho WHERE district=? ORDER BY name ASC");
            $result = $db->execute($concelho, $idDistrict);
            $newArr = array();
            foreach ($result as $key) {
                array_push($newArr, array("id"=>$key["id"],"name"=>$key["name"]));
            }
            return $newArr;
        }
    }
?>