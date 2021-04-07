<?php
session_start();
include('conexao.php');

$sql = "select * from planos where ativo = 'S'";
$result = mysqli_query($conn, $sql);

$sql_plano = "SELECT cod_plano FROM planos ORDER BY cod_plano DESC LIMIT 1";
$cod_plano_sql = mysqli_query($conn, $sql_plano);
$cod_plano_array = mysqli_fetch_array($cod_plano_sql);



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cadastro de Planos de Pagamento</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/estilo_cadastro_plano.css">
	<link rel="stylesheet" type="text/css" href="css/containeres.css">
	<script type="text/javascript" src="js/modal_js.js"></script>
</head>

<body>

<?php
include_once 'menu.php';
?>

<center>
	<div class="container_principal">
		<p>Cadastro de Planos de Pagamento</p>
		<br>

		<form method="POST" action="cadastrar_plano.php">

			<div class="row">
				<div class="col-25">
					<label for="lname">Código: <font color="red">*</font></label>
				</div>
				<div class="col-70">
					<input type="number" required name="cod_plano" id="cod_plano"
						   value="<?php echo $cod_plano_array['cod_plano'] + 1;?>">
				</div>
			</div>

			<div class="row">
				<div class="col-25">
					<label for="lname">Descrição: <font color="red">*</font></label>
				</div>
				<div class="col-70">
					<input type="text" name="descricao" required id="descricao" value="">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Forma de Pagamento: <font color="red">*</font></label>
				</div>
				<select class="col-70" id="forma_pagamento" name="forma_pagamento" required>
					<option value="">Selecione a forma de pagamento</option>
					<option value="dinheiro">Dinheiro</option>
					<option value="cartao">Cartão</option>
				</select>
			</div>
			<div id="cartao" style="display: none;">
				<div class="row">
					<div class="col-25">
						<label for="lname">Débito ou Crédito: <font color="red">*</font></label>
					</div>
					<select class="col-70" name="deb_cred" id="deb_cred">
						<option value="">Selecione se o plano de pagamento é débito ou crédito</option>
						<option value="debito">Débito</option>
						<option value="credito">Crédito</option>
					</select>
				</div>
			</div>
			<div id="credito" style="display: none;">
				<div class="row">
					<div class="col-25">
						<label for="lname">Parcelas: <font color="red">*</font></label>
					</div>
					<select class="col-70" name="parcelas" id="parcelas">
						<option value="">Selecione a quantidade de parcelas</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Ativo: <font color="red">*</font></label>
				</div>
				<select class="col-70" name="ativo" required>
					<option value="S">Sim</option>
					<option value="N">Não</option>
				</select>
			</div>

			<br>

			<div class="botoes_align">
				<input type="button" value="Limpar" onclick="limpar_campos()">
				<input type="submit" value="Cadastrar">
			</div>
			<br><br>


		</form>
		<div class="exibe_registros">
			<button id="exibe_registros" onclick="exibir();">Exibir Registros</button>
			<br>
		</div>
		<br><br><br>

		<div id="exibir_registros" style="display: none;">
			<p>Listagem de Planos de Pagamento</p>
			<br>
			<table id="tabela" class="table table-hover">
				<thead>
				<tr>
					<th scope="col">Código</th>
					<th scope="col">Descrição</th>
					<th scope="col">Forma de Pagamento</th>
					<th scope="col">Débito/Crédito</th>
					<th scope="col">Parcelas</th>
					<th scope="col">Ativo</th>
					<th scope="col"></th>
				</tr>
				</thead>
				<tbody>
				<?php
					while ($rows = mysqli_fetch_array($result)) {
						?>
						<tr>
						<td><b><?php echo $rows['cod_plano']; ?></b></td>
						<td><?php echo $rows['descricao']; ?></td>
						<td><?php if ($rows['forma_pagamento'] == "dinheiro"){
								echo "Dinheiro";
							}else{
								echo "Cartão";
							}?>

							</td>
						<td><?php if ($rows['credito_debito'] == "debito") {
								echo "Débito";
							} elseif ($rows['credito_debito'] == "credito") {
								echo "Crédito";
							} else {
								echo "-";
							}?>

							<td><?php if ($rows['parcelas'] == "") {
								echo "-";
							} else {
								echo $rows['parcelas'];
							}
								?></td>
						<td><b><?php
								if ($rows['ativo'] == 'S') {
									echo "Sim";
								}
								if ($rows['ativo'] == 'N') {
									echo "Não";
								} ?>
							</b>
						<td>
						<td>
							<a href="editar_plano.php?cod_plano=<?php echo $rows['cod_plano']; ?>">
								<i class="fa fa-edit" style="font-size:24px;color:green"></i></a> &nbsp;&nbsp;
						</td>
					</tr>
						<?php
					}
					mysqli_close($conn);
					?>
				</tbody>
			</table>
			<br><br><br>
		</div>
	</div>
</center>
</body>

<script language="javascript">
	function limpar_campos() {
		document.getElementById('descricao').value = "";
		document.getElementById('forma_pagamento').value = "";
		document.getElementById('deb_cred').value = "";
		document.getElementById('parcelas').value = "";
	}

	function exibir() {
		document.getElementById("exibir_registros").style.display = "block";
	}

	//Jquery para mostrar conforme seleção
	jQuery("#forma_pagamento").change(function () {
		var selecao_forma = jQuery(this).val();

		if (selecao_forma == 'cartao') {
			$("#cartao").show();
		}
		else {
			$("#credito").hide();
			$("#cartao").hide();
		}

	});
	jQuery("#deb_cred").change(function () {
		var selecao_vezes = jQuery(this).val();

		if (selecao_vezes == 'credito') {
			$("#credito").show();
		}
		else if (selecao_vezes == 'debito')
		{
			$("#credito").hide();
		}
		else
		{
			$("#credito").hide();
			$("#cartao").hide();
		}

	});


</script>

</html>