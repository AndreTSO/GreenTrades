
<?php
require_once '/oauth/vendor/autoload.php';

$clientID ="687068431929-2bg3i2cr0tiotdgmooemp77pi9fvcrpn.apps.googleusercontent.com";
$clientSecret="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";
$redirect = "https://ptr.emanuenunes.pt/registWithOauth.php";

//creating client Request to google

$client = new Google_Client();
$client-> setClientId($clientID);
$client-> setClientSecret($clientSecret);
$client-> serRedirectUrl($redirect);
$client-> addScope('profile');
$client-> addScope('email');




if (isset($_GET['code'])){

    $token= $client-> fetchAccessToken($_GET['code']);
    $client->setAccessToken($token);


    //GETing use datta com pronucia indiana
    $gauth = new Google_Service_Oauth($client);
    $google_info = $gauth->userinfo->get();
    $email = $google_info->email;
    $name =  $google_info->name;

    echo "Welcomme ".$name." email: ".$email;

}else{
    echo "<a href='".$client->createAuthUrl()."'><button>Login with Google</button></a>";
}



?>
