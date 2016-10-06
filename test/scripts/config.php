<?php
session_start();
$Host_db="localhost";
$User_db="root";
$Pass_db="Cosc3380";
$Name_db="zoo";

try
{
    $DB_con=new PDO("mysql:host={$Host_db};dbname={$Name_db}",$User_db,$Pass_db);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $ex)
{
    echo$ex->getMessage();
}

include_once 'class.zoouser.php';
$user=new USERZOO($DB_con);
?>