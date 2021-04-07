<?php
session_start();
include('conexao.php');

$user_create = $_SESSION['UsuarioId'];
$empresa = $_SESSION['Empresa'];
$cod_cliente = $_GET['cod_cliente'];
$nome_dependente = $_POST['nome_dependente'];
$data_nasci = implode('-', array_reverse(explode('/', $_POST['data_nasci'])));
$sexo = $_POST['sexo'];
$ativo = $_POST['ativo'];
date_default_timezone_set('America/Sao_Paulo');
$dt_create = date('Y-m-d');

	$sql = "INSERT INTO clientes_dependentes (cod_cliente, empresa, nome_dependente, data_nasci_dep, sexo, ativo, user_create, dt_create) VALUES 
	('$cod_cliente', '$empresa', '$nome_dependente', '$data_nasci', '$sexo', '$ativo', '$user_create', '$dt_create')";
	$result = mysqli_query($conn, $sql);
	//echo $sql;
	if ($result) {

		echo("<script>alert('Dependente Cadastrado com Sucesso.')</script>");
		echo("<script>window.location = 'cadastro_dependente.php?cod_cliente=$cod_cliente';</script>");
	} else {
		echo "Não foi possível cadastrar o dependente, tente novamente ! \n Caso o problema persista entre em contato com o suporte.";
		echo mysqli_error($conn);
	}

mysqli_close($conn);
?>
