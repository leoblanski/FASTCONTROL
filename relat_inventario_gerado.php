<?php
session_start();
include('conexao.php');

$saldo = $_POST['saldo'];
$linha = $_POST['linha_selecionada'];
$marca = $_POST['marca_selecionada'];


$sql = "SELECT p.cod_produto, 
			   p.descricao, 
			   pm.descricao AS descricao_marca, 
			   pl.descricao AS descricao_linha, 
			   ep.estoque, 
			   (p.preco_custo * ep.estoque) as preco_custo,
			   (p.preco_venda * ep.estoque) as preco_venda
			FROM estoque_produto ep 
				LEFT JOIN produtos p ON (p.cod_produto = ep.cod_produto)
				LEFT JOIN produtos_marca pm ON (p.id_marca = pm.id_marca)
				LEFT JOIN produtos_linha pl ON (p.id_linha = pl.id_linha)
			WHERE p.ativo = 'S'";

$somas = "SELECT 
			SUM(estoque) AS estoque, 
		 	SUM(preco_custo * ep.estoque) AS custo,
		 	SUM(preco_venda * ep.estoque) AS preco_venda
		  FROM estoque_produto ep
			LEFT JOIN produtos p ON (p.cod_produto = ep.cod_produto)
			LEFT JOIN produtos_marca pm ON (p.id_marca = pm.id_marca)
			LEFT JOIN produtos_linha pl ON (p.id_linha = pl.id_linha)
		  WHERE p.ativo = 'S'";

//Se foi marcado para filtrar linha
IF($linha){
	$sql = $sql." AND p.id_linha in (".$linha.")";
	$somas = $somas." AND p.id_linha in (".$linha.")";
}

IF ($marca){
	$sql = $sql."AND p.id_marca in (".$marca.")";
	$somas = $somas." AND p.id_marca in (".$marca.")";
}



IF($saldo == "somente_positivo"){
	$sql = $sql."
	AND ep.estoque > '0'
	ORDER BY p.cod_produto ASC";

	$somas = $somas." AND ep.estoque > '0'";
}
ELSEIF ($saldo == "somente_negativo"){
	$sql = $sql."
	AND ep.estoque < '0'
	ORDER BY p.cod_produto ASC";
	
	$somas = $somas." AND ep.estoque < '0'";
}
ELSEIF($saldo == "indiferente"){
	$sql = $sql."
	ORDER BY p.cod_produto ASC";
}
$result = mysqli_query($conn, $sql);

//Totais
$resultado_soma = mysqli_query($conn, $somas);
$resultado_soma_array = mysqli_fetch_array($resultado_soma);
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
	<link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/estilo_relat_inventario.css">
	<link rel="stylesheet" type="text/css" href="css/containeres.css">
</head>
<body>

	<?php
	include_once 'menu.php';
	?>

	<center>
		<div class="container_principal">
			<p>Inventário de Produtos</p><br>
			
			<br>
			<?php if ($rows = mysqli_num_rows($result) > 0) {?>
				<table id="tabela" class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Código</th>
							<th scope="col">Descrição</th>
							<th scope="col">Linha</th>
							<th scope="col">Marca</th>
							<th scope="col">
							    Custo <i class="fa fa-info-circle" title="Os registros listados nesta coluna são resultantes do cálculo do preço de custo do produto multiplicado pela quantidade."  style="font-size:125%; color:#367fbf;"></i>
							</th>
							<th scope="col">
							    Venda <i class="fa fa-info-circle" title="Os registros listados nesta coluna são resultantes do cálculo do preço de venda do produto multiplicado pela quantidade."  style="font-size:125%; color:#367fbf;"></i>
							</th>
							<th scope="col">Estoque</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						while ($rows = mysqli_fetch_array($result)) {
							?>
							<tr>
								<td><?php echo $rows['cod_produto']; ?></td>
								<td>
        						    <?php echo $rows['descricao']; 
        						    if($rows['ativo'] == 'N'){
            						    echo " - ";?>
            						    <label style="color: red; font-weight:none; padding:0px; margin-bottom:0;"><?php echo "(DESATIVADO)";
            					    }
            					    ?>
            					</td>
								<td><?php echo $rows['descricao_linha']; ?></td>
								<td><?php echo $rows['descricao_marca']; ?></td>
								<td><?php echo number_format($rows['preco_custo'], 2, ',', '.'); ?></td>
								<td><?php echo number_format($rows['preco_venda'], 2, ',', '.'); ?></td>
								<td><?php echo $rows['estoque']; ?></td>
								<!-- Lógica abaixo para apresentação de ícones conforme estoque-->
								<td><?php 
								IF($rows['estoque'] < 0){ ?>
									<i class="fa fa-arrow-circle-down" title="Saldo negativo" style="color: red" aria-hidden="true"></i>
								<?php } 
								ELSEIF($rows['estoque'] > 0){ ?>
									<i class="fa fa-arrow-circle-up" title="Saldo positivo" style="color: green" aria-hidden="true"></i>
								<?php }
								ELSEIF($rows['estoque'] == 0){ ?>
									<i class="fa fa-circle" title="Saldo zerado" style="color: #ff8d00" aria-hidden="true"></i>
								<?php }?>
							</tr>
							<?php
						}
						mysqli_close($conn);
						?>
						<tr>
					<th></th>
					<th></th>
					<th></th>
					<th>Totalizadores: </th>
					<th id="custo"><?php echo number_format($resultado_soma_array['custo'], 2, ',', '.'); ?></th>
					<th id="venda"><?php echo number_format($resultado_soma_array['preco_venda'], 2, ',', '.'); ?></th>
					<th id="estoque"><?php echo number_format($resultado_soma_array['estoque'], 0, ',', '.'); ?></th>
				</tr>
					</tbody>
				</table>
			<?php } else {
				echo("<script>alert('Nenhum registro encontrado, realize uma nova busca utilizando novos filtros.')</script>");
				echo("<script>window.location = 'relat_inventario.php';</script>");
			}
			?>

		</center>
		</html>
