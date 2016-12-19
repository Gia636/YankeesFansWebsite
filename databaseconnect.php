<?php
error_reporting(~E_DEPRECATED & ~E_NOTICE );
define('HOST', 'sql1.njit.edu');
define('USER', 'ge45');
define('PASS', '80owHFnK');
define('NAME', 'ge45');

try{
$conn = mysql_connect(HOST,USER,PASS);

if(!$conn){
throw new Exception("Connection failed.");
 }
}
catch(Exception $e){
echo $e->getMessage();
}

try{
$dbconn = mysql_select_db(NAME);
if(!$dbconn){
throw new Exception("Database connection failed.");
 }
}
catch(Exception $f){
echo $f->getMessage();
}
