<?php
include('conexao.php');

function retorna($cod_cliente, $conn){
	$result_cliente = "select * from clientes where cod_cliente = '$cod_cliente' LIMIT 1";
	$resultado_cliente = mysqli_query($conn, $result_cliente);
	if($resultado_cliente->num_rows){
		$row_cliente = mysqli_fetch_assoc($resultado_cliente);
		$valores['nome_cliente'] = $row_cliente['nome'];
	}else{
		$valores['nome_cliente'] = 'Cliente não encontrado.';
	}
	return json_encode($valores);
}

if(isset($_GET['cod_cliente'])){
	echo retorna($_GET['cod_cliente'], $conn);
}
?>