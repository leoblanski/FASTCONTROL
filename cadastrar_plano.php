<?php
session_start();
include('conexao.php');

$user_create = $_SESSION['UsuarioId'];
$descricao = $_POST['descricao'];
$forma_pagamento = $_POST['forma_pagamento'];
$deb_cred = $_POST['deb_cred'];
$parcelas = $_POST['parcelas'];
$ativo = $_POST['ativo'];
date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d');
$hora = date('H:i');


$sql = "INSERT INTO planos (descricao, forma_pagamento, credito_debito, parcelas, dt_create, hr_create, user_create, ativo) VALUES ('$descricao', '$forma_pagamento', '$deb_cred', '$parcelas', '$data', '$hora','$user_create', '$ativo')";
$result = mysqli_query($conn, $sql);
if ($result) {

	echo("<script>alert('Plano de Pagamento Cadastrado com Sucesso.')</script>");
	echo("<script>window.location = 'cadastro_plano.php';</script>");
} else {
	//echo "Não foi possível cadastrar o plano de pagamento, tente novamente ! \n Caso o problema persista entre em contato com o suporte.";
	echo mysqli_error($conn);
}

mysqli_close($conn);
?>
