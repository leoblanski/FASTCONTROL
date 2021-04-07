<?php

include('conexao.php');

//Pegar numeração da venda

$sql_num_venda = "select documento from movimentacoes order by documento desc limit 1";
$num_venda_result = mysqli_query($conn, $sql_num_venda);
$num_venda_array = mysqli_fetch_array($num_venda_result);
$num_venda = $num_venda_array['documento'] + 1;

if ($_GET['nome_pagina']){
	$nome_pagina = $_GET['nome_pagina'];
}
else{
	$nome_pagina = $_POST['nome_pagina'];
}

if ($_GET['cod_cliente']){
	$cod_cliente= $_GET['cod_cliente'];
}
else{
	$cod_cliente = $_POST['cod_cliente'];
}

if ($_GET['num_venda']){
	$numero_venda= $_GET['num_venda'];
}
else{
	$numero_venda = $_POST['num_venda'];
}

if ($_GET['id_comanda']){
	$id_comanda = $_GET['id_comanda'];
}
else{
	$id_comanda = $_POST['id_comanda'];
}

if ($_GET['tipo_venda']){
	$tipo_venda = $_GET['tipo_venda'];
}
else{
	$tipo_venda = $_POST['tipo_venda'];
}

$numero_venda = $numero_venda;

$sql = "SELECT * FROM carrinho_tmp ct 
LEFT JOIN produtos p ON (p.cod_produto = ct.cod_produto)
WHERE id_comanda = '$id_comanda'";


//guardar identificador
$identificador = "SELECT identificador FROM carrinho_tmp WHERE id_comanda = $id_comanda";
$result_identificador = mysqli_query($conn, $identificador);
$array_id = mysqli_fetch_array($result_identificador);
$identificador = $array_id['identificador'];

$result = mysqli_query($conn, $sql);
/*Contar numero de linhas para apresentara em label quantidade de produtos no carrinho*/
$qtd_linhas = mysqli_num_rows($result);

/*Select para apresentação do nome do cliente no resumo*/
$sql_cliente = "select nome, cod_cliente from clientes where cod_cliente = $cod_cliente";
$result_cliente = mysqli_query($conn, $sql_cliente);
$resultado_cliente = mysqli_fetch_array($result_cliente);






?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Carrinho</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
	integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/containeres.css">
	<link rel="stylesheet" type="text/css" href="css/estilo_carrinho.css">
</head>

