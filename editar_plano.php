<?php
session_start();
include('conexao.php');

$cod_plano = filter_input(INPUT_GET, 'cod_plano', FILTER_SANITIZE_NUMBER_INT);

$sql = "select * from planos";
$result = mysqli_query($conn, $sql);


$sql_array = "select * from planos where cod_plano = $cod_plano";
$result_array = mysqli_query($conn, $sql_array);
$result_array = mysqli_fetch_array($result_array);

$deb_cred = $result_array['credito_debito'];
$forma_pagamento = $result_array['forma_pagamento'];
$parcelas = $result_array['parcelas'];
$ativo = $result_array['ativo'];

function selected($value, $selected)
{
	return $value == $selected ? ' selected="selected"' : '';
}

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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
		  integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/estilo_cadastro_plano.css">
	<link rel="stylesheet" type="text/css" href="css/containeres.css">
	<script type="text/javascript" src="js/modal_js.js"></script>
</head>

<body onload="verifica_divs();">

<script type='text/javascript'>
</script>
<?php
include_once 'menu.php';
?>

<center>
	<div class="container_principal">
		<p>Cadastro de Planos de Pagamento</p>
		<br>

		<form method="POST" action="processa_editar_plano.php">

			<div class="row">
				<div class="col-25">
					<label for="lname">Código: <font color="red">*</font></label>
				</div>
				<div class="col-70">
					<input type="number" readonly required name="cod_plano" id="cod_plano"
						   value="<?php echo $result_array['cod_plano']; ?>">
				</div>
			</div>

			<div class="row">
				<div class="col-25">
					<label for="lname">Descrição: <font color="red">*</font></label>
				</div>
				<div class="col-70">
					<input type="text" name="descricao" required id="descricao"
						   value="<?php echo $result_array['descricao']; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Forma de Pagamento: <font color="red">*</font></label>
				</div>
				<select class="col-70" id="forma_pagamento" name="forma_pagamento" required>
					<option value="dinheiro"<?php echo selected('dinheiro', $forma_pagamento); ?>>Dinheiro</option>
					<option value="cartao"<?php echo selected('cartao', $forma_pagamento); ?>>Cartão</option>
				</select>
			</div>
			<div id="cartao" style="display: none;">
				<div class="row">
					<div class="col-25">
						<label for="lname">Débito ou Crédito: <font color="red">*</font></label>
					</div>
					<select class="col-70" name="deb_cred" id="deb_cred">
						<option value="debito"<?php echo selected('debito', $deb_cred); ?>>Débito</option>
						<option value="credito"<?php echo selected('credito', $deb_cred); ?>>Crédito</option>
					</select>
				</div>
			</div>
			<div id="parcelas" style="display: none;">
				<div class="row">
					<div class="col-25">
						<label for="lname">Parcelas: <font color="red">*</font></label>
					</div>
					<select class="col-70" name="parcelas" id="parcelas">
						<option value="1"<?php echo selected('1', $parcelas); ?>>1</option>
						<option value="2"<?php echo selected('2', $parcelas); ?>>2</option>
						<option value="3"<?php echo selected('3', $parcelas); ?>>3</option>
						<option value="4"<?php echo selected('4', $parcelas); ?>>4</option>
						<option value="5"<?php echo selected('5', $parcelas); ?>>5</option>
						<option value="6"<?php echo selected('6', $parcelas); ?>>6</option>
						<option value="7"<?php echo selected('7', $parcelas); ?>>7</option>
						<option value="8"<?php echo selected('8', $parcelas); ?>>8</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Ativo: <font color="red">*</font></label>
				</div>
				<select class="col-70" name="ativo" required>
					<option value="S" <?php echo selected('S', $ativo); ?>>Sim</option>
					<option value="N" <?php echo selected('N', $ativo); ?>>Não</option>
				</select>
			</div>

			<br>

			<div class="botoes_align">
				<input type="button" value="Limpar" onclick="limpar_campos()">
				<input type="submit" value="Salvar">
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
						<td><?php if ($rows['forma_pagamento'] == "dinheiro") {
								echo "Dinheiro";
							} else {
								echo "Cartão";
							} ?>

						</td>
						<td><?php if ($rows['credito_debito'] == "debito") {
								echo "Débito";
							} elseif ($rows['credito_debito'] == "credito") {
								echo "Crédito";
							} else {
								echo "-";
							} ?>

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

	//mudar as divs para block caso o retorno seja positivo, vai executar com evento onload no body
	function verifica_divs() {
		var forma_pagamento_ = document.getElementById('forma_pagamento').value;
		var deb_cred = document.getElementById('deb_cred').value;
		if (forma_pagamento_ = 'cartao')
		{
			if (deb_cred == 'credito')
			{
				document.getElementById("cartao").style.display = "block";
				document.getElementById("parcelas").style.display = "block";
			}
			else if (deb_cred == 'debito')
			{
				document.getElementById("cartao").style.display = "block";
				document.getElementById("parcelas").style.display = "none";
			}

		}
	}
	//Jquery para mostrar conforme seleção
	jQuery("#forma_pagamento").change(function () {
		var selecao_forma = jQuery(this).val();

		if (selecao_forma == 'cartao') {
			$("#cartao").show();
		}
		else {
			$("#parcelas").hide();
			$("#cartao").hide();
		}

	});
	jQuery("#deb_cred").change(function () {
		var selecao_vezes = jQuery(this).val();

		if (selecao_vezes == 'credito') {
			$("#parcelas").show();
		}
		else if (selecao_vezes == 'debito') {
			$("#parcelas").hide();
		}
		else {
			$("#parcelas").hide();
			$("#cartao").hide();
		}

	});


</script>

</html>