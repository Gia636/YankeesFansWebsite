<?php
error_reporting(~E_DEPRECATED & ~E_NOTICE );
//defining the connection
define('HOST', 'sql1.njit.edu');
define('USER', 'ge45');
define('PASS', '80owHFnK');
define('NAME', 'ge45');
//using exceptions to handle errors connecting to the database
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
