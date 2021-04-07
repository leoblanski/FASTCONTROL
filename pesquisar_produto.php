<?php
session_start();
include('conexao.php');

$tipo_pesquisa = $_POST['pesquisa_produto'];
$valor_pesquisa = $_POST['valor_pesquisa'];


$sql_produtos = "select DISTINCT p.ativo, p.cod_produto, p.descricao, p.preco_venda, p.preco_custo, estoque from produtos p
left join estoque_produto ep on (p.cod_produto = ep.cod_produto) where ";

if ($tipo_pesquisa == "descricao") {
	$sql_produtos = $sql_produtos."descricao like '%$valor_pesquisa%' ORDER BY p.descricao ASC";
} elseif ($tipo_pesquisa == "cod_produto") {
    $sql_produtos = $sql_produtos."p.cod_produto = $valor_pesquisa ORDER BY p.descricao ASC" ;
} elseif ($tipo_pesquisa == "cod_interno") {
	$sql_produtos = $sql_produtos."cod_interno like '%$valor_pesquisa%' ORDER BY p.descricao ASC ";
}

$result = mysqli_query($conn, $sql_produtos);


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">

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

		<form method="POST" action="pesquisar_produto.php">
			<div class="row">
				<select class="col-25-pesquisa" name="pesquisa_produto">
					<option value="descricao">Descrição</option>
					<option value="cod_produto">Código de Produto</option>
					<option value="cod_barras">Código de Barras</option>
				</select>

				<div class="col-75-pesquisa">
					<input type="text" placeholder="Informe a busca desejada" name="valor_pesquisa"
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
					<th scope="col">Custo</th>
					<th scope="col">Preço de Venda</th>
					<th scope="col">Estoque</th>
					<th scope="col">Ações</th>
				</tr>
				</thead>
				<tbody>
				<?php
				while ($rows = mysqli_fetch_array($result)) {
					?>
					<tr>
						<td>&emsp;<?php echo $rows['cod_produto'];?></td>
						<td>
						    <?php echo $rows['descricao']; 
						    if($rows['ativo'] == 'N'){
    						    echo " - ";?>
    						    <label style="color: red; font-weight:none; padding:0px; margin-bottom:0;"><?php echo "(DESATIVADO)";
    					    }
    					    ?>
    					</td>
						<td><?php echo str_replace('.', ',', $rows['preco_custo']);?></td>
						<td><?php echo str_replace('.', ',', $rows['preco_venda']); ?></td>
						<td><?php echo $rows['estoque']; ?></td>
						<td>
							<a href="editar_produto.php?cod_produto=<?php echo $rows["cod_produto"]; ?>"title="Editar Produto">
								<i class="fa fa-edit" style="font-size:24px;color:green"></i></a> &nbsp;&nbsp;
							<a href="ajuste_saldo.php?cod_produto=<?php echo $rows["cod_produto"]; ?>"title="Ajustar Saldo">
								<i class="fa fa-wrench" style="font-size:24px;color:#ff8d00"></i></a> &nbsp;&nbsp;
						</td>
					</tr>
					<?php
				}
				mysqli_close($conn);
				?>
				</tbody>
			</table>
		<?php } else {
			echo("<script>alert('Nenhum registro encontrado.')</script>");
			echo("<script>window.location = 'pesquisa_produtos.php';</script>");
		}
		?>

</center>
</html>
