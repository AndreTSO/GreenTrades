<?php
//error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', '1');
 
date_default_timezone_set('Europe/London');

define('SENHA',substr(md5('!"#$&/AsdfSSDF#$D##Ssdf'),3,8));

define('PARCIAL_ROOT','public_html/');
define('DOCUMENT_BASE','mysql10.000webhost.com'.PARCIAL_ROOT);
define('DOCUMENT_ROOT',$_SERVER{'DOCUMENT_ROOT'}.'/'.PARCIAL_ROOT);

define('DB_SERVER','fvaoksstroll.mysql.db');
define('DB_DB','fvaoksstroll');
define('DB_USER','fvaoksstroll');
define('DB_PASSW','Emanueltroll1');

include 'connectBD.php';
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