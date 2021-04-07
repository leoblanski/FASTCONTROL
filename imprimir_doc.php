<?php
session_start();
include('conexao.php');

$identificador = $_GET['identificador'];

$sql = "SELECT DISTINCT m.cod_produto, p.descricao, m.quantidade, m.val_unitario, m.val_total FROM movimentacoes m
		LEFT JOIN produtos p on (p.cod_produto = m.cod_produto)
		LEFT JOIN clientes cl on (cl.cod_cliente = m.cod_cliente)
		LEFT JOIN empresa emp on (emp.id_empresa = m.empresa)
		LEFT JOIN movimentacoes_planos mp on (mp.identificador = m.identificador)
		WHERE m.identificador = $identificador";
$result = mysqli_query($conn, $sql);


// Verificar a utilização do select anterior nesta consulta abaixo, quando utilizado a mesma consulta para arrays diferentes não retorna os dados corretamente, criado paliativo abaixo.

$sql_geral = "SELECT * FROM movimentacoes m
		LEFT JOIN clientes cl on (cl.cod_cliente = m.cod_cliente)
		LEFT JOIN movimentacoes_planos mp on (mp.identificador = m.identificador)
		LEFT JOIN planos pl on (pl.cod_plano = mp.cod_plano)
		WHERE m.identificador = $identificador";
$result_geral = mysqli_query($conn, $sql_geral);
$rows_geral = mysqli_fetch_array($result_geral);


// Verificar a utilização do select anterior nesta consulta abaixo, quando utilizado a mesma consulta para arrays diferentes não retorna os dados corretamente, mais especificamente a primeira linha do select, algo a ver com o ponteiro, pois ja passou da primeira posição, criado paliativo abaixo.


$sql_planos = "SELECT DISTINCT mp.cod_plano, pl.descricao, mp.total_plano FROM movimentacoes m
		LEFT JOIN movimentacoes_planos mp on (mp.identificador = m.identificador)
		LEFT JOIN planos pl on (pl.cod_plano = mp.cod_plano)
		WHERE m.identificador = $identificador
		AND mp.cod_plano <> ''";
$result_planos = mysqli_query($conn, $sql_planos);


$soma_mv = "SELECT valor_total, desconto FROM movimentacoes_valores WHERE identificador = $identificador";
$exec_soma_mv = mysqli_query($conn, $soma_mv);
$soma_mv_array = mysqli_fetch_array($exec_soma_mv);


$soma_m = "SELECT SUM(val_unitario) from movimentacoes where identificador = $identificador";
$exec_soma_m = mysqli_query($conn, $soma_m);
$soma_m_array = mysqli_fetch_array($exec_soma_m);


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Relatório Vendas</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
	integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/3332efd830.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/impressao_doc_imp.css" >


	<script>
		function imprimir(){
			window.print() 
		}
	</script>
</head>
<body onload="imprimir();">
<div class="container_principal_imp">
	<center>
	<h1>Registro Interno</h1>
	</center>
	<br>

	<div class="dados_iniciais">
		<label>
			<b>Data: </b><?php echo date('d/m/Y', strtotime($rows_geral['data'])) . " - " . $rows_geral['hora']; ?><br>
			<b>Cliente: </b><?php echo $rows_geral['cod_cliente'] . " - " . $rows_geral['nome']; ?><br>
			<b>Documento: </b><?php echo $rows_geral['documento']; ?><br>
		</label>
	</div>

	<div class="planos">
		<label>
			<b>- Planos de Pagamento -</b><br>
			<?php

			while ($rows_planos = mysqli_fetch_array($result_planos)) { ?>

			<?php echo $rows_planos['descricao'] . ": R$" . $rows_planos['total_plano'] ?>
				<br>
				<?php

				} ?><br>
		</label>
	</div>


	<?php if ($rows = mysqli_num_rows($result) > 0) {

		?>
		<table id="tabela" class="table table-hover">
			<thead>
			<tr>
				<th scope="col">Cod Produto</th>
				<th scope="col">Descrição</th>
				<th scope="col">Quantidade</th>
				<th scope="col">Valor Unitário</th>
				<th scope="col">Valor Total</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$i = 1;
			while ($rows = mysqli_fetch_array($result)) {
			//calcula o total por linha
			$total = ($rows['quantidade'] * $rows['val_unitario']);

			?>
			<tr>
				<td><?php echo $rows['cod_produto']; ?></td>
				<td><?php echo $rows['descricao']; ?></td>
				<td><?php echo $rows['quantidade']; ?></td>
				<td><?php echo str_replace('.', ',', $rows['val_unitario']); ?></td>
				<td><?php echo number_format($total, 2, ',', '.'); ?></td>
				<?php
				$i++;
				}
				mysqli_close($conn);
				?>
			</tbody>
		</table>
		<center>
			<div class="endereco">
				<label>
					<h4>Observações</h4>
					<?php echo $rows_geral['cidade']." - ".$rows_geral['observacao']?>
				</label>
			</div><br>
			<div class="totalizadores">
				<label><b>TOTAIS</b></label><BR>
				<label><b>Total dos Produtos: </b><?php
					$subtotal = ($soma_mv_array['valor_total'] + $soma_mv_array['desconto']);

					echo number_format($subtotal, 2, ',', '.'); ?>
				</label><br>
				<label><b>Desconto: </b><?php echo number_format($soma_mv_array['desconto'], 2, ',', '.'); ?>
				</label><br>
				<label><b>Valor Total: </b><?php echo number_format($soma_mv_array['valor_total'], 2, ',', '.'); ?>
				</label>
			</div>
		</center>
	<?php } else {
		echo("<script>alert('Nenhum registro encontrado, realize uma nova busca utilizando novos filtros.')</script>");
		//echo("<script>window.location = 'relat_vendas_per.php';</script>");
	}
	?>
</html>

