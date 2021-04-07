<?php
session_start();
include_once('valida.php');

$host="localhost"; // Host name 
$username="fastcon1_master"; // Mysql username 
$password="$}4aSu@&$0}x"; // Mysql password 
$db_name="fastcon1_".$_SESSION['id_entrada']; // Database name 

// Connect to server and select databse.
$conn = mysqli_connect("$host", "$username", "$password", "$db_name"); 
mysqli_set_charset($conn, "utf8");

?>