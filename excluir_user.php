<?php
session_start();
include('conexao.php');
	  $id = $_GET['id'];
      $result_usuario = "DELETE FROM tbl_usuarios WHERE usuario_id=".$id;
	  $resultado_usuario = mysqli_query($conn, $result_usuario);
      header("Location: usuarios.php");
?>
