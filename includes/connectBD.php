<?php
include('classes/adodb/adodb.inc.php');
$conn = array ("server"=>DB_SERVER,"database"=>DB_DB,"user"=>DB_USER,"password"=>DB_PASSW);
$db = ADONewConnection('mysqli');
$db->Connect($conn["server"], $conn["user"],$conn["password"],$conn["database"]);
$db->setCharset('utf8');
?>