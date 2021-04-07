<?php
session_start();

$_SESSION['UsuarioNome'] = '';
$_SESSION['UsuarioId']   = '';
$_SESSION['Usuario']     = '';
$_SESSION['Empresa']     = '';
$_SESSION['Empresa_nome'] = '';

header("Location: login.php");
exit;
?>
