<?php
session_start();
include('conexao.php');

$user_create=$_SESSION['UsuarioId'];
$descricao=$_POST['descricao'];
$cod_interno=$_POST['cod_interno'];
$preco_custo = str_replace(',', '.', $_POST['preco_custo']);
$preco_venda = str_replace(',', '.', $_POST['preco_venda']);
$id_linha = $_POST['id_linha'];
$id_marca = $_POST['id_marca'];
$ativo = $_POST['ativo'];
$data = date('Y-m-d');
date_default_timezone_set('America/Sao_Paulo');
$datetime=date("d/m/y H:i:s");
$cod_produto = $_POST['cod_produto'];
$estoque = $_POST['estoque'];

$sql="INSERT INTO produtos(cod_produto, descricao, id_linha, id_marca, cod_interno, preco_custo, preco_venda, dt_create, user_create, ativo)VALUES('$cod_produto','$descricao', '$id_linha', '$id_marca', '$cod_interno', '$preco_custo', '$preco_venda','$data', '$user_create', '$ativo')";
$result=mysqli_query($conn, $sql);

$sql_estoque = "INSERT INTO estoque_produto (cod_produto, estoque) VALUES ('$cod_produto','$estoque')";
$result_estoque=mysqli_query($conn, $sql_estoque);

if($result){
 echo("<script>alert('Produto Cadastrado com Sucesso.')</script>");
 echo("<script>window.location = 'cadastro_produto.php';</script>");
}
else {
echo "Não foi possível cadastrar o produto, tente novamente.".mysqli_error($conn);
mysqli_close($conn);
}
mysqli_close($conn);

?>
