<?php
session_start();
include('conexao.php');

$cod_produto = $_POST['cod_produto'];
$cod_cliente = "0";
$empresa = $_SESSION['Empresa'];
$quantidade_atual = $_POST['quantidade_atual']; /*quantidade antes do ajuste*/
$quantidade = $_POST['quantidade'];/*Quantidade que deve ser a final*/
$user_create = $_SESSION['UsuarioId'];
$operacao = "";
$operacao_detalhe = "AJ";
$val_unitario = "0,01";
$val_total = "0,01";
date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d');
$hora = date('H:i');
$cancelado = "N";
$obs_cliente = $_POST['obs'];
$msg_padrao_ajuste = "Ajuste de Saldo Efetuado Conforme Processamento. ";
$obs = $msg_padrao_ajuste.$obs_cliente;
$data_identificador = date('dmyy');
$hora_identificador = date('His');
$identificador = $data_identificador . $hora_identificador; // cria o identificador



if ($quantidade == $quantidade_atual) {
	echo("<script>alert('A quantidade não foi alterada, pois a quantidade atual é a mesma que a quantidade informada para ajuste.')</script>");
	echo("<script>window.location = 'ajuste_saldo.php?cod_produto=$cod_produto';</script>");
} else {
	$qtd_ajuste = $quantidade - $quantidade_atual;
	if ($qtd_ajuste < 0) {
		$operacao = "S";
	} else {
		$operacao = "E";
	}
}

$sql = "INSERT INTO movimentacoes (empresa, identificador, cod_cliente, documento, cod_produto, quantidade, val_unitario, val_total, data, hora, operacao, operacao_detalhe, usuario, cancelado, obs) VALUES ('$empresa','$identificador','$cod_cliente', '0', '$cod_produto', '$qtd_ajuste', '$val_unitario', '$val_total', '$data', '$hora', '$operacao', '$operacao_detalhe', '$user_create', '$cancelado','$obs')";
$result=mysqli_query($conn, $sql);

if ($result) {

	echo("<script>alert('Saldo do Produto Ajustado com Sucesso.')</script>");
	echo("<script>window.location ='ajuste_saldo.php?cod_produto=$cod_produto';</script>");
} else {
	//echo("<script>alert('A quantidade não foi alterada, tente novamente ! Caso o problema persista, entre em contato com o suporte. ')</script>");
	//echo("<script>window.location = 'ajuste_saldo.php?cod_produto=$cod_produto';</script>");
	echo mysqli_error($conn);
}
mysqli_close($conn);
?>
