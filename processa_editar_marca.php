<?php
session_start();
include_once("conexao.php");

$id_marca = $_POST['id_marca'];
$descricao = $_POST['descricao'];
$ativo = $_POST['ativo'];


$result = "UPDATE produtos_marca SET descricao='$descricao', ativo='$ativo' WHERE id_marca = '$id_marca'";
$resultado = mysqli_query($conn, $result);


if ($resultado) {
	echo("<script>alert('Marca Editada com Sucesso.')</script>");
	echo("<script>window.location = 'editar_marca.php?id_marca=$id_marca';</script>");

} else {
	echo("<script>alert('A marca não foi editada com Sucesso, tente novamente ! Caso o problema persista, entre em contato com o suporte.')</script>");
	echo("<script>window.location = 'editar_marca.php?id_marca=$id_marca';</script>");
	mysqli_close($conn);
}
