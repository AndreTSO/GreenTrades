<?php
    class CartAPI {
        
        function __construct(){
            $this->prefixo = "ptr_";
        }

        function getArtigosCestoAPI($db, $idUser){
            $artigos = $db->prepare("SELECT * FROM ".$this->prefixo."cesto WHERE idUser = ?");
            $result = $db->execute($artigos, $idUser);
            $newArr = array();
            foreach ($result as $key) {
                array_push($newArr, array("idArtigo"=>$key["idArtigo"],"quantidade"=>$key["quantidade"]));
            }
            return $newArr;
        }

        // function getTotalPriceArtigosCesto($db){}
            
        function postNovoArtigoAPI($db, $idUser, $idItem, $qtt){
            $exists = $db->prepare(
                "SELECT * FROM ".$this->prefixo."cesto WHERE idArtigo = ".$idItem.";
            ");
            $result = $db->execute($exists);
            
            if ($result->RecordCount() > 0) {
                $sql = "UPDATE ".$this->prefixo."cesto SET quantidade = quantidade + ".$qtt." WHERE (idUser = ".$idUser." AND idArtigo = ".$idItem.");";
                echo $sql."\n";
            } else {
                $sql = "INSERT INTO ".$this->prefixo."cesto (idUser, idArtigo, quantidade) VALUES (".$idUser.", ".$idItem.", ".$qtt.")";
                echo $sql."\n";
            }
            $artigos = $db-> prepare($sql);
            $db->execute($artigos);
        }
    }
?>