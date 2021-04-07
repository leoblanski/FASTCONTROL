<?php
session_start();
include('conexao.php');

$tipo_pesquisa = $_POST['pesquisa_produto'];
$valor_pesquisa = $_POST['valor_pesquisa'];
$tipo_venda = $_POST['tipo_venda'];

if ($tipo_pesquisa == "descricao") {
	$sql_produtos = "select DISTINCT p.cod_produto, p.descricao, p.preco_venda, p.preco_custo, estoque from produtos p
left join estoque_produto ep on (p.cod_produto = ep.cod_produto) where p.ativo = 'S' and descricao like '%$valor_pesquisa%'";
} elseif ($tipo_pesquisa == "cod_produto") {
	$sql_produtos = "select DISTINCT p.cod_produto, p.descricao, p.preco_venda, p.preco_custo, estoque from produtos p
left join estoque_produto ep on (p.cod_produto = ep.cod_produto) where p.ativo = 'S' and p.cod_produto = $valor_pesquisa";
} elseif ($tipo_pesquisa == "cod_interno") {
	$sql_produtos = "select DISTINCT p.cod_produto, p.descricao, p.preco_venda, p.preco_custo, estoque from produtos p
left join estoque_produto ep on (p.cod_produto = ep.cod_produto) where p.ativo = 'S' and cod_interno = '$valor_pesquisa'";
}

$result = mysqli_query($conn, $sql_produtos);

$id_comanda = filter_input(INPUT_GET, 'id_comanda', FILTER_SANITIZE_NUMBER_INT);
$cod_cliente = filter_input(INPUT_GET, 'cod_cliente', FILTER_SANITIZE_NUMBER_INT);
$nome_pagina = $_GET['nome_pagina'];
$tipo_venda = $_GET['tipo_venda'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Listagem de Produto</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
		  integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/estilo_pesquisa_produto.css">
	<link rel="stylesheet" type="text/css" href="css/containeres.css">
</head>
<body>

<?php
include_once 'menu.php';
?>

<center>
	<div class="container_principal">
		<p>Listagem de Produtos</p><br>
		<br>

		<form method="POST" action="pesquisar_produto_cod.php?id_comanda=<?php echo $id_comanda;?>&cod_cliente=<?php echo $cod_cliente; ?>&nome_pagina=<?php echo $nome_pagina; ?>&tipo_venda=<?php echo $tipo_venda?>">
			<div class="row">
				<select class="col-25-pesquisa" name="pesquisa_produto">
					<option value="descricao">Descrição</option>
					<option value="cod_produto">Código de Produto</option>
					<option value="cod_barras">Código de Barras</option>
				</select>

				<div class="col-75-pesquisa">
					<input type="text" required placeholder="Informe a busca desejada" name="valor_pesquisa"
						   id="valor_pesquisa">
				</div>
			</div>
			<br>

			<div class="botoes_align_pesquisa">
				<input type="submit" value="Pesquisar">
			</div>
			<br><br>
		</form>


		<?php if ($rows = mysqli_num_rows($result) > 0) {

			?>
			<table id="tabela" class="table table-hover">
				<thead>
				<tr>
					<th scope="col">Código</th>
					<th scope="col">Descrição</th>
					<th scope="col">Preço de Venda</th>
					<th scope="col">Estoque</th>
				</tr>
				</thead>
				<tbody>
				<?php
				while ($rows = mysqli_fetch_array($result)) {
					?>
					<tr>
						<td>&emsp;<?php echo $rows['cod_produto']; ?></td>
						<td><?php echo $rows['descricao']; ?></td>
						<td><?php echo str_replace('.', ',', $rows['preco_venda']); ?></td>
						<td><?php echo $rows['estoque']; ?></td>
						<td>
							<a href="inserir_item.php?id_comanda=<?php echo $id_comanda;?>&cod_cliente=<?php echo $cod_cliente; ?>&cod_produto=<?php echo $rows['cod_produto']; ?>&nome_pagina=<?php echo $nome_pagina; ?>&tipo_venda=<?php echo $tipo_venda?>">
								<i class="fa fa-plus" style="font-size:24px;color:green"></i></a> &nbsp;&nbsp;
						</td>
					</tr>
					<?php
				}
				mysqli_close($conn);
				?>
				</tbody>
			</table>
		<?php }
		?>

</center>
</html>
