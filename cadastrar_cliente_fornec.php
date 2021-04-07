<?php
session_start();
include('conexao.php');

$user_create = $_SESSION['UsuarioId'];
$cpf = $_POST['cpf'];
$nome = $_POST['nome'];
$data_nasci = implode('-', array_reverse(explode('/', $_POST["data_nasci"]))); // converte / para - e formata data
$telefone = $_POST['telefone'];
$sexo = strtoupper($_POST['sexo']);
$email = $_POST['email'];
$cep = $_POST['cep'];
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];
$obs = $_POST['obs'];
$ativo = $_POST['ativo'];
$data_cadastro = date('Y-m-d');
date_default_timezone_set('America/Sao_Paulo');
$datetime = date("d/m/y H:i:s");


/*
$result_usuario = "SELECT cpf FROM clientes WHERE cpf='$cpf'";
//Ocultado conforme solicitação Patricia - Molinari
$resultado_usuario = mysqli_query($conn, $result_usuario);
if (($resultado_usuario) AND ($resultado_usuario->num_rows != 0)) {
	echo("<script>alert('Já existe um cliente cadatrado com o CPF $cpf.')</script>");
	echo "<script>window.location = 'cadastro_cliente_fornec.php';</script>";
} else {*/
	$sql = "INSERT INTO clientes(nome, cpf, data_nasci, telefone, sexo, email, cep, estado, cidade, observacao, data_cadastro, user_create, ativo)VALUES
								('$nome', '$cpf', '$data_nasci', '$telefone', '$sexo','$email', '$cep', '$estado', '$cidade', '$obs', '$data_cadastro', '$user_create','$ativo')";
	$result = mysqli_query($conn, $sql);


	if ($result) {

		$cod = mysqli_insert_id($conn);
		echo("<script>alert('Cliente cadastrado com sucesso!')</script>");
		echo("<script>window.location = 'editar_cliente.php?cod_cliente=$cod';</script>");
	} else {
		echo "Não foi possível cadastrar o cliente, tente novamente ! \n Caso o problema persista entre em contato com o suporte.";

		$conn->close();

	}
//}


$conn->close();
?>
