<?php
session_start();
include('conexao.php');

$user_create = $_SESSION['UsuarioId'];
$empresa = $_SESSION['Empresa'];
$numero_mesa = $_POST['mesa'];
$descricao = $_POST['descricao'];
$ativo = $_POST['ativo'];
date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d');
$hora = date('H:i');

$result_mesa = "SELECT numero_mesa FROM mesas WHERE numero_mesa='$numero_mesa'";
$resultado_mesa = mysqli_query($conn, $result_mesa);
if ($resultado_mesa->num_rows != 0){
	echo("<script>alert('Já existe uma mesa cadastrada com a numeração $numero_mesa, verifique se a mesma não encontra-se desativada, acessando o menu Faturamento > Cadastro de Mesas > Exibir Registros.')</script>");
	echo "<script>window.location = 'cadastro_mesa.php';</script>";
}
else {
	$sql = "INSERT INTO mesas (numero_mesa, empresa, descricao, ativo, user_create, dt_create, hr_create) VALUES ('$numero_mesa', '$empresa', '$descricao', '$ativo', '$user_create', '$data', '$hora')";
	$result = mysqli_query($conn, $sql);
	//echo $sql;
	if ($result) {

		echo("<script>alert('Mesa Cadastrada com Sucesso.')</script>");
		echo("<script>window.location = 'cadastro_mesa.php';</script>");
	} else {
		echo "Não foi possível cadastrar a comanda, tente novamente ! \n Caso o problema persista entre em contato com o suporte.";
		echo mysqli_error($conn);
	}
}
mysqli_close($conn);
?>
