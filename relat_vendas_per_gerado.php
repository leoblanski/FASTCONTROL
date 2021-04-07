<?php
session_start();
include('conexao.php');


//pega a data via post e converte para BR
$data_inicial = implode('-', array_reverse(explode('/', $_POST["data_inicial"])));
$data_final = implode('-', array_reverse(explode('/', $_POST["data_final"])));

$somente_comanda = $_POST['somente_comanda'];
$somente_direta = $_POST['somente_direta'];

//Busca os dados para o relatório
$sql = "SELECT DISTINCT m.identificador, 
m.data, 
m.documento, 
m.cod_cliente, 
cl.nome, 
m.id_comanda, 
c.numero_comanda, 
m.val_total, 
m.desconto, 
m.nome_pagina,
tv.desc_tipo_venda
FROM movimentacoes m
LEFT JOIN clientes cl on (cl.cod_cliente = m.cod_cliente)
LEFT JOIN comanda c on (c.id_comanda = m.id_comanda)
LEFT JOIN tipo_venda tv on (m.tipo_venda = tv.id_tipo_venda)
WHERE data BETWEEN '$data_inicial' AND '$data_final'
AND cancelado = 'N'
AND m.documento <> '0'
AND m.operacao = 'S'"
;

//totalização de valores
$soma_mv = "SELECT 
SUM(valor_total), 
SUM(mv.desconto) 
FROM movimentacoes_valores mv
WHERE mv.DATA BETWEEN '$data_inicial' and '$data_final'";

if ($somente_comanda) {
	$sql = $sql . " AND nome_pagina <> 'venda_direta' 
	ORDER BY m.documento ASC";
	$soma_mv = $soma_mv . "AND m.nome_pagina <> 'venda_direta'";

} elseif ($somente_direta){
	$sql = $sql . " AND nome_pagina = 'venda_direta'
	ORDER BY m.documento ASC";
	$soma_mv = $soma_mv. "AND m.nome_pagina = 'venda_direta' ";

}else {
	$sql;
	$soma_mv;
}
$result = mysqli_query($conn, $sql);

// somatórias para apresentação no relatório
$sql_somas = mysqli_query($conn, $soma_mv);
$sql_som = mysqli_fetch_array($sql_somas);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="gb18030">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Relatório Vendas</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
	integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/3332efd830.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/estilo_relat_vendas.css">
	<link rel="stylesheet" type="text/css" href="css/containeres.css">
</head>
<body>

	<?php
	include_once 'menu.php';
	?>

	<center>
		<div class="container_principal">
			<p>Vendas por Período</p>
			<!--<?php echo $sql?>-->
			<br><br>

			<?php if ($rows = mysqli_num_rows($result) > 0) {?>
				<table id="tabela" class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Data</th>
							<th scope="col"><b>Documento</b></th>
							<th scope="col">Cliente</th>
							<?php if($_SESSION['comanda']){?>
								<th scope="col">
									Comanda <i title="Os registros listados nesta coluna como ' - ' tratam-se de vendas diretas, sem comanda atrelada." class="fas fa-info-circle" style="font-size:125%; color:#367fbf;"></i>
								</th>
							 <?php }?>	
							<th scope="col">Oper. Venda</th>
							<th scope="col">Valor Total</th>
							<th scope="col">Desconto</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						while ($rows = mysqli_fetch_array($result)) {
							?>
							<tr>
								<td>&emsp;<?php echo date('d/m/Y', strtotime($rows['data'])); ?></td>
								<td>
									<a href="visualizar_documento.php?identificador=<?php echo $rows['identificador']; ?>" target="_blank">
										<?php echo $rows['documento']; ?>
									</a>
								</td>
								<td><?php echo $rows['cod_cliente'] . " - " . $rows['nome']; ?></td>
								<?php if($_SESSION['comanda']){?>
								<td>
										<?php if($rows['nome_pagina'] == 'venda_direta'){
											echo '-';
										} else {
											echo $rows['id_comanda'];
										}?>
                                </td>
								<?php }?>
                                <td>
									<?php if ($rows['desc_tipo_venda']){
											echo $rows['desc_tipo_venda'];
										}else{
											echo "-";
										}?>
								</td>
								
								<td><?php echo str_replace('.', ',', $rows['val_total']); ?></td>
								<td><?php if ($rows['desconto'] == '0,00') {
									echo '-';
								} else {
									echo str_replace('.', ',', $rows['desconto']);
								} ?>
							</td>
						</tr>
						<?php
						$i++;
					}
					mysqli_close($conn);
					?>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<?php if($_SESSION['comanda']){?>
						    <th></th>
						<?php } ?>
						<th>Totalizadores: </th>
						<th id="val_total"><?php echo number_format($sql_som['SUM(valor_total)'], 2, ',', '.'); ?></th>
						<th id="desconto"><?php echo number_format($sql_som['SUM(mv.desconto)'], 2, ',', '.'); ?></th>
					</tr>
				</tbody>
			</table>

		<?php } else {
			echo("<script>alert('Não foram encontrados registros para os filtros informados. Tente novamente !');</script>");
			echo("<script>window.location = 'relat_vendas_per.php';</script>");
			//echo $sql;
		}
		?>

	</center>
	</html>

