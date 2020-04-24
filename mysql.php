<?php
$db_servername = NULL;     //localhost
$db_username = NULL;
$db_password = NULL;
$db_database = NULL;
$db_port = NULL;
function connectToDB($db_servername,$db_username,$db_password,$db_database,$db_port=3306){
  try{
    $conn = new PDO("mysql:host={$db_servername};port={$db_port};dbname={$db_database}",
                    $db_username,
                    $db_password,
                    array(
                      \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'  //important
                    )
                   );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }catch(PDOException $e)
  {
    echo "database connection failed:  ({$db_servername}:{$db_port})\n {$e->getMessage()}";
    exit;
  }
  return $conn;
}
