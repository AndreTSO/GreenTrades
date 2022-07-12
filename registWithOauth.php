
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require_once 'vendor/autoload.php';
require_once 'vendor/google/auth/autoload.php';
//require_once 'vendor/Google/Service/Oauth2.php';
//require_once 'vendor/google/google-api-php-client/autoload.php';
$clientID ="687068431929-hgirk367sufv87bt0uomcru57de7bdao.apps.googleusercontent.com";
$clientSecret="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";
$redirect = "http://greentrades.me/registWithOauth.php";

//creating client Request to google


$client = new Google_Client();

$client-> setClientId($clientID);
$client-> setClientSecret($clientSecret);
$client-> setRedirectUri($redirect);
$client-> addScope('profile');
$client-> addScope('email');




if (isset($_GET['code'])){
    //echo "LOguei mas agora faço o que ?<br>";
    //echo "<br>Token-> ".$_GET['code']."<br>";

    //$client->authenticate($_GET['code']);
   // $token = $client->getAccessToken();
    //var_dump($token);

   // $token= $client-> fetchAccessToken($_GET['code']);
    $token= $client-> fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);
  
    
    //GETing use datta com pronucia indiana
    $gauth = new Google_Service_Oauth2($client);
    $google_info = $gauth->userinfo->get();
    //echo "zona3";
    $email = $google_info->email;
    $name =  $google_info->name;
    //echo "zona4";

    echo "Welcomme ".$name." email: ".$email;

}else{
    echo "<a href='".$client->createAuthUrl()."'><button>Login with Google</button></a>";
}



?>
