<?php
session_start();
include('conexao.php');


$id_comanda = $_POST['id_comanda'];
$cod_cliente = $_POST['cod_cliente'];
$cod_produto = $_POST['cod_produto'];
$nome_pagina = $_POST['nome_pagina'];
$quantidade = $_POST['quantidade'];
$tipo_venda = $_POST['tipo_venda'];
$preco_venda = str_replace(',', '.', $_POST['preco_venda']);
$cancelado = 'N';
$operacao = 'S';
date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d');
$data_identificador = date('dmyy');
$hora = date('H:i');
$hora_identificador = date('His');
$user = $_SESSION['UsuarioId'];


/*Se houver retorno irá considerar o identificador que já está no banco de dados, caso contrário irá criar com as variveis $data_identificador . $hora_identificador.*/

$sql_verifica_identificador = "SELECT identificador FROM carrinho_tmp WHERE id_comanda = $id_comanda and identificador <> '' ";
$resultado_verifica_identificador = mysqli_query($conn, $sql_verifica_identificador);
$retorno_identificador = mysqli_fetch_array($resultado_verifica_identificador);
$identificador_sql = $retorno_identificador['identificador'];
$linhas_id = mysqli_num_rows($resultado_verifica_identificador);

if ($linhas_id == 0) {
	$identificador = $data_identificador . $hora_identificador; // cria o id
} else {
	$identificador = $identificador_sql; //se tiver registro do id no banco, considera ele mesmo
}
/*Verifica se o produto já está no carrinho, se sim, irá dar update na quantidade, se não, adicionará uma nova linha. OBS: caso o valor unitario do banco seja diferente do valor informado pelo cliente, também será criada uma nova linhana tabela.*/

$sql_verifica_produtos = "SELECT * FROM carrinho_tmp WHERE cod_produto = $cod_produto and id_comanda = $id_comanda";
$resultado_verifica_produtos = mysqli_query($conn, $sql_verifica_produtos);
$retorno_verifica_rows = mysqli_fetch_array($resultado_verifica_produtos);
$retorno = mysqli_num_rows($resultado_verifica_produtos);


//valida a página

//Se houver mais de 1 linha e o valor do produto for igual ao que consta no carrinho ...
if ($retorno <> 0 and $retorno_verifica_rows['val_unitario'] == $preco_venda) {
	$quantidade = $retorno_verifica_rows['quantidade'] + $quantidade;
	$sql_update = "UPDATE carrinho_tmp SET quantidade = $quantidade WHERE cod_produto = $cod_produto and id_comanda = $id_comanda";
	$result = mysqli_query($conn, $sql_update);
	if ($result) {
		echo("<script>window.location = 'carrinho.php?id_comanda=$id_comanda&cod_cliente=$cod_cliente&nome_pagina=$nome_pagina&tipo_venda=$tipo_venda';</script>");
	} else {
		echo("<script>alert('Não foi possível inserir o produto no carrinho!.');</script>");
		echo mysqli_error($conn);
	}
} else {
	$sql = "INSERT INTO carrinho_tmp(cancelado, cod_cliente, cod_produto, quantidade, val_unitario, id_comanda, operacao, data, hora, user, identificador, nome_pagina, tipo_venda) VALUES ('$cancelado','$cod_cliente','$cod_produto','$quantidade', '$preco_venda','$id_comanda', '$operacao', '$data', '$hora', '$user', '$identificador', '$nome_pagina', '$tipo_venda')";
	$result = mysqli_query($conn, $sql);

	if ($result) {
		echo("<script>window.location = 'carrinho.php?id_comanda=$id_comanda&cod_cliente=$cod_cliente&nome_pagina=$nome_pagina&tipo_venda=$tipo_venda';</script>");
	} else {
		echo("<script>alert('Não foi possível inserir o produto no carrinho!.');</script>");
		echo $sql;
		echo mysqli_error($conn);
	}
	mysqli_close($conn);

}
?>
