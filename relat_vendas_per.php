<?php
session_start();
include('conexao.php');

date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/yy');

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Vendas por Período</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
	integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
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
			<br>

			<form method="POST" action="relat_vendas_per_gerado.php">
				<div class="align_relatorio">
					<div class="row">
						<div class="col-15-right">
							<label for="lname">Perído de: <font color="red">*</font></label>
						</div>
						<div class="col-17">
							<input class="form-control" type="date" value="<?php echo date("Y-m-d"); ?>"
							id="data_inicial" name="data_inicial">
						</div>
						<div class="align_mob">
							<br>
						</div>
						<div class="col-15">
							<label for="lname">Até: <font color="red">*</font></label>
						</div>
						<div class="col-17">
							<input class="form-control" type="date" value="<?php echo date("Y-m-d"); ?>" id="data_final"
							name="data_final">
						</div>
					</div><br>

					<div class="align_check">
						<div class="row">
							<div class="checkbox">
								<label><b><input type="checkbox" id="somente_comanda" name="somente_comanda"
									value="checked">Listar somente vendas com comandas atreladas</b></label>
								</div>
							</div>
							<div class="row">
								<div class="checkbox">
									<label><b><input type="checkbox" id="somente_direta" name="somente_direta" value="checked">Listar
									somente vendas diretas</b></label>
								</div>
							</div>
						</div>
						<br><br>



						<div class="botoes_align">
							<input type="button" value="Limpar" onclick="limpar_campos()">
							<input type="submit" value="Pesquisar">
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
	function limpar_campos() {
		document.getElementById('data_inicial').value = "";
		document.getElementById('data_final').value = "";
		document.getElementById('somente_comanda').checked = false;
		document.getElementById('somente_direta').checked = false;
	}

</script>

</html>