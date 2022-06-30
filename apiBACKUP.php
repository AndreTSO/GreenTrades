<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');


    include 'includes/config.php';

    include 'classes/user.php';
    include 'DistrictAPI.php';
    include 'CartAPI.php';

    $ctrluser = new user($db);
    $ctrldistrict = new DistrictAPI($db);
    $ctrlcart = new CartAPI($db);

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
         *          ║
         *          ╠ 2xxx ╦ fornecedor
         *          ║      ║
         *          ║      ╚
         *          ║
         *          ╚ 3xxx ╦ transportador
         *                 ║
         *                 ╚
         */

        switch ($vetor['codigo']){
            case 1001:
                // $param = $vetor["param"];
                $result = $ctrluser->getTodosOsDados($vetor["id"]);
                $resposta = json_encode($result);
                break;

            case 1002:
                $result = $ctrluser->setTodosOsDados(
                    $vetor["id"],
                    "Malucos",
                    "do Bairro",
                    "M",
                    "malucos_dobairro@api.com",
                    "Avenida do Bairro",
                    "1234-567",
                    "2",
                    "2",
                    "912345678",
                    "2",
                    "malucosdobairro"
                );
                if ($result) {
                    $resposta = json_encode(array("responseID"=>"METHOD TEST ENDED", "response"=>"USER UPDATED SUCCESSFULLY"));
                } else {
                    $resposta = json_encode(array("faultID"=>"PUT METHOD TEST FAILED", "fault"=>"PROBABLY INSERTING INTO WRONG TABLE"));
                }
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

            case 1011:
                /**
                 * This returns a district's name when given an ID
                 */
                $param = $vetor['param'];
                $result = $ctrldistrict->getDistrictByIdAPI($db,  $param['distrito']);
                $array = array("name" => $result);
                $resposta = json_encode($array, true);
                break;

            case 1012:
                /**
                 * This code returns a json object of all districts
                 */
                $result = $ctrldistrict->getDistrictAPI($db);
                $resposta = json_encode($result, true);
                break;
            
            case 1021:
                /**
                 * This code returns a municipality's name when given an ID
                 */
                $param = $vetor['param'];
                $result = $ctrldistrict->getConcelhoByIdAPI($db,  $param['concelho']);
                $array = array("name" => $result);
                $resposta = json_encode($array, true);
                break;
            
            case 1022:
                /**
                 * This code returns a json object of all municipalities
                 */
                $result = $ctrldistrict->getConcelhoAPI($db);
                $resposta = json_encode($result, true);
                break;

            case 1023:
                /**
                 * This code returns a json object of all municipalities of a district
                 */
                $param = $vetor['param'];
                $result = $ctrldistrict->getConcelhoByDistrictIdAPI($db,  $param['distrito']);
                $resposta = json_encode($result, true);
                break;
            
            case 1031:
                /**
                 * This code returns a json object of all items inside the user's cart
                 */
                $result = $ctrlcart->getArtigosCestoAPI($db, $vetor['id']);
                $resposta = json_encode($result, true);
                break;
            
            case 1035:
                $param = $vetor['param'];
                $ctrlcart->postNovoArtigoAPI($db, $vetor['id'], $param['idArtigo'], $param['qtt']);
        }
    }else{
        http_response_code(401);
        $resposta = "BAD AUTHENTICATION";
    }
    echo $resposta;
    //      OBTER DISTRITO
    //    {"id":596,"apiKey":"R7UYOPL7UW8VQIU5EVUQTWMBH7WCIQF0LYCKUWEN6HVD3","codigo":1001,"param":{"distrito":1}}

?> 