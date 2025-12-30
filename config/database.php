<?php 
$servername ="localhost";
$username ="root";
$password ="";
try
{
//concetion string 
$con=new PDO("mysql:host =$username",$password)
}catch(PDOException $e){
echo "error".$e-> getMessage();

}




?>