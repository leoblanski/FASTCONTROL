<?php
session_start();
include('conexao.php');

$user_create = $_SESSION['UsuarioId'];
$descricao = $_POST['descricao'];
$ativo = $_POST['ativo'];
date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d');
$hora = date('H:i');


	$sql = "INSERT INTO produtos_marca (descricao, ativo, user_create, dt_create, hr_create) VALUES ('$descricao', '$ativo', '$user_create', '$data', '$hora')";
	$result = mysqli_query($conn, $sql);
	if ($result) {

		echo("<script>alert('Marca Cadastrada com Sucesso.')</script>");
		echo("<script>window.location = 'cadastro_marca.php';</script>");
	} else {
		echo "Não foi possível cadastrar a marca, tente novamente ! \n Caso o problema persista entre em contato com o suporte.";
		echo "<br>".mysqli_error($conn);
}
mysqli_close($conn);
?>
