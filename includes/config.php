<?php
//error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', '1');
 
date_default_timezone_set('Europe/London');

define('SENHA',substr(md5('!"#$&/AsdfSSDF#$D##Ssdf'),3,8));

define('PARCIAL_ROOT','public_html/');
define('DOCUMENT_BASE','mysql10.000webhost.com'.PARCIAL_ROOT);
define('DOCUMENT_ROOT',$_SERVER{'DOCUMENT_ROOT'}.'/'.PARCIAL_ROOT);



define('DB_SERVER','10.154.0.14:3306');
define('DB_DB','greenTrades');
define('DB_USER','leoAll');
define('DB_PASSW','leoAll');
require_once('connectBD.php');
/*
define('DB_SERVER','10.154.0.15:3306');
define('DB_DB','greenTrades');
define('DB_USER','leoAll');
define('DB_PASSW','leoAll');



//require_once('classes/adodb/adodb-errorhandler.inc.php');



require_once('classes/adodb/adodb.inc.php');
require_once('classes/adodb/adodb-loadbalancer.inc.php');


$db = new ADOdbLoadBalancer;
$db0 = new ADOdbLoadBalancerConnection('mysqli','write',1,false,'10.154.0.14:3306','leoAll','leoAll','greenTrades');
$db->addConnection($db0);
$db1 = new ADOdbLoadBalancerConnection('mysqli','write',2,false,'10.154.0.15:3306','leoAll','leoAll','greenTrades');
$db->addConnection($db1);
$db->setCharset('utf8');
*/


session_start();

foreach ($_POST as $key => $input_arr) {
     //  $_POST[$key] = addslashes(trim($input_arr));
    //   $_POST[$key] = stripslashes($input_arr);
    //   $_POST[$key] = strip_tags(trim($input_arr));
       $_POST[$key] = htmlspecialchars($input_arr);
}


foreach ($_GET as $key => $input_arr) {
    //   $_POST[$key] = addslashes(trim($input_arr));
    //   $_POST[$key] = stripslashes($input_arr);
    //   $_POST[$key] = strip_tags(trim($input_arr));
       $_POST[$key] = htmlspecialchars($input_arr);
}
unset ($key,$input_arr);



?>