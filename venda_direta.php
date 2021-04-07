<?php
session_start();
include('conexao.php');

$sql_num_venda = "select documento from movimentacoes order by documento desc limit 1";
$num_venda_result = mysqli_query($conn, $sql_num_venda);
$num_venda_array = mysqli_fetch_array($num_venda_result);
$num_venda = $num_venda_array['documento'];

$sql_tipo_venda = "SELECT * FROM tipo_venda";
$sql_result_tipo = mysqli_query($conn,$sql_tipo_venda);

/*Preencher campo cod_cliente conforme retorno da página de pesquisa*/
$cod_cliente = filter_input(INPUT_GET, 'cod_cliente', FILTER_SANITIZE_NUMBER_INT);

//busca comanda para validar as próximas paginas
/*Select para apresentação do numero da comanda*/
$sql_comanda = "select id_comanda from carrinho_tmp order by id_comanda desc limit 1";
$result_comanda = mysqli_query($conn, $sql_comanda);
$resultado_comanda_ar = mysqli_fetch_array($result_comanda);
$id_comanda = $resultado_comanda_ar['id_comanda']+1;

$nome_pagina = "venda_direta";




?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Venda Direta</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
		  integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/estilo_venda_direta.css">
	<link rel="stylesheet" type="text/css" href="css/containeres.css">
</head>

<body>

<script type='text/javascript'>
</script>
<?php
include_once 'menu.php';
?>

<center>
	<div class="container_principal">
		<p class="comanda_text">Venda Direta</p>

		<br>

		<form method="POST" action="carrinho.php?nome_pagina=<?php echo $nome_pagina;?>">
			<!--
			<div class="row">
				<div class="col-25">
					<label for="lname">Número Venda: <font color="red">*</font></label>
				</div>
				<div class="col-75">
					<input type="text" required name="num_venda" id="num_venda" 
					onclick="alerta_alteracao();" value="<?php echo($num_venda + 1); ?>">
				</div>
			</div>
		-->
			<div class="row">
				<div class="col-25">
					<label for="fname">Cliente: <font color="red">*</font></label>
				</div>
				<div class="col-8">
					<input type="number" required name="cod_cliente" autofocus id="cod_cliente"
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
					<label for="lname">Operação de venda: </label>
				</div>
				<select class="col-75" name="tipo_venda" id="tipo_venda">
				<?php
					while($rows = mysqli_fetch_assoc($sql_result_tipo)){ ?>
						<option value="<?php echo $rows['id_tipo_venda']; ?>"><?php echo $rows['desc_tipo_venda']; ?></option> <?php
					}
					?>
				</select>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Observação:
						<label>
				</div>
				<div class="observacao">
					<input type="text" name="obs" id="obs" placeholder="Informe a observação desejada">
				</div>
			</div>
			<br>
			<br>

			<div class="botoes_align">
				<input type="button" value="Limpar" onclick="limpar_campos()">
				<input type="submit" id="confirmar" value="Prosseguir">
			</div>
			<br><br>
	</div>

	<input type="hidden" id="nome_pagina" name="nome_pagina" value="<?php echo $nome_pagina?>">
	<input type="hidden" id="id_comanda" name="id_comanda" value="<?php echo $id_comanda?>">
	</form>

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
		document.getElementById('cod_cliente').value = "";
		document.getElementById('nome_cliente').value = "";
		document.getElementById('obs').value = "";
	}

	var confirmar = document.getElementById('confirmar');

	confirmar.onclick=function(){
		var nome_cl = document.getElementById('nome_cliente').value;
		if (nome_cl == 'Cliente não encontrado.'){
			alert ('O código de cliente informado não está cadastrado na base de dados.');
			return false;
		}
	}

	function alerta_alteracao(){
		alert("Atenção!!!\nAo alterar esta informação, a próxima operação será baseada na numeração alterada, por exemplo: Se a venda está na faixa 10 e você altera para 50, consequentemente a próxima venda será a 51.");
	}
</script>

</html>