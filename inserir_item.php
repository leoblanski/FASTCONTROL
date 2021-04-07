<?php

include('conexao.php');

$id_comanda = filter_input(INPUT_GET, 'id_comanda', FILTER_SANITIZE_NUMBER_INT);
$cod_cliente = filter_input(INPUT_GET, 'cod_cliente', FILTER_SANITIZE_NUMBER_INT);
$cod_produto = filter_input(INPUT_GET, 'cod_produto', FILTER_SANITIZE_NUMBER_INT);
$tipo_venda = $_GET['tipo_venda'];
$nome_pagina = $_GET['nome_pagina'];
$sql = "select * from produtos where cod_produto = $cod_produto";
$result = mysqli_query($conn, $sql);


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
<body onload="subtotal_item();">

	<?php
	include_once 'menu.php';
	?>

	<center>
		<div class="container_principal">
			<p>Inclusão de Produtos</p><br>
			<br>

			<form method="POST"	action="processa_incluir_itens.php?nome_pagina=<?php echo $nome_pagina;?>">

			<input type="hidden" value="<?php echo $id_comanda; ?>" id="id_comanda" name="id_comanda">
			<input type="hidden" value="<?php echo $cod_cliente; ?>" id="cod_cliente" name="cod_cliente">
			<input type="hidden" value="<?php echo $cod_produto; ?>" id="cod_produto" name="cod_produto">
			<input type="hidden" value="<?php echo $nome_pagina; ?>" id="nome_pagina" name="nome_pagina">
			<input type="hidden" value="<?php echo $tipo_venda;?>" id="tipo_venda" name="tipo_venda">

			<?php if ($rows = mysqli_num_rows($result) > 0) {

				?>
				<table id="tabela" class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Código</th>
						<th scope="col">Descrição</th>
							<th scope="col">Qtd</th>
							<th scope="col">Preço</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while ($rows = mysqli_fetch_array($result)) {
							?>
							<tr>
								<td>&emsp;<?php echo $rows['cod_produto']; ?></td>
								<td><?php echo $rows['descricao']; ?></td>
								<td>
									<div class="row">
										<div class="col-25-inc">
											<input type="text" onkeyup="subtotal_item();" name="quantidade" id="quantidade"
											value="1">
										</div>
									</div>

								</td>
								<td>
									<div class="row">
										<div class="col-25-inc">
											<input type="text" onKeyPress="return(MascaraMoeda(this,'.',',',event))"
											onkeyup="subtotal_item();" name="preco_venda" id="preco_venda"
											value="<?php echo str_replace('.', ',', $rows['preco_venda']); ?>">
										</div>
									</div>

								</td>
							</tr>
							<?php
						}
						mysqli_close($conn);
						?>
					</tbody>

				</table>
				<div class="subtotais_valores">
					<div class="row">
						<div class="col-25-sub">
							<label><b>Subtotal: </b></label>
						</div>
						<div class="col-50-sub">
							<input type="text" required name="subtotal" id="subtotal">
						</div>
					</div>
				</div>
				<div class="botoes_align_inc">
					<input type="submit" value="Incluir Produto">
				</div>
			<?php }
			?>

		</center>
		<script language="javascript">
			function subtotal_item() {
				var quantidade = document.getElementById('quantidade').value;
				var preco_venda = document.getElementById('preco_venda').value.replace(",", ".");
				var subtotal = quantidade * preco_venda;

				document.getElementById('subtotal').value = subtotal.toFixed(2).replace(".", ",");

			}


			function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e) {
				var sep = 0;
				var key = '';
				var i = j = 0;
				var len = len2 = 0;
				var strCheck = '0123456789';
				var aux = aux2 = '';
				var whichCode = (window.Event) ? e.which : e.keyCode;
				if (whichCode == 13 || whichCode == 8) return true;
		key = String.fromCharCode(whichCode); // Valor para o código da Chave
		if (strCheck.indexOf(key) == -1) return false; // Chave inválida
		len = objTextBox.value.length;
		for (i = 0; i < len; i++)
			if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
		aux = '';
		for (; i < len; i++)
			if (strCheck.indexOf(objTextBox.value.charAt(i)) != -1) aux += objTextBox.value.charAt(i);
		aux += key;
		len = aux.length;
		if (len == 0) objTextBox.value = '';
		if (len == 1) objTextBox.value = '0' + SeparadorDecimal + '0' + aux;
		if (len == 2) objTextBox.value = '0' + SeparadorDecimal + aux;
		if (len > 2) {
			aux2 = '';
			for (j = 0, i = len - 3; i >= 0; i--) {
				if (j == 3) {
					aux2 += SeparadorMilesimo;
					j = 0;
				}
				aux2 += aux.charAt(i);
				j++;
			}
			objTextBox.value = '';
			len2 = aux2.length;
			for (i = len2 - 1; i >= 0; i--)
				objTextBox.value += aux2.charAt(i);
			objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
		}
		return false;
	}
</script>

</body>

</html>
