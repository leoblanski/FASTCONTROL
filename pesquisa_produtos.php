<?php
session_start();
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
					<option value="cod_interno">Código Interno</option>
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
		</form>

	</div>

</center>


</html>
