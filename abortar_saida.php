<?php
session_start();
include_once("conexao.php");

$id_comanda = filter_input(INPUT_GET, 'id_comanda', FILTER_SANITIZE_NUMBER_INT);
$cod_cliente = filter_input(INPUT_GET, 'cod_cliente', FILTER_SANITIZE_NUMBER_INT);
$cod_produto = filter_input(INPUT_GET, 'cod_produto', FILTER_SANITIZE_NUMBER_INT);
$identificador = $_GET['identificador'];
$nome_pagina = $_GET['nome_pagina'];
$empresa = $_SESSION['Empresa']; 


//CANCELA carrinho
$sql_cancela = "DELETE FROM carrinho_tmp 
				   WHERE identificador = '$identificador'
				   AND cod_cliente = $cod_cliente
				   AND id_comanda = $id_comanda			   
				   ";
$result = mysqli_query($conn, $sql_cancela);

$sql_comanda = "DELETE FROM comanda WHERE id_comanda = $id_comanda";
$result_comanda = mysqli_query($conn, $sql_comanda);


if($result){
	echo("<script>alert('Venda Abortada com Sucesso.')</script>");
	if($_SESSION['comanda']){
        echo("<script>window.location = 'comanda_aberto.php';</script>");
	}
	else{
        echo("<script>window.location = 'venda_direta.php';</script>");
	}
	
}else{
	echo("<script>alert('Atenção!\nNão foi possível abortar a venda, tente novamente !')</script>");
	if($_SESSION['comanda']){
        echo("<script>window.location = 'comanda_aberto.php';</script>");
	}
	else{
        echo("<script>window.location = 'comanda_aberto.php';</script>");
	}
}
?>