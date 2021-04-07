<?php
include('conexao.php');

function retorna($cod_produto, $conn){
	$result_produto = "select * from produtos where cod_produto = $cod_produto LIMIT 1";
	$resultado_produto = mysqli_query($conn, $result_produto);
	if($resultado_produto->num_rows){
		$row_produto = mysqli_fetch_assoc($resultado_produto);
		$valores_prod['descricao'] = $row_produto['descricao'];
	}else{
		$valores_prod['descricao'] = 'Produto não encontrado.';
	}
	return json_encode($valores_prod);
}

if(isset($_GET['cod_produto'])){
	echo retorna($_GET['cod_produto'], $conn);
}
?>