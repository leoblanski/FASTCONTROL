<?php
session_start();

include('conexao.php');


$cod_produto = filter_input(INPUT_GET, 'cod_produto', FILTER_SANITIZE_NUMBER_INT);
$result_produto = "SELECT DISTINCT p.cod_produto, p.descricao, p.id_linha, p.id_marca, p.cod_interno, p.preco_custo, p.preco_venda, p.ativo FROM produtos p
LEFT JOIN produtos_marca pm ON (pm.id_marca = p.id_marca)
LEFT JOIN produtos_linha pl ON (pl.id_linha = p.id_linha)
WHERE p.cod_produto = '$cod_produto'";
$resultado_produto = mysqli_query($conn, $result_produto);
$row_produto = mysqli_fetch_assoc($resultado_produto);

//Alimentando as variaveis abaixo para preenchimento do select box
$ativo = $row_produto['ativo'];
$id_linha = $row_produto['id_linha'];
$id_marca = $row_produto['id_marca'];

/*Select das linhas e marcas para preencher list*/
$sql_linhas = "SELECT * FROM produtos_linha where ativo = 'S'";
$resultado_linhas = mysqli_query($conn, $sql_linhas);

$sql_marcas = "SELECT * FROM produtos_marca where ativo = 'S'";
$resultado_marcas = mysqli_query($conn, $sql_marcas);


function selected($value, $selected){
	return $value==$selected ? ' selected="selected"' : '';
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edição de Produto</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
		  integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/estilo_cadastro_produto.css">
	<link rel="stylesheet" type="text/css" href="css/containeres.css">
</head>
<body onload="calcularlucro();">

<?php
include 'menu.php';
?>

<center>
	<div class="container_principal">
		<p>Edição de Produtos</p><br>

		<form method="POST" action="processa_editar_produtos.php">
			<div class="row">
				<div class="col-25">
					<label for="fname">Código Produto: </label>
				</div>
				<div class="col-75">
					<input type="text" required readonly name="cod_produto" value="<?php echo($cod_produto); ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="fname">Descrição do Produto: <font color="red">*</font></label>
				</div>
				<div class="col-75">
					<input type="text" required name="descricao" id="descricao"
						   value="<?php echo $row_produto['descricao']; ?> ">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Selecione a Linha: <font color="red">*</font></label>
				</div>
				<select class="col-75" name="id_linha" id="id_linha">
					<?php
					while ($rows = mysqli_fetch_assoc($resultado_linhas)) { ?>
						<option	value="<?php echo $rows['id_linha']; ?>"<?php echo selected($rows['id_linha'], $id_linha);?>"><?php echo $rows['descricao']; ?> </option>
					<?php } ?>
				</select>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Selecione a Marca: <font color="red">*</font></label>
				</div>
				<select class="col-75" name="id_marca" id="id_marca">
					<?php
					while ($rows = mysqli_fetch_assoc($resultado_marcas)) { ?>
						<option	value="<?php echo $rows['id_marca']; ?>"<?php echo selected($rows['id_marca'], $id_marca);?>"><?php echo $rows['descricao']; ?> </option>
					<?php } ?>

				</select>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Código Interno: <font color="red">*</font></label>
				</div>
				<div class="col-75">
					<input type="text" name="cod_interno" id="cod_interno"
						   value="<?php echo $row_produto['cod_interno']; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Custo do Produto: <font color="red">*</font></label>
				</div>
				<div class="col-75">
					<input type="text" value="<?php echo str_replace('.', ',', $row_produto['preco_custo']); ?>" required
						   onKeyPress="return(MascaraMoeda(this,'.',',',event))" id="preco_custo" name="preco_custo"
						   placeholder="Informe o custo do produto">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Preço de Venda: <font color="red">*</font></label>
				</div>
				<div class="col-75">
					<input type="text" required value="<?php echo str_replace('.', ',', $row_produto['preco_venda']); ?>"
						   onblur="calcularlucro();" onload="calcularlucro();"
						   onKeyPress="return(MascaraMoeda(this,'.',',',event))" id="preco_venda" name="preco_venda"
						   placeholder="Informe preço de venda do produto">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Lucro em R$: <font color="red"></font></label>
				</div>
				<div class="col-75">
					<input type="text" onKeyPress="return(MascaraMoeda(this,'.',',',event))" disabled id="markup"
						   name="markup" placeholder="Lucro do seu produto">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Cadastro ativo: <font color="red">*</font></label>
				</div>
				<select class="col-75" name="ativo">
					<option value="S"<?php echo selected('S', $ativo);?>">Sim</option>
					<option value="N"<?php echo selected('N', $ativo);?>">Não</option>
				</select>
			</div>


			<br><br>

			<div class="botoes_align">
				<input type="button" value="Limpar" onclick="limpar_campos()">
				<input type="submit" value="Editar">
			</div>
		</form>


	</div>

</center>


</body>

<script language="javascript">
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

		var preco_custo = document.getElementById('preco_custo').value.replace(",", ".");
		var preco_venda = document.getElementById('preco_venda').value.replace(",", ".");
		var markup = preco_venda - preco_custo;
		document.getElementById("markup").value = markup.toFixed(2).replace(".", ",");
	}

	function limpar_campos() {
		document.getElementById('descricao').value = "";
		document.getElementById('cod_interno').value = "";
		document.getElementById('markup').value = "";
		document.getElementById('preco_venda').value = "";
		document.getElementById('preco_custo').value = "";
		document.getElementById('estoque').value = "";
	}

</script>


</html>
