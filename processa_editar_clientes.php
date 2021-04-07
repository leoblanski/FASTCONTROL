<?php
session_start();
include_once("conexao.php");

$cod_cliente = $_POST['cod_cliente'];
$nome = $_POST['nome'];
$cpf=$_POST['cpf'];
$data_nasci=implode('-', array_reverse(explode('/', $_POST["data_nasci"])));
$telefone=$_POST['telefone'];
$sexo=strtoupper($_POST['sexo']);
$email=$_POST['email'];
$cep = $_POST['cep'];
$estado=$_POST['estado'];
$cidade=$_POST['cidade'];
$obs=$_POST['obs'];
$ativo=$_POST['ativo'];

$result_cliente = "UPDATE clientes SET cpf='$cpf', nome='$nome', data_nasci='$data_nasci', telefone='$telefone', sexo='$sexo', email='$email', cep='$cep', estado='$estado', cidade='$cidade', observacao='$obs', ativo='$ativo' WHERE cod_cliente = '$cod_cliente'";
$resultado_cliente = mysqli_query($conn, $result_cliente);


if($resultado_cliente){
	 echo("<script>alert('Cliente Editado com Sucesso.')</script>");
 echo("<script>window.location = 'editar_cliente.php?cod_cliente=$cod_cliente';</script>");

}else{
	echo("<script>alert('Cliente nè´™o foi Editado com Sucesso, tente novamente ! Caso o problema persista, entre em contato com o suporte.')</script>");
    //echo("<script>window.location = 'editar_cliente.php?cod_cliente=$cod_cliente';</script>");
    echo $result_cliente;
    mysqli_close($conn);
}
