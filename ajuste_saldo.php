<?php
session_start();

include('conexao.php');

/*Preencher campo cod_cliente conforme retorno da página de pesquisa*/
$cod_produto = filter_input(INPUT_GET, 'cod_produto', FILTER_SANITIZE_NUMBER_INT);

$sql = "SELECT * FROM produtos p
LEFT JOIN estoque_produto ep on (p.cod_produto = ep.cod_produto)
WHERE p.cod_produto = $cod_produto";
$result = mysqli_query($conn, $sql);
$resultado_array = mysqli_fetch_array($result);


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ajuste de Saldo</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
		  integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon"/>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/estilo_cadastro_produto.css">
	<link rel="stylesheet" type="text/css" href="css/containeres.css">
</head>
<body>

<?php
include 'menu.php';
?>

<center>
	<div class="container_principal">
		<p>Ajuste de Saldo de Produtos</p><br>
			<?php echo mysqli_error($conn); ?>
		<form method="POST" action="processa_ajuste_saldo.php">
			<div class="row">
				<div class="col-25">
					<label for="fname">Código Produto: </label>
				</div>
				<div class="col-75">
					<input type="text" autofocus readonly required id="cod_produto" name="cod_produto"
						   value="<?php echo($cod_produto); ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="fname">Descrição do Produto: </label>
				</div>
				<div class="col-75">
					<input type="text" readonly required name="descricao" id="descricao"
						   value="<?php echo $resultado_array['descricao'];?>">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Quantidade atual: </label>
				</div>
				<div class="col-75">
					<input type="text" readonly required name="quantidade_atual" id="quantidade_atual"
						   value="<?php echo($resultado_array['estoque']); ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Quantidade após ajuste: <font color="red">*</font></label>
				</div>
				<div class="col-75">
					<input type="number" required name="quantidade" id="quantidade"
						   placeholder="">
				</div>
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
			<br><br>

			<div class="botoes_align">
				<input type="button" value="Limpar" onclick="limpar_campos()">
				<input type="submit" value="Ajustar">
			</div>
		</form>


	</div>

</center>


</body>

<script language="javascript">
	function limpar_campos() {
		document.getElementById('quantidade').value = "";
	}
</script>


</html>
