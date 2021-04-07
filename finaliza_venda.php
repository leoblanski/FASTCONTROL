<?php
include('conexao.php');

$nome_pagina = $_POST['nome_pagina'];

$subtotal = $_POST['subtotal_final'];
$desconto = $_POST['desconto'];
$total = $_POST['total'];

$id_comanda = $_POST['id_comanda'];
$cod_cliente = $_POST['cod_cliente'];
$identificador = $_POST['identificador'];
$num_venda = $_POST['num_venda'];


/*select planos de pagamento*/
$sql_planos = "select * from planos where ativo = 'S'";
$result_planos = mysqli_query($conn, $sql_planos);
$result_planos1 = mysqli_query($conn, $sql_planos);
$result_planos2 = mysqli_query($conn, $sql_planos);

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
	<title>Finalização Venda</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
	integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/containeres.css">
	<link rel="stylesheet" type="text/css" href="css/estilo_carrinho.css">
</head>
<body>
	<script type='text/javascript'></script>
	<?php
	include_once 'menu.php';
	?>
	<center>
		<div class="container_principal">
			<p>Finalização Venda</p>
			<br>

			<form method="POST"
			action="processa_finaliza_venda.php" onsubmit="return valida_faltante();">

			<input type="hidden" value="<?php echo $id_comanda; ?>" id="id_comanda" name="id_comanda">
			<input type="hidden" value="<?php echo $cod_cliente; ?>" id="cod_cliente" name="cod_cliente">
			<input type="hidden" value="<?php echo $identificador; ?>" id="identificador" name="identificador">
			<input type="hidden" value="<?php echo $num_venda; ?>" id="num_venda" name="num_venda">
			<input type="hidden" value="<?php echo $nome_pagina; ?>" id="nome_pagina" name="nome_pagina">

			<div class="totais">
				<p>Resumo Cliente</p>

				<div class="row">
					<div class="col-25">
						<label for="fname">Cliente: <font color="red">*</font></label>
					</div>
					<div class="col-60">
						<input type="text" required readonly name="cod_produto"
						value="<?php echo $cod_cliente . " - " . $resultado_cliente['nome']; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-25">
						<label for="fname">Número Venda: <font color="red">*</font></label>
					</div>
					<div class="col-60">
						<input type="text" required name="descricao" id="descricao"
						readonly value="<?php echo $num_venda; ?>">
					</div>
				</div>	
				<?php if ($nome_pagina != 'venda_direta'){?>
					<div class="row">
						<div class="col-25">
							<label for="fname">Número comanda: <font color="red">*</font></label>
						</div>
						<div class="col-60">
							<input type="text" required name="descricao" id="descricao"
							readonly value="<?php echo $id_comanda; ?>">
						</div>
					</div>
				<?php }?>
				<br><br>

				<div class="subtotais_valores_fin">
					<p>Totalizadores</p>

					<div class="row">
						<div class="col-25">
							<label for="fname">Subtotal: </label>
						</div>
						<div class="col-60">
							<input type="text" readonly onblur="totalizador()" value="<?php echo $subtotal; ?>"
							onKeyPress="return(MascaraMoeda(this,'.',',',event))" required name="subtotal"
							id="subtotal">
						</div>
					</div>
					<div class="row">
						<div class="col-25">
							<label for="fname">Desconto R$: </label>
						</div>
						<div class="col-60">
							<input type="text" onblur="totalizador()" value="<?php echo $desconto; ?>"
							onKeyPress="return(MascaraMoeda(this,'.',',',event))" required name="desconto"
							id="desconto">
						</div>
					</div>
					<div class="row">
						<div class="col-25">
							<label for="fname"><b>Total: </b></label>
						</div>
						<div class="col-60">
							<input type="text" readonly onblur="totalizador()" value="<?php echo $total; ?>"
							onKeyPress="return(MascaraMoeda(this,'.',',',event))" required name="total"
							id="total">
						</div>
					</div>
				</div>
				<br><br><br>

				<div class="selecao_cartoes">
					<p>Seleção de Plano de Pagamento</p>

					<div id="listagem_planos">
						<table id="tabela" class="table table-hover">
							<thead>
								<tr>
									<th scope="col"></th>
									<th scope="col">Plano de Pagamento</th>
									<th scope="col">Valor</th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
								<!-- Primeiro Plano de Pagamento (Totalmente errado, será melhorado posteriormente com a function -->
								<tr id="primeiro_plano">
									<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
									<td>
										<div class="col-70-fin">
											<select name="plano_pagamento1" id="plano_pagamento1">
												<option>Selecione o 1º plano</option>
												<?php
												while ($rows = mysqli_fetch_assoc($result_planos)) { ?>
													<option
													value="<?php echo $rows['cod_plano']; ?>"><?php echo $rows['cod_plano'] . " - " . $rows['descricao']; ?></option>
													<?php
												}
												?>
											</select>
										</div>
									</td>
									<td>
										<div class="col-40-fin">
											<input type="text" value="<?php echo $total; ?>"
											onKeyPress="return(MascaraMoeda(this,'.',',',event))"
											required
											name="total_plano1"
											id="total_plano1">
										</div>
									</td>
									<td>
										<div class="col-05-fin">
											<a href="#">
												<i class="fa fa-check" id="addplano"
												style="font-size:24px;color:#ff8d00"></i>
											</a>
										</td>
										<td>
											<a href="#">
												<i class="fa fa-close" id="excluirplano"
												style="font-size:24px;color:red;display: none; text-decoration: none;"></i>
											</a>
										</td>
									</div>

								</tr>
								<!-- Segundo plano de pagamento -->
								<tr id="segundo_plano">
									<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
									<td>
										<div class="col-70-fin">
											<select name="plano_pagamento2" id="plano_pagamento2">
												<option>Selecione o 2º plano</option>
												<?php
												while ($rows = mysqli_fetch_assoc($result_planos1)) { ?>
													<option
													value="<?php echo $rows['cod_plano']; ?>"><?php echo $rows['cod_plano'] . " - " . $rows['descricao']; ?></option>
													<?php
												}
												?>
											</select>
										</div>
									</td>
									<td>
										<div class="col-40-fin">
											<input type="text" onKeyPress="return(MascaraMoeda(this,'.',',',event))"
											required
											value="0,00"
											name="total_plano2" id="total_plano2">
										</div>
									</td>
									<td>
										<div class="col-05-fin">
											<a href="#">
												<i class="fa fa-check" id="addplano2"
												style="font-size:24px;color:#ff8d00"></i></a>
											</div>
										</td>
										<td>
											<a href="#">
												<i class="fa fa-close" id="excluirplano2"
												style="font-size:24px;color:red;display: none; hover: none;"></i>
											</a>
										</td>
									</tr>
									<!-- terceiro plano de pagamento -->
									<tr id="terceiro_plano">
										<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
										<td>
											<div class="col-70-fin">
												<select name="plano_pagamento3" id="plano_pagamento3">
													<option>Selecione o 3º plano</option>
													<?php
													while ($rows = mysqli_fetch_assoc($result_planos2)) { ?>
														<option
														value="<?php echo $rows['cod_plano']; ?>"><?php echo $rows['cod_plano'] . " - " . $rows['descricao']; ?></option>
														<?php
													}
													?>
												</select>
											</div>
										</td>
										<td>
											<div class="col-40-fin">
												<input type="text" onKeyPress="return(MascaraMoeda(this,'.',',',event))"
												required
												value="0,00"
												name="total_plano3" id="total_plano3">
											</div>
										</td>
										<td>
											<div class="col-05-fin">
												<a href="#">
													<i class="fa fa-check" id="addplano3"
													style="font-size:24px;color:#ff8d00"></i></a>
												</div>
											</td>
											<td>
												<a href="#">
													<i class="fa fa-close" id="excluirplano3"
													style="font-size:24px;color:red;display: none; text-decoration: none;"></i>
												</a>
											</td>
										</tr>
									</table>
								</div>
								<input type="hidden" id="salvar_plano" value="">
								<br><br>

								<div class="row">
									<div class="col-25">
										<label for="fname" id="trocacor"><b>Valor Faltante: </b></label>
									</div>
									<div class="col-60">
										<input type="text" onblur="totalizador();" value="<?php echo $total;?>"
										onKeyPress="return(MascaraMoeda(this,'.',',',event))" required name="faltante"
										id="faltante">
									</div>
								</div>
							</div>
						</div>
						<br><br><br>

						<div class="botoes_align_finaliza">
    						<a href="abortar_saida.php?cod_cliente=<?php echo $cod_cliente; ?>&identificador=<?php echo $identificador;?>&id_comanda=<?php echo $id_comanda; ?>">
    							<input type="button" id="abortar" value="Abortar">
    						</a>
							<input id="finalizar" type="submit" value="Finalizar Venda">
						</div>
						<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
					</div>
				</form>
				<script>
				
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

		var subtotal_final = document.getElementById('subtotal').value.replace(",", ".");
		var desconto_final = document.getElementById('desconto').value.replace(",", ".");
		var total_final = subtotal_final - desconto_final;


		function totalizador() {
			var plano_pagamento1 = document.getElementById('total_plano1').value.replace(",", ".");
			var plano_pagamento2 = document.getElementById('total_plano2').value.replace(",", ".");
			var plano_pagamento3 = document.getElementById('total_plano3').value.replace(",", ".");
			var valor_faltante = total_final - plano_pagamento1 - plano_pagamento2 - plano_pagamento3;

			document.getElementById('faltante').value = valor_faltante.toFixed(2).toString().replace(".", ",");

			/*Mudar a cor do input 'faltante' para verde caso seja igual a 0,00 e para vermelho caso o valor faltante seja > 0,00*/
			if (valor_faltante == '0') {
				document.getElementById("trocacor").style.color = "#06cc06";
			} else {
				document.getElementById("trocacor").style.color = "red";
			}
		}


		//Não permite o envio do form caso o valor faltante seja diferente de 0,00
		function valida_faltante() {
			var faltante = document.getElementById('faltante').value.replace(".", ",");
			if (faltante != '0,00') {
				alert("Verifique o valor total informado, ainda resta valor para finalização.");
				document.getElementById('total_plano1').focus();
				return false;

			}
			else {
				return true;
			}
		}

		//FUNÇAO ABAIXO SERÁ REFATURADA PARA MELHOARMENTO DO CÓDIGO.
		//declaração das variáveis conforme elementos da pagina.

		//select box
		var plano_pagamento1 = document.getElementById('plano_pagamento1');
		var plano_pagamento2 = document.getElementById('plano_pagamento2');
		var plano_pagamento3 = document.getElementById('plano_pagamento3');

		//inputs valores
		var inputplano1 = document.getElementById('total_plano1');
		var inputplano2 = document.getElementById('total_plano2');
		var inputplano3 = document.getElementById('total_plano3');

		//icones add
		var addplano1 = document.getElementById('addplano');
		var addplano2 = document.getElementById('addplano2');
		var addplano3 = document.getElementById('addplano3');

		//icones exclusão
		var excluirplano1 = document.getElementById('excluirplano');
		var excluirplano2 = document.getElementById('excluirplano2');
		var excluirplano3 = document.getElementById('excluirplano3');

		//elementos para mudar o display tr
		var primeiro_plano = document.getElementById('primeiro_plano');
		var segundo_plano = document.getElementById('segundo_plano');
		var terceiro_plano = document.getElementById('terceiro_plano');


		addplano1.onclick = function () {
			if (plano_pagamento1.value == 'Selecione o 1º plano') {
				alert('Selecione um plano de pagamento');
				return false;
			}
			else if(inputplano1.value == '0,00' || inputplano1.value == ''){
				alert('Informe o valor de pagamento para o plano selecionado');
				return false;
			}
			else {
				alert("Plano de pagamento adicionado com sucesso.");
				totalizador();
				addplano1.style.color = "rgb(6, 204, 6)";
				excluirplano1.style.display = "table-row";

				valida_faltante();
				var valor_faltante = document.getElementById('faltante').value;

				if (valor_faltante != '0,00') {
					terceiro_plano.style.display = "table-row";
					inputplano2.focus();
				}
				else {
					return true;
				}
			}
		}

		addplano2.onclick = function () {
			if (plano_pagamento2.value == 'Selecione o 2º plano') {
				alert('Selecione um plano de pagamento');
				return false;
			}
			else if(inputplano1.value == '0,00' || inputplano1.value == ''){
				alert('Informe o valor de pagamento para o plano selecionado');
				return false;
			}
			else {
				alert("Plano de pagamento adicionado com sucesso.");
				totalizador();
				addplano2.style.color = "rgb(6, 204, 6)";
				excluirplano2.style.display = "table-row";
				valida_faltante();
				var valor_faltante = document.getElementById('faltante').value;

				if (valor_faltante != '0,00') {
					terceiro_plano.style.display = "table-row";
					inputplano3.focus();
				}

				else {
					return true;
				}
			}
		}
		addplano3.onclick = function () {
			if (plano_pagamento3.value == 'Selecione o 3º plano') {
				alert('Selecione um plano de pagamento');
				return false;
			}
			else if(inputplano1.value == '0,00' || inputplano1.value == ''){
				alert('Informe o valor de pagamento para o plano selecionado');
				return false;
			}
			else {
				alert("Plano de pagamento adicionado com sucesso.");
				totalizador();
				addplano3.style.color = "rgb(6, 204, 6)";
				excluirplano3.style.display = "table-row";
				valida_faltante();
				var valor_faltante = document.getElementById('faltante').value;

				if (valor_faltante != '0,00') {

				}
				else {
					return true;
				}
			}
		}

		// exclusão dos planos
		excluirplano1.onclick = function () {
			alert("Plano de pagamento removido com sucesso!");
			inputplano1.value = '0,00';
			plano_pagamento1.value = 'Selecione o 1º plano';
			addplano1.style.color = '#ff8d00';
			excluirplano1.style.display = 'none';
			totalizador();
		}
		excluirplano2.onclick = function () {
			alert("Plano de pagamento removido com sucesso!");
			inputplano2.value = '0,00';
			plano_pagamento2.value = 'Selecione o 2º plano';
			addplano2.style.color = '#ff8d00';
			excluirplano2.style.display = 'none';
			totalizador();
		}
		excluirplano3.onclick = function () {
			alert("Plano de pagamento removido com sucesso!");
			inputplano3.value = '0,00';
			plano_pagamento3.value = 'Selecione o 3º plano';
			addplano3.style.color = '#ff8d00';
			excluirplano3.style.display = 'none';
			totalizador();
		}


	</script>
</tbody>
</div>
</center>
</html>