<?php
session_start();
include_once('conexao.php');
if (!$_SESSION['UsuarioNome']){
header("Location: login.php");
exit;
}


?>
