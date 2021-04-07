<?php
session_start();

$nome_pagina = $_GET['nome_pagina'];

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pesquisa de Cliente</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
		  integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/estilo_pesquisa_cliente.css">
	<link rel="stylesheet" type="text/css" href="css/containeres.css">
	<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
</head>
<body>
<center>
	<div class="container_principal">
		<p>Pesquisa de Cliente</p>
		<br><br>

		<form method="POST" action="pesquisar_cliente_cod.php?nome_pagina=<?php echo $nome_pagina?>">
			<div class="row">
				<select class="col-25-pesquisa" name="pesquisa_cliente">
					<option value="nome">Nome</option>
					<option value="cod_cliente">Codigo do Cliente</option>
					<option value="cpf">CPF</option>
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
		</form>

	</div>


</body>
</html>