<body onload="totalizador()">

	<script type='text/javascript'>
	</script>
	<?php
	include_once 'menu.php';
	?>

	<center>
		<div class="container_principal">
			<p>Carrinho</p>
			<!-- Dados cliente e numeração comanda -->
			<div class="dados_iniciais">
				<label>
					<b>Cliente: </b><?php echo $cod_cliente . " - " . $resultado_cliente['nome']; ?><br>
					<?php if ($nome_pagina != 'venda_direta'){?>
						<b>Comanda: </b><?php echo $id_comanda; ?><br>
					<?php }?>
					<b>Número Venda: </b><?php echo $num_venda; ?>
				</label>
			</div>

			<!-- incluir itens para tela grande-->
			<div class="incluir_itens">
				<a href="pesquisar_produto_cod.php?id_comanda=<?php echo $id_comanda; ?>&cod_cliente=<?php echo $cod_cliente; ?>&nome_pagina=<?php echo $nome_pagina; ?>&tipo_venda=<?php echo $tipo_venda?>">
					<p>Incluir Itens</p>
				</a>

			</div>
			<!-- incluir itens mobile -->

			<div class="incluir_itens_mobile">
				<a href="pesquisar_produto_cod.php?id_comanda=<?php echo $id_comanda; ?>&cod_cliente=<?php echo $cod_cliente; ?>&nome_pagina=<?php echo $nome_pagina; ?>&tipo_venda=<?php echo $tipo_venda?>">
					<i class="fa fa-plus" style="font-size:37px;color:green"></i>
				</a>

			</div>

			<br>

			<form method="POST"	action="finaliza_venda.php">

			<input type="hidden" value="<?php echo $id_comanda; ?>" id="id_comanda" name="id_comanda">
			<input type="hidden" value="<?php echo $cod_cliente; ?>" id="cod_cliente" name="cod_cliente">
			<input type="hidden" value="<?php echo $identificador; ?>" id="identificador" name="identificador">
			<input type="hidden" value="<?php echo $num_venda; ?>" id="num_venda" name="num_venda">
			<input type="hidden" value="<?php echo $nome_pagina; ?>" id="nome_pagina" name="nome_pagina">
			<input type="hidden" value="<?php echo $tipo_venda; ?>" id="tipo_venda" name="tipo_venda">


			<div class="itens_carrinho">
				<table id="tabela" class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Código</th>
							<th scope="col">Descrição</th>
							<th scope="col">Quantidade</th>
							<th scope="col">Valor Unitário</th>
							<th scope="col">Valor Total</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>

						<?php
						$controle = 0;

					while ($rows = mysqli_fetch_array($result)) { //esse while aqui que roda enquanto houver registro no banco

						?>

						<tr>
							<td>
								<b><?php echo $rows['cod_produto']; ?></b>
							</td>
							<td>
								<?php echo $rows['descricao']; ?>
							</td>
							<td>
								<div class="col-30">
									<input type="text" required name="quantidade<?php echo $controle++; ?>"
									id="quantidade<?php echo $controle++; ?>"
									value="<?php echo $rows['quantidade']; ?>" readonly>
								</div>

							</td>
							<td>
								<div class="col-50">
									<input type="text" required onKeyPress="return(MascaraMoeda(this,'.',',',event))"
									name="val_unitario<?php echo $controle++; ?>"
									id="val_unitario<?php echo $controle++; ?>"
									value="<?php echo str_replace('.', ',', $rows['val_unitario']); ?>">
								</div>

							</td>
							<td>
								<div class="col-50">
									<input type="text" onKeyPress="return(MascaraMoeda(this,'.',',',event))" required
									name="subtotal<?php echo $controle++; ?>" readonly="readonly"
									id="subtotal<?php echo $controle++; ?>" value="">
								</div>
							</td>
							<td>
								<div class="col-5">
									<a href="exclusao_item_carrinho.php?cod_cliente=<?php echo $cod_cliente; ?>&id_carrinho=<?php echo $rows['id_carrinho']; ?>&id_comanda=<?php echo $id_comanda; ?>&cod_produto=<?php echo $rows['cod_produto']; ?>&nome_pagina=<?php echo $nome_pagina; ?>">
										<i class="fa fa-close" style="font-size:25px;color:red"></i>
									</a>
								</div>
							</td>

						</tr>
						<?php

					}
					mysqli_close($conn);
					?>
				</table>
			</div>
			<!-- Totais -->
			<br><br>

			<div class="qtd_produtos">

				<b>
					<label>Qtd Produtos:</label>
					<input type="text" id="qtd_linhas" style="border:none; background-color: #ededed; width:5%; font-size:12px;" disabled
					value="<?php echo $qtd_linhas; ?>"></b>
				</div>
				<div class="subtotais_valores">
					<div class="row">
						<div class="col-25-sub">
							<label>Subtotal: </label>
						</div>
						<div class="col-50-sub">
							<input type="text" required name="subtotal_final" id="subtotal_final">
						</div>
					</div>
					<div class="row">
						<div class="col-25-sub">
							<label>Desconto R$: </label>
						</div>
						<div class="col-50-sub">
							<input type="text" onblur="totalizador()" value="0,00"
							onKeyPress="return(MascaraMoeda(this,'.',',',event))" required name="desconto"
							id="desconto">
						</div>
					</div>
					<br>

					<div class="row">
						<div class="col-25-tot">
							<label><b>Total: </b></label>
						</div>
						<div class="col-50-tot">
							<input type="text" required name="total" id="total">
						</div>
					</div>
					<br>

					<div class="botoes_align">
						<a href="abortar_saida.php?cod_cliente=<?php echo $cod_cliente; ?>&identificador=<?php echo $identificador;?>&id_comanda=<?php echo $id_comanda; ?>">
							<input type="button" id="abortar" value="Abortar">
						</a>
						<input id="finalizar" type="submit" value="Finalizar Venda">
					</div>

				</div>
			</form>
			<script>
				var prices = document.querySelectorAll("[id^=val_unitario]");
				var ammounts = document.querySelectorAll("[id^=quantidade]");
				var subTotals = document.querySelectorAll("[id^=subtotal]");


				function totalizador() {
					var desconto = document.getElementById('desconto').value.replace(",", ".");
					var total = 0;
					var sub_total_final = 0;
					Array.prototype.forEach.call(prices, function (price, index) {
						var subTotal = (parseFloat(price.value.replace(",", ".")) || 0) * (parseFloat(ammounts[index].value) || 0);

						subTotals[index].value = subTotal.toFixed(2).replace(".", ",");
						sub_total_final += subTotal;
						total = sub_total_final - desconto;
					})

					document.getElementById('subtotal_final').value = sub_total_final.toFixed(2).replace(".", ",");
					document.getElementById('total').value = total.toFixed(2).replace(".", ",");
					;
				}
				Array.prototype.forEach.call(prices, function (input) {
					input.addEventListener("keyup", totalizador, false);
				});

				Array.prototype.forEach.call(ammounts, function (input) {
					input.addEventListener("keyup", totalizador, false);
				});

				totalizador();

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


			//Valida se o carrinho está vazio
			finalizar.onclick = function () {
				var finalizar = document.getElementById('finalizar');
				var qtd = document.getElementById('qtd_linhas').value;
				if (qtd == '0'){
					alert('O carrinho está vazio, para finaliza-lo inclua os produtos e posteriormente tente novamente.');
					return false;
				}
			}

		var abortar = document.getElementById('abortar');
         
        abortar.onclick = function(){
        var r=confirm("Você deseja realmente abortar a venda ?\nA operação não poderá ser desfeita!");
          if (r==true)
          {
            return true;
          }
          else
          {
            return false;
          }
        }

		</script>

	</tbody>

</div>
</center>

</html>