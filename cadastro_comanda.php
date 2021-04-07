<?php
session_start();
include('conexao.php');


/*Select para apresentação do numero da comanda*/
$sql_comanda = "select id_comanda from carrinho_tmp order by id_comanda desc limit 1";
$result_comanda = mysqli_query($conn, $sql_comanda);
$resultado_comanda_ar = mysqli_fetch_array($result_comanda);
$num_comanda = $resultado_comanda_ar['id_comanda']+1;

/*Preencher campo cod_cliente conforme retorno da página de pesquisa*/
$cod_cliente = filter_input(INPUT_GET, 'cod_cliente', FILTER_SANITIZE_NUMBER_INT);

/*Select das mesas para preencher list*/
$result_mesas = "SELECT * FROM mesas where ativo = 'S'";
$resultado_mesas = mysqli_query($conn, $result_mesas);

//numero ultimo documento 
$sql_num_venda = "select documento from movimentacoes order by documento desc limit 1";
$num_venda_result = mysqli_query($conn, $sql_num_venda);
$num_venda_array = mysqli_fetch_array($num_venda_result);
$num_venda = $num_venda_array['documento'];

$nome_pagina = "cadastro_comanda";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cadastro de Comanda</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/estilo_cadastro_comanda.css">
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
		<p class="comanda_text">Cadastro de Comandas</p>
		<br>

		<form method="POST" action="cadastrar_comanda.php?nome_pagina=<?php echo $nome_pagina;?>">

			<div class="row">
				<div class="col-25">
					<label for="lname">Comanda: <font color="red">*</font></label>
				</div>
				<div class="col-75">
					<input type="text" required name="nume_comanda" id="nume_comanda"
						   onclick="alerta_alteracao();" value="<?php echo $num_comanda; ?>">
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
					<label for="lname">Selecione a mesa: <font color="red">*</font></label>
				</div>
				<select class="col-75" name="mesa" id="mesa">
					<option value=""></option>
					<?php
					while($rows = mysqli_fetch_assoc($resultado_mesas)){ ?>
						<option value="<?php echo $rows['numero_mesa']; ?>"><?php echo $rows['numero_mesa']; ?></option> <?php
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
				<input type="button" value="Limpar" onclick="limpar_campos();">
				<input type="submit" id="confirmar" onclick="valida_campos();" value="Cadastrar">
			</div>
			<br><br>
			<a href="comanda_aberto.php">Comandas em Aberto</a>
			<br>
	</div>
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

	function calcularlucro() {
		var preco_custo = parseInt(document.getElementById('preco_custo').value, 10);
		var preco_venda = parseInt(document.getElementById('preco_venda').value, 10);
		var markup = preco_venda - preco_custo;
		document.getElementById("markup").value = (preco_venda - preco_custo);
	}

	function limpar_campos() {
		document.getElementById('cod_cliente').value = "";
		document.getElementById('nume_comanda').value = "";
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

		var nume_comanda = document.getElementById('nume_comanda').value;
		var cod_cliente = document.getElementById('cod_cliente').value;
		var mesa = document.getElementById('mesa').value;
		
		if (!nume_comanda || !cod_cliente || !mesa){
			alert("Atenção!\nExistem campos obrigatórios que não estão devidamente preenchidos.");
			return false;
		} 
	}

	function alerta_alteracao(){
		alert("Atenção!!!\nAo alterar esta informação, a próxima operação será baseada na numeração alterada, por exemplo: Se a comanda está na faixa 10 e você altera para 50, consequentemente a próxima comanda será a 51.");
	}
</script>

</html>