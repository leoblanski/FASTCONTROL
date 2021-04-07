<?php
session_start();
include('conexao.php');

$id_linha = filter_input(INPUT_GET, 'id_linha', FILTER_SANITIZE_NUMBER_INT);

$sql_linha = "SELECT * FROM produtos_linha";
$result_linha = mysqli_query($conn, $sql_linha);


$sql = "SELECT * FROM produtos_linha WHERE id_linha = $id_linha";
$result = mysqli_query($conn, $sql);
$result_array =mysqli_fetch_array($result);

$ativo = $result_array['ativo'];

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
	<title>Cadastro de Linha</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
		  integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/estilo_cadastro_linha.css">
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
		<p>Edição de Linha</p>
		<br>



		<form method="POST" action="processa_editar_linha.php">
			<input type="hidden" id="id_linha" name="id_linha" value="<?php echo $id_linha;?>">
			<div class="row">
				<div class="col-25">
					<label for="lname">Código Linha: <font color="red">*</font></label>
				</div>
				<div class="col-70">
					<input type="text" readonly required name="id_linha" id="id_linha" value="<?php echo $result_array['id_linha'];?>">
				</div>
			</div>

			<div class="row">
				<div class="col-25">
					<label for="lname">Descrição: <font color="red">*</font></label>
				</div>
				<div class="col-70">
					<input type="text" name="descricao" required id="descricao" value="<?php echo $result_array['descricao'];?>">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="lname">Ativo: <font color="red">*</font></label>
				</div>
				<select class="col-70" required name="ativo">
					<option value="S"<?php echo selected('S', $ativo);?>">Sim</option>
					<option value="N"<?php echo selected('N', $ativo);?>">Não</option>
				</select>
			</div>

			<br>

			<div class="botoes_align">
				<input type="button" value="Limpar" onclick="limpar_campos()">
				<input type="submit" value="Editar">
			</div>
			<br><br>


		</form>
		<div class="exibe_registros">
			<button id="exibe_registros" onclick="exibir();">Exibir Registros</button>
			<br>
		</div>
		<br><br><br>

		<div id="exibir_registros" style="display: none;">
			<?php if ($rows = mysqli_num_rows($result) > 0) { ?>
				<p>Listagem de Linhas</p>
				<br>

				<table id="tabela" class="table table-hover">
					<thead>
					<tr>
						<th scope="col">Código Linha</th>
						<th scope="col">Descrição</th>
						<th scope="col">Ativo</th>
						<th scope="col"></th>
					</tr>
					</thead>
					<tbody>
					<?php
					while ($rows = mysqli_fetch_array($result_linha)) {
						?>
						<tr>
							<td><b><?php echo $rows['id_linha']; ?></b></td>
							<td><?php echo $rows['descricao']; ?></td>
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
								<a href="editar_linha.php?id_linha=<?php echo $rows['id_linha']; ?>">
									<i class="fa fa-edit" style="font-size:24px;color:green"></i></a> &nbsp;&nbsp;
							</td>
						</tr>
						<?php
					}
					mysqli_close($conn);
					?>
					</tbody>
				</table>
			<?php }
			?>
			<br><br><br>
		</div>
	</div>
</center>
</body>

<script language="javascript">
	function limpar_campos() {
		document.getElementById('descricao').value = "";
	}

	function exibir() {
		document.getElementById("exibir_registros").style.display = "block";
	}
</script>

</html>