<?php
session_start();
include_once("conexao.php");

$cod_produto = $_POST['cod_produto'];
$descricao = $_POST['descricao'];
$cod_interno = $_POST['cod_interno'];
$preco_custo = str_replace(',', '.', $_POST['preco_custo']);
$preco_venda = str_replace(',', '.', $_POST['preco_venda']);
$id_linha = $_POST['id_linha'];
$id_marca = $_POST['id_marca'];
$ativo = $_POST['ativo'];

$result_produto = "UPDATE produtos SET descricao='$descricao', id_linha='$id_linha', id_marca='$id_marca', cod_interno='$cod_interno', preco_custo='$preco_custo', preco_venda='$preco_venda', ativo='$ativo' where cod_produto = '$cod_produto'";
$resultado_produto = mysqli_query($conn, $result_produto);

if ($resultado_produto) {
	echo("<script>alert('Produto Editado com Sucesso.')</script>");
	echo("<script>window.location = 'editar_produto.php?cod_produto=$cod_produto';</script>");
} else {
	echo("<script>alert('Produto não foi Editado com Sucesso, tente novamente ! Caso o problema persista, entre em contato com o suporte.')</script>");
	echo("<script>window.location = 'editar_produto.php?cod_produto=$cod_produto';</script>");
	mysqli_close($conn);
}
