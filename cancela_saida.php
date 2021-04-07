<?php
session_start();
include('conexao.php');

date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/yy');

/*Preencher campo cod_cliente conforme retorno da página de pesquisa*/
$cod_cliente = filter_input(INPUT_GET, 'cod_cliente', FILTER_SANITIZE_NUMBER_INT);

$nome_pagina = 'cancelar_saida';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cancelar Saída</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
	integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/estilo_cancela_saida.css">
	<link rel="stylesheet" type="text/css" href="css/containeres.css">
</head>

<body>

	<?php
	include_once 'menu.php';
	?>

	<center>
		<div class="container_principal">
			<p>Cancelar Saída</p>
			<br>

			<form method="POST" action="processa_cancela_saida.php">
				<div class="align_relatorio">
					<div class="row">
						<div class="col-25">
							<label for="lname">Perído de: <font color="red">*</font></label>
						</div>
						<div class="col-75">
							<input class="form-control" type="date" value="<?php echo date("Y-m-d"); ?>"
							id="data" required name="data">
						</div>
					</div>
					<div class="row">
						<div class="col-25">
							<label for="fname">Cliente: <font color="red">*</font></label>
						</div>
						<div class="col-8">
							<input type="text" required name="cod_cliente" autofocus id="cod_cliente"
							value="<?php echo($cod_cliente); ?>">
						</div>
						<div class="col-60">
							<input type="text" required disabled name="nome_cliente" id="nome_cliente">
						</div>
						<div class="logo_pesquisa">
							<a href="pesquisa_cliente_cod.php?nome_pagina=<?php echo $nome_pagina?>">
								<img src="fotos/ico_pesquisa.png" width=40 height=40>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-25">
							<label for="lname">Documento: <font color="red">*</font></label>
						</div>
						<div class="col-75">
							<input type="text" required name="documento" id="documento"
							placeholder="Informe o documento que desejas cancelar">
						</div>
					</div>
					<br><br>



					<div class="botoes_align">
						<input type="button" value="Limpar" onclick="limpar_campos()">
						<input type="submit" value="Cancelar" id="cancelar">
					</div>
					<br>
				</div>

			</form>


			<br><br>
		</div>
	</div>
</center>
</body>

<script language="javascript">
	$(document).ready(function () {
		$("input[name='cod_cliente']").blur(function () {
			var $nome_cliente = $("input[name='nome_cliente']");
			$.getJSON('retornar_campos.php', {
				cod_cliente: $(this).val()
			}, function (json) {
				$nome_cliente.val(json.nome_cliente);
			});
		});
	});
	function limpar_campos() {
		document.getElementById('data_inicial').value = "";
		document.getElementById('data_final').value = "";
		document.getElementById('somente_comanda').checked = false;
		document.getElementById('somente_direta').checked = false;
	}

	var cancelar = document.getElementById('cancelar');
	cancelar.onclick=function(){
		var nome_cl = document.getElementById('nome_cliente').value;
		if (nome_cl == 'Cliente não encontrado.'){
			alert ('O código de cliente informado não está cadastrado na base de dados.');
			return false;

			var r=confirm("Você deseja realmente cancelar o documento ?\nA operação não poderá ser desfeita!");
			if (r==true)
			{
				return true;
			}
			else
			{
				return false;
			}

		}
	}
	</script>

	</html>