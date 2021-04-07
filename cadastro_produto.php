<?php
session_start();

include('conexao.php');
$sql_cod_produto = "select cod_produto from produtos order by cod_produto desc limit 1";
$numero_cod_result = mysqli_query($conn, $sql_cod_produto);
$produto = mysqli_fetch_array($numero_cod_result);
$cod_produto = $produto['cod_produto'];

/*Select das linhas e marcas para preencher list*/
$sql_linhas = "SELECT * FROM produtos_linha where ativo = 'S'";
$resultado_linhas = mysqli_query($conn, $sql_linhas);

$sql_marcas = "SELECT * FROM produtos_marca where ativo = 'S'";
$resultado_marcas = mysqli_query($conn, $sql_marcas);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cadastro de Produto</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
		  integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/estilo_cadastro_produto.css">
	<link rel="stylesheet" type="text/css" href="css/containeres.css">
</head>
<body>

<?php
include 'menu.php';
?>

<center>
	<div class="container_principal">
		<p>Cadastro de Produtos</p><br>

		<form method="POST" action="cadastrar_produto.php">
			<div class="row">
				<div class="col-25">
					<label for="fname">Código Produto: </label>
				</div>
				<div class="col-75">
					<input type="number" required name="cod_produto" onclick="alerta_alteracao();" value="<?php echo($cod_produto + 1); ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="fname">Descrição do Produto: <font color="red">*</font></label>
				</div>
				<div class="col-75">
					<input type="text" required name="descricao" id="descricao"
						   placeholder="Informe a descrição do produto">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Selecione a Linha: <font color="red">*</font></label>
				</div>
				<select class="col-75" name="id_linha" id="id_linha">
					<option value="">Selecione a Linha</option>
					<?php
					while ($rows = mysqli_fetch_assoc($resultado_linhas)) { ?>
						<option
							value="<?php echo $rows['id_linha']; ?>"><?php echo $rows['descricao']; ?></option> <?php
					}
					?>
				</select>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Selecione a Marca: <font color="red">*</font></label>
				</div>
				<select class="col-75" name="id_marca" id="id_marca">
					<option value="">Selecione a Marca</option>
					<?php
					while ($rows = mysqli_fetch_assoc($resultado_marcas)) { ?>
						<option
							value="<?php echo $rows['id_marca']; ?>"><?php echo $rows['descricao']; ?></option> <?php
					}
					?>
				</select>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Código Interno: <font color="red">*</font></label>
				</div>
				<div class="col-75">
					<input type="text" name="cod_interno" id="cod_interno"
						   placeholder="Informe o código interno de controle">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Custo do Produto: <font color="red">*</font></label>
				</div>
				<div class="col-75">
					<input type="text" required onKeyPress="return(MascaraMoeda(this,'.',',',event))" id="preco_custo"
						   name="preco_custo" placeholder="Informe o custo do produto">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Preço de Venda: <font color="red">*</font></label>
				</div>
				<div class="col-75">
					<input type="text" required onblur="calcularlucro();"
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
					<label for="lname">Estoque: <font color="red">*</font></label>
				</div>
				<div class="col-75">
					<input type="number" required id="estoque" name="estoque" placeholder="Informe o estoque do seu produto" value="0">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Cadastro ativo: <font color="red">*</font></label>
				</div>
				<select class="col-75" name="ativo">
					<option value="S">Sim</option>
					<option value="N">Não</option>
				</select>
			</div>
			<br><br>

			<div class="botoes_align">
				<input type="button" value="Limpar" onclick="limpar_campos()">
				<input type="submit" id="cadastrar" value="Cadastrar">
			</div>
		</form>


	</div>

</center>


</body>

<script language="javascript">

	var cadastrar = document.getElementById('cadastrar');
	var desc_produto = document.getElementById('descricao');
	var linha = document.getElementById('id_linha');
	var marca = document.getElementById('id_marca');
	var estoque = document.getElementById('estoque');
	cadastrar.onclick = function(){
		if (descricao.value == '') {
			alert('Preencha o campo o campo descricao.');
			descricao.focus();
			return false;
		}
		else if (marca.value == '') {
			alert('Selecione o campo marca.');
			marca.focus();
			return false;
		}
		else if (linha.value == '') {
			alert('Selecione o campo linha.');
			linha.focus();
			return false;
		}
		if(estoque.value < 0){
    	    alert("O estoque não pode ser negativo!");
    	    estoque.focus();
    	    return false;
	    }
	}
	


	function alerta_alteracao(){
		alert("Atenção!!!\nAo alterar esta informação, a próxima operação será baseada na numeração alterada, por exemplo: Se o código do produto está na faixa 10 e você altera para 50, consequentemente o próximo código será o 51.");
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

	function calcularlucro() {

		var preco_custo = document.getElementById('preco_custo').value.replace(",", ".");
		var preco_venda = document.getElementById('preco_venda').value.replace(",", ".");
		var markup = preco_venda - preco_custo;
		document.getElementById("markup").value = markup.toFixed(2).replace(".", ",");
	}

	function validavazio(form) {
		{
			if (form.grupo.value.length < 1) {
				alert('Campo deve ser preenchido!');
				return false;
			}
			return true;
		}
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
