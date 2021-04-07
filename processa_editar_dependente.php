<?php
session_start();
include_once("conexao.php");

$user_create = $_SESSION['UsuarioId'];
$empresa = $_SESSION['Empresa'];
$cod_cliente = $_GET['cod_cliente'];
$id_cliente_dep = $_GET['id_cliente_dep'];
$nome_dependente = $_POST['nome_dependente'];
$data_nasci = implode('-', array_reverse(explode('/', $_POST['data_nasci'])));
$sexo = $_POST['sexo'];
$ativo = $_POST['ativo'];
date_default_timezone_set('America/Sao_Paulo');
$dt_create = date('yy-m-d');

$result = "UPDATE clientes_dependentes SET nome_dependente='$nome_dependente', data_nasci_dep='$data_nasci', sexo='$sexo', ativo='$ativo' WHERE id_cliente_dep = $id_cliente_dep";
$resultado = mysqli_query($conn, $result);


if ($resultado) {
	echo("<script>alert('Dependente Editado com Sucesso.')</script>");
	echo("<script>window.location = 'editar_dependente.php?id_cliente_dep=$id_cliente_dep&cod_cliente=$cod_cliente';</script>");

} else {
	echo("<script>alert('Não foi possível cadastrar o dependente, tente novamente ! \n Caso o problema persista entre em contato com o suporte.')</script>");
	echo("<script>window.location = 'editar_dependente.php?id_cliente_dep=$id_cliente_dep&cod_cliente=$cod_cliente';</script>");
	mysqli_close($conn);
}

