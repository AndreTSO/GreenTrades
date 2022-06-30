<?php
    class FornecedorAPI {
        
        function __construct(){
            $this->prefixo = "ptr_";
        }

        function getFornecedorAPI($db) {
            $fornecedores = $db->prepare("SELECT idFornecedor,nomeEmpresa FROM ".$this->prefixo."fornecedor ORDER BY nomeEmpresa ASC");
            $result = $db->execute($fornecedores);
            $newArr = array();
            foreach ($result as $key) {
                array_push($newArr, array("idFornecedor"=>$key["idFornecedor"], "nomeEmpresa"=>$key["nomeEmpresa"]));
            }
            return $newArr;
        }

        function getCategoriaProdutos($db) {

        }

        function getWebSiteByIdAPI($db, $idFornecedor) {
            $fornecedor= $db-> prepare("SELECT webSite FROM ".$this->prefixo."fornecedor WHERE id=?");
            $bindVariables = array(0=>$idFornecedor);
            $resultado = $db->execute($fornecedor, $bindVariables);
            if ($resultado && $resultado->RecordCount()>0){
                $linha=$resultado->FetchRow();
                return $linha['webSite'];
            }
        }

        function getTodosOsDados($db) {
            
        }

        function getPoluicaoGerada ($db) {

        }
    }
?>