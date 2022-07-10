<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');


    include 'includes/config.php';

    include 'classes/user.php';
    include 'classes/district.php';
    include 'classes/consumidor.php';
    include 'classes/fornecedor.php';
    include 'classes/produto.php';
    include 'classes/armazem.php';
    include 'classes/transportador.php';
    include 'classes/baseTransportador.php';
    include 'classes/comentarios.php'
    $ctrluser = new user($db);
    $ctrldistrict = new handlerDistrict($db);
    $ctrlconsumidor = new consumidor($db,$vetor['id']);
    $ctrlFornecedor = new fornecedor($db);
    $ctrlProduto = new produto($db);
    $ctrlArmazem = new armazem($db);
    $ctrlTransportador = new transportador($db);
    $ctrlbaseTransportador = new baseTransportador($db);
    $ctrlcomentarios = new comentarios($db);
    $vetor="";
	
	if (isset($_GET['q']))
		$vetor = json_decode($_GET['q'], true);

    //Descomentar para ver os valores
    //echo var_dump($vetor);

    $resposta="\n -> NO INPUT DATA"; 
	if (isset($_GET['q']))
    if ($ctrluser->isAPIKeyValid($vetor['id'], $vetor['apiKey'])){
        /**
         * CODE:    ╔ 1xxx ╦ user
         *          ║      ║ 
         *          ║      ║ > (1001 -> 1009) : functions related to user account
         *          ║      ║ 
         *          ║      ╠ 1001 ═ (GET) Get all data of a user
         *          ║      ╠ 1002 ═ (PUT) Edit the data of a user
         *          ║      ╠ 1003 ═ (POST) Create a new user
         *          ║      ║ 1004 ═ (POST) Create a new review
         *          ║      ║ 1005 ═ (GET) Get Star Value
         *          ║      ║ 1006 ═ (GET) GET Comment
         *          ║      ║ 
         *          ║      ║
         *          ║      ║ > (1011 -> 1019) : functions related to districts
         *          ║      ║ 
         *          ║      ╠ 1011 ═ (GET) Get districts by ID
         *          ║      ╠ 1012 ═ (GET) Get all districts
         *          ║      ║
         *          ║      ║ > (1021 -> 1029) : functions related to municipalities
         *          ║      ║ 
         *          ║      ╠ 1021 ═ (GET) Get municipalities by ID
         *          ║      ╠ 1022 ═ (GET) Get all municipalities
         *          ║      ╠ 1023 ═ (GET) Get all municipalities by district ID
         *          ║      ║ 
         *          ║      ║ > (1031 -> 1039) : functions related to user's cart
         *          ║      ║
         *          ║      ╠ 1031 ═ (GET) Get products in cart
         *          ║      ╠ 1035 ═ (POST) Add new item to the cart / update quantity if already exists
         *          ║      ║
         *          ╠ 2xxx ╦ fornecedor
         *          ║      ║> (2001-2009) : functions related to provider
         *          ║      ╠
         *          ║      ╠ 2001 ═ (GET) Get all data of provider by ID
         *          ║      ╠ 2002 ═ (POST) Create Provider
         *          ║      ╠ 2003 ═ (GET) Get Company of provider by ID
         *          ║      ╠ 2004 ═ (PUT) Update all data of provider by ID
         *          ║      ╠
         *          ║      ║> (2011-2019) : functions related to the Product
         *          ║      ╠ 
         *          ║      ╠ 2011 ═ (GET) Get all data of Product by ID
         *          ║      ╠ 2012 ═ (POST) Create Product
         *          ║      ╠ 2013 ═ (PUT) Update all data of Product by ID product
         *          ║      ║  
         *          ║      ╠> (2021-2029) : functions related to the wareHouse
         *          ║      ╠ 
         *          ║      ╠ 2021 ═ (GET) Get all data of wareHouse by ID
         *          ║      ╠ 2022 ═ (POST) Create wareHouse
         *          ║      ╠ 2023 ═ (PUT) Update all data of wareHouse by ID
         *          ║      ╠ 2024 ═ (GET) Get all wareHouses of provider by ID
         *          ║      ║ 2025 ═ (GET) Get bool if wareHouse exists or not of provider by ID
         *          ║      ║
         *          ╚ 3xxx ╦ transportador
         *          ║      ║> (3001-3009) : functions related to transportador
         *          ║      ╚
         *          ║      ║ 3021 ═ (GET) Get all data of transportador by Provider ID
         *          ║      ║ 3002 ═ (POST) Create transportador
         *          ║      ╠ 3003 ═ (GET) Get Company of provider by ID
         *          ║      ╠ 3004 ═ (PUT) Update all data of provider by ID
         *          ║      ║ 3005 ═ (PUT) Update all data of provider by ID
         *          ║      ║ 3006 ═ (PUT) Update all data of provider by ID
         *          ║      ║ 3007 ═ (PUT) Update all data of provider by ID
         *          ║      ║ 3008 ═ (PUT) Update all data of provider by ID
         *          ║      ║
         *          ║      ║
         *          ║      ║
         *          ║      ║
         *          ║      ║
         */

        switch ($vetor['codigo']){
            case 1001:
                // $param = $vetor["param"];
                $result = $ctrluser->getTodosOsDados($vetor["id"]);
                $resposta = json_encode($result);
                break;

            case 1002:
                $param= $vetor['param'];
                $nif=$param['nif'];
                $nome=$param['nome'];
                $sobreNome=$param['sobreNome'];
                $genero=$param['genero'];
                $email=$param['email'];
                $morada=$param['morada'];
                $codigoPostal=$param['codigoPostal'];
                $distrito=$param['distrito'];
                $concelho=$param['concelho'];
                $contacto=$param['contacto'];
                $anuncios=$param['anuncios'];
                $result = $ctrluser->setTodosOsDados($nif, $nome, $sobreNome, $genero, $email, $morada, $codigoPostal, $distrito, $concelho,  $contacto, $anuncios, $senha="");
                $resposta = json_encode($result,true);
                break;

            case 1003:
                $result = $ctrluser->registar(
                    $_POST['nif'],
                    $_POST['nome'],
                    $_POST['sobreNome'],
                    $_POST['genero'],
                    $_POST['email'],
                    $_POST['password'],
                    $_POST['morada'],
                    $_POST['codigoPostal'],
                    $_POST['distrito'],
                    $_POST['concelho'],
                    $_POST['dataNascimento'],
                    $_POST['tipoDeConta'],
                    $_POST['contato'],
                    $_POST['anuncios'],
                );
                if ($result) {
                    http_response_code(201);
                    $resposta = json_encode(array("responseID"=>"METHOD TEST ENDED", "response"=>"USER CREATED SUCCESSFULLY"));
                } else {
                    $resposta = json_encode(array("faultID"=>"POST METHOD TEST FAILED", "fault"=>"USER WITH SAME ID ALREADY EXISTS"));
                }
                break;
            
            case 1004:
                $param = $vetor["param"];
                $nif=$param['nif'];
                $idProduto=$param['idProduto'];
                $estrelas=$param['estrelas'];
                $comentario=$param['comentario'];
                $result = $ctrlcomentarios->criaComentario($nif, $idProduto, $estrelas, $comentario);
                $resposta = json_encode($result);
                break;

            case 1005:
                $param = $vetor["param"];
                $idProduto=$param['idProduto'];
                $result = $ctrlcomentarios->getComentarios($idProduto);
                $resposta = json_encode($result);
                break;
            
            case 1006:
                $param = $vetor["param"];
                $idProduto=$param['idProduto'];
                $result = $ctrlcomentarios->getStarsValue($idProduto);
                $resposta = json_encode($result);
                break;

            case 1011:
                /**
                 * This returns a district's name when given an ID
                 */
                $param = $vetor['param'];
                $result = $ctrldistrict->getDistrictById($db,  $param['distrito']);
                $array = array("name" => $result);
                $resposta = json_encode($array, true);
                break;

            case 1012:
                /**
                 * This code returns a json object of all districts
                 */
                $result = $ctrldistrict->getDistrict($db);
                
                $resultado2 = array();
                foreach ($result as $key) {
                    array_push($resultado2, array("id"=>$key["id"], "name"=>$key["name"]));
                }
                $resposta = json_encode($resultado2, true);

                break;
            
            case 1021:
                /**
                 * This code returns a municipality's name when given an ID
                 */
                $param = $vetor['param'];
                $result = $ctrldistrict->getConcelhoById($db,  $param['concelho']);
                $array = array("name" => $result);
                $resposta = json_encode($array, true);
                break;
            
            case 1022:
                /**
                 * This code returns a json object of all municipalities
                 */
                $result = $ctrldistrict->getConcelho($db);
                $resultado
                    array_push($resultado2, array("id"=>$key["id"],"name"=>$key["name"]));
                }
                $resposta = json_encode($resultado2, true);

                break;

            case 1023:
                /**
                 * This code returns a json object of all municipalities of a district
                 */
                $param = $vetor['param'];
                $result = $ctrldistrict->getConcelhoByDistrictId($db,  $param['distrito']);
                $resposta = json_encode($result, true);
                break;
            
            case 1031:
                /**
                 * This code returns a json object of all items inside the user's cart
                 */
                $result = $ctrlconsumidor->getArtigosCesto();
                $resposta = json_encode($result, true);
                break;

            case 1032:
                /**
                 * This code returns a json object of all items inside the user's cart
                 */
                $result = $ctrlconsumidor->getNumberArticlesOfCesto();
                $resposta = json_encode($result, true);
                break;

            case 1033:
                /**
                 * This code returns a json object of all items inside the user's cart
                 */
                $param = $vetor['param'];
                $idP=$param['idP'];
                $result = $ctrlconsumidor->productInCesto();
                $resposta = json_encode($result, true);
                break;
            
            case 1034:
                /**
                 * This code returns a json object of all items inside the user's cart
                 */
                $param = $vetor['param'];
                $idArtigo=$param['idArtigo'];
                $quantidade=$param['quantidade'];
                $result = $ctrlconsumidor->addArtigosCesto($idArtigo, $quantidade);
                $resposta = json_encode($result, true);
                break;
            
            case 1035:
                $param = $vetor['param'];
                $idArtigo=$param['idArtigo'];
                $quantidade=$param['quantidade'];
                $result= $ctrlcart->remArtigosCesto($idArtigo, $quantidade);
                $resposta = json_encode($result, true);
                break;
            
            case 1036:
                $param = $vetor['param'];
                $idArtigo=$param['idArtigo'];
                $result=$ctrlcart->remAllArtigosCesto($idArtigo);
                $resposta = json_encode($result, true);
                break;
            
            case 1037:
                $param = $vetor['param'];
                $idP=$param['idP'];
                $newQuant=$param['newQuant'];
                $result=$ctrlcart->updQuantArtgCesto($idP, $newQuant);
                $resposta = json_encode($result, true);
                break;

            case 1038:
                $param = $vetor['param'];
                $result=$ctrlcart->wipeCesto();
                $resposta = json_encode($result, true);
                break;

            case 1039:
                $param = $vetor['param'];
                $result=$ctrlcart->isCestoOcupied();
                $resposta = json_encode($result, true);
                break;


            case 2001:
                $param= $vetor['param'];
                $id=$param['id'];
                $result=$ctrlFornecedor->getTodosOsDados($id);
                $resposta = json_encode($result,true);
                break;
            case 2002:
                $param= $vetor['param'];
                $idFornecedor=$param['idFornecedor'];
                $descricao=$param['descricao'];
                $nomeEmpresa=$param['nomeEmpresa'];
                $morada=$param['morada'];
                $codigoPostal=$param['codigoPostal'];
                $distrito=$param['distrito'];
                $concelho=$param['concelho'];
                $contacto=$param['contacto'];
                $categoriaProdutos=$param['categoriaProdutos'];
                $webSite=$param['webSite'];
                $periodoXDiasCancelar=$param['periodoXDiasCancelar'];
                $poluicaoGerada=$param['poluicaoGerada'];
                $consumoRecursos=$param['consumoRecursos'];
                $estado=$param['estado'];
                $result=$ctrlFornecedor->createFornecedor($idFornecedor,$descricao,$nomeEmpresa,$morada,$codigoPostal,$distrito,$concelho,$contacto,$categoriaProdutos,$webSite,$periodoXDiasCancelar,$poluicaoGerada,$consumoRecursos,$estado);
                $resposta = json_encode($result,true);
                break;
            
            case 2003:
                $param= $vetor['param'];
                $id=$param['id'];
                $result=$ctrlFornecedor->existsEmpresa($id);
                $resposta = json_encode($result,true);
                break;
            
            case 2004:
                $param= $vetor['param'];
                $idFornecedor=$param['idFornecedor'];
                $descricao=$param['descricao'];
                $nomeEmpresa=$param['nomeEmpresa'];
                $morada=$param['morada'];
                $codigoPostal=$param['codigoPostal'];
                $distrito=$param['distrito'];
                $concelho=$param['concelho'];
                $contacto=$param['contacto'];
                $categoriaProdutos=$param['categoriaProdutos'];
                $webSite=$param['webSite'];
                $periodoXDiasCancelar=$param['periodoXDiasCancelar'];
                $poluicaoGerada=$param['poluicaoGerada'];
                $consumoRecursos=$param['consumoRecursos'];
                $estado=$param['estado'];
                $result=$ctrlFornecedor->setTodosOsDados($idFornecedor,$descricao,$nomeEmpresa,$morada,$codigoPostal,$distrito,$concelho,$contacto,$categoriaProdutos,$webSite,$periodoXDiasCancelar,$poluicaoGerada,$consumoRecursos,$estado);
                $resposta = json_encode($result,true);
                break;

            case 2011:
                $param= $vetor['param'];
                $id=$param['id'];
                $result=$ctrlProduto->getTodosOsDados($id);
                $resposta = json_encode($result,true);
                break;

            case 2012:
                $param = $vetor['param'];
                $idFornecedor=$param['idFornecedor'];
                $nome=$param['nome'];
                $descricao=$param['descricao'];
                $tipo=$param['tipo'];
                $tags=$param['tags'];
                $precoSemIva=$param['precoSemIva'];
                $recursosConsumidos=$param['recursosConsumidos'];
                $custoManutencao=$param['custoManutencao'];
                $estado=$param['estado'];
                $tipoIVA=$param['tipoIVA'];
                $modoDeVenda=$param['modoDeVenda'];
                $pesoPorVenda=$param['pesoPorVenda'];
                $arquivado=$param['arquivado'];
                $notasInternasAoFornecedor=$param['notasInternasAoFornecedor'];
                $dataCriacaoTimeStamp=$param['dataCriacaoTimeStamp'];
                $result=$ctrlProduto->createProduto($idFornecedor, $nome, $descricao, $tipo, $tags, $precoSemIva, $recursosConsumidos, $custoManutencao, $estado, $tipoIVA, $modoDeVenda, $pesoPorVenda, $arquivado, $notasInternasAoFornecedor, $dataCriacaoTimeStamp);
                $resposta = json_encode($result,true);
                break;
                
            case 2013:
                $param= $vetor['param'];
                $idProduto=$param['idProduto'];
                $idFornecedor=$param['idFornecedor'];
                $nome=$param['nome'];
                $descricao=$param['descricao'];
                $tipo=$param['tipo'];
                $tags=$param['tags'];
                $precoSemIva=$param['precoSemIva'];
                $recursosConsumidos=$param['recursosConsumidos'];
                $custoManutencao=$param['custoManutencao'];
                $estado=$param['estado'];
                $tipoIVA=$param['tipoIVA'];
                $modoDeVenda=$param['modoDeVenda'];
                $pesoPorVenda=$param['pesoPorVenda'];
                $arquivado=$param['arquivado'];
                $notasInternasAoFornecedor=$param['notasInternasAoFornecedor'];
                $dataCriacaoTimeStamp=$param['dataCriacaoTimeStamp'];
                $result=$ctrlProduto->setTodosOsDados($idProduto, $idFornecedor, $nome, $descricao, $tipo, $tags, $precoSemIva, $recursosConsumidos, $custoManutencao, $estado, $tipoIVA, $modoDeVenda, $pesoPorVenda, $arquivado, $notasInternasAoFornecedor, $dataCriacaoTimeStamp);
                $resposta = json_encode($result,true);
                break;

            case 2021:
                $param= $vetor['param'];
                $id=$param['id'];
                $result=$ctrlArmazem->getTodosOsDados($id);
                $resposta = json_encode($result,true);
                break;

            case 2022:
                $param= $vetor['param'];
                $idFornecedor=$param['idFornecedor'];
                $nome=$param['nome'];
                $morada=$param['morada'];
                $nPorta=$param['nPorta'];
                $andar=$param['andar'];
                $distrito=$param['distrito'];
                $concelho=$param['concelho'];
                $codigoPostal=$param['codigoPostal'];
                $custoManutencao=$param['custoManutencao'];
                $estado=$param['estado'];
                $refrigeracao=$param['refrigeracao'];
                $poluicaoGerada=$param['poluicaoGerada'];
                $result=$ctrlArmazem->createArmazem($idFornecedor, $nome, $morada, $nPorta, $andar, $distrito, $concelho, $codigoPostal, $custoManutencao, $estado, $refrigeracao, $poluicaoGerada);
                $resposta = json_encode($result,true);
                break;
            
            case 2023:
                $param= $vetor['param'];
                $idArmazemFornecedor=$param['idArmazemFornecedor'];
                $idFornecedor=$param['idFornecedor'];
                $nome=$param['nome'];
                $morada=$param['morada'];
                $nPorta=$param['nPorta'];
                $andar=$param['andar'];
                $distrito=$param['distrito'];
                $concelho=$param['concelho'];
                $codigoPostal=$param['codigoPostal'];
                $custoManutencao=$param['custoManutencao'];
                $estado=$param['estado'];
                $refrigeracao=$param['refrigeracao'];
                $poluicaoGerada=$param['poluicaoGerada'];
                $result=$ctrlArmazem->setTodosOsDados($idArmazemFornecedor, $idFornecedor, $nome, $morada, $nPorta, $andar, $distrito, $concelho, $codigoPostal, $custoManutencao, $estado, $refrigeracao, $poluicaoGerada);
                $resposta = json_encode($result,true);
                break;
            
            case 2024:
                $param= $vetor['param'];
                $id=$param['id'];
                $result=$ctrlArmazem->getTodosOsArmazens($id);
                $resposta = json_encode($result,true);
                break;
            
            case 2025:
                $param= $vetor['param'];
                $id=$param['id'];
                $result=$ctrlArmazem->existeArmazem($id);
                $resposta = json_encode($result,true);
                break;

            case 3001:
                $param= $vetor['param'];
                $id=$param['id'];
                $result = $ctrlTransportador->getTodosOsDados($vetor["id"]);
                $resposta = json_encode($result);
                break;

            case 3002:
                $param= $vetor['param'];
                $idUserNif=$param['idUserNif'];
                $nomeEmpresa=$param['nomeEmpresa'];
                $descricao=$param['descricao'];
                $sedeMorada=$param['sedeMorada'];
                $sedeCodigoPostal=$param['sedeCodigoPostal'];
                $distrito=$param['distrito'];
                $concelho=$param['concelho'];
                $contacto=$param['contacto'];
                $garantiaEntregaXHoras=$param['garantiaEntregaXHoras'];
                $webSite=$param['webSite'];                

                $result=$ctrlArmazem->createTransportador($idUserNif,$nomeEmpresa,$sedeMorada,$sedeCodigoPostal,$distrito,$concelho,$contacto,$garantiaEntregaXHoras,$webSite,$estado=0,$descricao);
                $resposta = json_encode($result,true);
                break;

            case 3003:
                $param= $vetor['param'];
                $idUserNif=$param['idUserNif'];
                $nomeEmpresa=$param['nomeEmpresa'];
                $descricao=$param['descricao'];
                $sedeMorada=$param['sedeMorada'];
                $sedeCodigoPostal=$param['sedeCodigoPostal'];
                $distrito=$param['distrito'];
                $concelho=$param['concelho'];
                $contacto=$param['contacto'];
                $garantiaEntregaXHoras=$param['garantiaEntregaXHoras'];
                $webSite=$param['webSite'];
                $estado=$param['estado'];                

                $result=$ctrlArmazem->setTodosOsDados($idUserNif,$nomeEmpresa,$descricao,$sedeMorada,$sedeCodigoPostal,$distrito,$concelho,$contacto,$garantiaEntregaXHoras,$website,$estado);
                $resposta = json_encode($result,true);
                break;

                case 3004:
                    $param= $vetor['param'];
                    $idArmazemFornecedor=$param['idArmazemFornecedor'];               
    
                    $result=$ctrlArmazem->contarProdutosArmazem($idArmazemFornecedor);
                    $resposta = json_encode($result,true);
                    break;

                case 3005:
                    $param= $vetor['param'];
                    $idProduto=$param['idProduto']; 
                    $idArmazemFornecedor=$param['idArmazemFornecedor'];               
    
                    $result=$ctrlArmazem->removerProdutoArmazem($idProduto, $idArmazemFornecedor);
                    $resposta = json_encode($result,true);
                    break;

                case 3006:
                    $param= $vetor['param'];
                    $idProduto=$param['idProduto'];            
    
                    $result=$ctrlArmazem->getStockandLoc($idProduto);
                    $resposta = json_encode($result,true);
                    break;
                
                case 3007:
                    $param= $vetor['param'];
                    $idArmazemFornecedor=$param['idArmazemFornecedor'];            
    
                    $result=$ctrlArmazem->eliminarArmazem($idArmazemFornecedor);
                    $resposta = json_encode($result,true);
                    break;

                case 3008:
                    $param= $vetor['param'];
                    $idTransportador=$param['idTransportador'];            
                    $nome=$param['nome'];
                    $morada=$param['morada']; 
                    $distrito=$param['distrito']; 
                    $concelho=$param['concelho']; 
                    $codigoPostal=$param['codigoPostal']; 
                    $custoManutencao=$param['custoManutencao'];
                    $poluicaoGerada=$param['poluicaoGerada'];
                    $estado=$param['estado'];

                    $result=$ctrlbaseTransportador->createBaseTransportador($idTransportador,$nome,$morada,$distrito,$concelho,$codigoPostal,$custoManutencao,$poluicaoGerada,$estado);
                    $resposta = json_encode($result,true);
                    break;

                
                
                    

                    


        } 

    }else{
        http_response_code(401);
        $resposta = "BAD AUTHENTICATION";
    }
    echo $resposta;
    //      OBTER DISTRITO
    //    {"id":596,"apiKey":"R7UYOPL7UW8VQIU5EVUQTWMBH7WCIQF0LYCKUWEN6HVD3","codigo":1001,"param":{"district":1}}
    //      OBTER Fornecedor
    //    {"id":596,"apiKey":"R7UYOPL7UW8VQIU5EVUQTWMBH7WCIQF0LYCKUWEN6HVD3","codigo":2001,"param":{"id":1}}

?> 