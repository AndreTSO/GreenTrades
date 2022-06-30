<?php 
    /** AUTO FILE DO NOT EDIT **/
    require_once('includes/config.php');
    require_once("classes/lib.php");
    require_once("classes/user.php");
    require_once("classes/produto.php");
    require_once("classes/mail.php");
    $ctrllib=new lib($db);
    $ctrluser=new user($db);
    $ctrlproduto = new produto($db);
    $ctrlmail = new enviadorDeEmail();

    error_reporting(E_ALL ^ E_WARNING); 


    $hoje = date("Y-m-d");
    //Using PHP's date and strtotime functions to get
    //the date 30 days from now.
    $thirtyDays = date("Y-m-d", strtotime("+30 days"));



    $rodouHoje = $ctrllib-> rotina("VALIDADE");
    if(!$rodouHoje){
        /** LET MAGIC HAPPENS */
        $ctrllib-> executaRotina("VALIDADE");
        $fornecedores = $ctrluser -> getAllFornecedores(); // ARRAY de todos os Fornecedores


        foreach($fornecedores as $fornecedor){ // Vamos trabalhar cada um dos fornecedores individualmente
            
            $produtosDoFornecedor = $ctrlproduto->getTodosOsProdutos($fornecedor['nif']);
            $listaProdutosExpirar = array();
            $contadorAmarelo = 0;
            $contadorVermelho = 0;
            foreach($produtosDoFornecedor as $prod){

                if (isset($prod['validade'])){
                    $date1 = new DateTime($prod['validade']);
                    $date2 = new DateTime($hoje);
                    $interval = $date1->diff($date2);

                    if ($prod['validade']>$thirtyDays){
                        $good = true;
                    }elseif($prod['validade']<=$thirtyDays and $prod['validade']>=$hoje){
                        $good = false;
                        $img = "amarelo.png";
                        $txt = "Este produto vai expirar em ".$interval->days." dias";
                        $contadorAmarelo++;
                    }else{
                        $good = false;
                        $img = "vermelho.png";
                        $txt = "Este produto expirou à ".$interval->days." dias";
                        $contadorVermelho++;
                    }
                    if (!$good){//Se não está bom entao adiciona para o array
                        $produtoListar = array();
                        $produtoListar['imgProduto'] = "Art".$prod['idProduto']."ID0.png";
                        $produtoListar['nome'] = $prod['nome'];
                        $produtoListar['sinal'] = $img;
                        $produtoListar['texto'] = $txt;
                        array_push($listaProdutosExpirar, $produtoListar);
                    }             
                }
            
            }//Terminado todos os produtos do fornecedor
            if (count($listaProdutosExpirar) > 0){
                $ctrlmail->alertValidades($fornecedor['nome'], $fornecedor['email'], $listaProdutosExpirar);
                $ctrluser->setNotify($fornecedor['nif'], "Produtos a Expirar", "Tem ".$contadorAmarelo." Produto".($contadorAmarelo!=1?"s":"")." a expirar em menos de 30 dias e tem ".$contadorVermelho." que já expir".($contadorVermelho==1?"ou":"aram")."!");
            }
        }
    }

?>