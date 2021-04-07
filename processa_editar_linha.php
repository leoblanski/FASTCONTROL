<?php
session_start();
include_once("conexao.php");

$id_linha = $_POST['id_linha'];
$descricao = $_POST['descricao'];
$ativo = $_POST['ativo'];


$result = "UPDATE produtos_linha SET descricao='$descricao', ativo='$ativo' WHERE id_linha = '$id_linha'";
$resultado = mysqli_query($conn, $result);


if ($resultado) {
	echo("<script>alert('Linha Editada com Sucesso.')</script>");
	echo("<script>window.location = 'editar_linha.php?id_linha=$id_linha';</script>");

} else {
	echo("<script>alert('A linha não foi editada com Sucesso, tente novamente ! Caso o problema persista, entre em contato com o suporte.')</script>");
	echo("<script>window.location = 'editar_linha.php?id_linha=$id_linha';</script>");
	mysqli_close($conn);
}
