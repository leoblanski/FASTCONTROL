<?php
session_start();
include_once("conexao.php");

$nome_pagina = $_POST['nome_pagina'];
$id_comanda = $_POST['id_comanda'];
$documento = $_POST['num_venda'];
$nome_pagina = $_POST['nome_pagina'];
$cod_cliente = $_POST['cod_cliente'];
$val_total = str_replace(',', '.', $_POST['total']);
$desconto = str_replace(',', '.', $_POST['desconto']);
$identificador = $_POST['identificador'];
$operacao_detalhe = 'V';
date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d');
$hora = date('H:i');
$user = $_SESSION['UsuarioId'];
$obs = 'Venda para consumidor final';

$sql = mysqli_query($conn, "SELECT * FROM carrinho_tmp where identificador = $identificador");
//Planos
$cod_plano1 = $_POST['plano_pagamento1'];
$total_plano1 = $_POST['total_plano1'];
$cod_plano2 = $_POST['plano_pagamento2'];
$total_plano2 = $_POST['total_plano2'];
$cod_plano3 = $_POST['plano_pagamento3'];
$total_plano3 = $_POST['total_plano3'];

// remove valores caso n�o tenha sido selecionado o plano

if ($total_plano1 == '0,00') {
	$cod_plano1 = '';
	$total_plano1 = '';
}
if ($total_plano2 == '0,00') {
	$cod_plano2 = '';
	$total_plano2 = '';
}
if ($total_plano3 == '0,00') {
	$cod_plano3 = '';
	$total_plano3 = '';
}

while ($retorno = mysqli_fetch_array($sql)) {

	$cod_produto = $retorno['cod_produto'];
	$quantidade = $retorno['quantidade'];
	$val_unitario = $retorno['val_unitario'];
	$operacao = $retorno['operacao'];
	$tipo_venda = $retorno['tipo_venda'];


	$insert = "INSERT INTO movimentacoes(empresa, cod_cliente, cod_produto, documento, id_comanda, quantidade, val_unitario, val_total, desconto, data, hora, operacao, operacao_detalhe, usuario, cancelado, obs, identificador, nome_pagina, tipo_venda) VALUES ('1','$cod_cliente', '$cod_produto', '$documento', '$id_comanda', '$quantidade', '$val_unitario', '$val_total', '$desconto', '$data', '$hora','$operacao', '$operacao_detalhe', '$user', 'N', '$obs','$identificador', '$nome_pagina', '$tipo_venda')";
	$exec = mysqli_query($conn, $insert);
}
$insert_total = "INSERT INTO movimentacoes_valores (identificador, valor_total, desconto, data, id_comanda) VALUES ('$identificador', '$val_total', '$desconto', '$data', '$id_comanda')";
$exec_total = mysqli_query($conn,$insert_total);

$insert_planos1 = "INSERT INTO movimentacoes_planos (cod_plano, total_plano, identificador) VALUES ('$cod_plano1', '$total_plano1', '$identificador')";
$insert_planos2 = "INSERT INTO movimentacoes_planos (cod_plano, total_plano, identificador) VALUES ('$cod_plano2', '$total_plano2', '$identificador')";
$insert_planos3 = "INSERT INTO movimentacoes_planos (cod_plano, total_plano, identificador) VALUES ('$cod_plano3', '$total_plano3', '$identificador')";

$exec_planos1 = mysqli_query($conn, $insert_planos1);
$exec_planos2 = mysqli_query($conn, $insert_planos2);
$exec_planos3 = mysqli_query($conn, $insert_planos3);

if ($nome_pagina != 'venda_direta'){
	if ($exec) {
		// caso sucesso no insert na movimentacoes, baixa a comanda.
		$baixar_comanda = "UPDATE comanda SET finalizada = '1' WHERE id_comanda = $id_comanda";
		$baixa_comanda = mysqli_query($conn, $baixar_comanda);
		if ($baixa_comanda) {
			echo("<script>alert('Comanda Baixada com Sucesso.');</script>");
		} else {
			echo mysqli_error($conn);
		}

		echo(
		"<script>
			alert('Venda Finalizada com Sucesso.');

			var r=confirm('Deseja visualizar o resumo da venda?');

			if (r==true)
			{
				window.open('visualizar_documento.php?identificador=$identificador');
				window.location = 'comanda_aberto.php';
			}
			else
			{
				window.location = 'comanda_aberto.php';
			}
		</script>"
	);
	} else {
		//echo("<script>alert('N�o foi poss�vel finalizar a venda, tente novamente. Caso o problema persista, entre em contato com o suporte.);</script>");
		echo mysqli_error($conn);
	};
}
else{
	echo(
		"<script>
			alert('Venda Finalizada com Sucesso.');

			var r=confirm('Deseja visualizar o resumo da venda?');

			if (r==true)
			{
				window.open('visualizar_documento.php?identificador=$identificador');
				window.location = 'venda_direta.php';
			}
			else
			{
				window.location = 'venda_direta.php';
			}
		</script>"
	);
}
?>