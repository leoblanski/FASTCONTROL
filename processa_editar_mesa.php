<?php
session_start();
include_once("conexao.php");

$numero_mesa = $_POST['mesa'];
$descricao = $_POST['descricao'];
$ativo=$_POST['ativo'];


$result_mesa = "UPDATE mesas SET descricao='$descricao', ativo='$ativo' WHERE numero_mesa = '$numero_mesa'";
$resultado_mesa = mysqli_query($conn, $result_mesa);


if($resultado_mesa){
	 echo("<script>alert('Mesa Editada com Sucesso.')</script>");
 echo("<script>window.location = 'editar_mesa.php?numero_mesa=$numero_mesa';</script>");

}else{
	echo("<script>alert('A mesa não foi editada com Sucesso, tente novamente ! Caso o problema persista, entre em contato com o suporte.')</script>");
    echo("<script>window.location = 'editar_mesa.php?numero_mesa=$numero_mesa';</script>");
    mysqli_close($conn);
}
