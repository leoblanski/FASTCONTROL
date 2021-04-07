<?php
session_start();
include('conexao.php');

$tipo_pesquisa = $_POST['pesquisa_cliente'];
$valor_pesquisa = $_POST['valor_pesquisa'];


if ($tipo_pesquisa == "nome") {
	$sql_clientes = "select * from clientes where nome like '%$valor_pesquisa%'";
} elseif ($tipo_pesquisa == "cod_cliente") {
	$sql_clientes = "select * from clientes where cod_cliente = $valor_pesquisa";
} elseif ($tipo_pesquisa == "cpf") {
	$sql_clientes = "select * from clientes where cpf = '$valor_pesquisa'";
}

$result = mysqli_query($conn, $sql_clientes);


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="gb18030">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Listagem de Produto</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
	integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/estilo_pesquisa_cliente.css">
	<link rel="stylesheet" type="text/css" href="css/containeres.css">
</head>
<body>
	<?php
	include 'menu.php';
	?>

	<center>
		<div class="container_principal">
			<p>Pesquisa de Cliente</p>
			<br><br>

			<form method="POST" action="pesquisar_cliente.php">
				<div class="row">
					<select class="col-25-pesquisa" name="pesquisa_cliente">
						<option value="nome">Nome</option>
						<option value="cod_cliente">Codigo do Cliente</option>
						<option value="cpf">CPF</option>
					</select>

					<div class="col-75-pesquisa">
						<input type="text" required placeholder="Informe a busca desejada" name="valor_pesquisa"
						id="valor_pesquisa">
					</div>
				</div>
				<br>

				<div class="botoes_align_pesquisa">
					<input type="submit" value="Pesquisar">
				</div>
				<br><br>
			</form>


			<?php if ($rows = mysqli_num_rows($result) > 0) {

				?>
				<table id="tabela" class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Codigo</th>
							<th scope="col">Nome</th>
							<th scope="col">CPF</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while ($rows = mysqli_fetch_array($result)) {
							?>
							<tr>
								<td>&emsp;<?php echo $rows['cod_cliente']; ?></td>
								<td><?php echo $rows['nome']; ?></td>
								<td><?php echo $rows['cpf']; ?></td>
								<td>
									<a href="editar_cliente.php?cod_cliente=<?php echo $rows["cod_cliente"]; ?>">
										<i class="fa fa-edit" style="font-size:24px;color:green"></i></a> &nbsp;&nbsp;
									</td>
								</tr>
								<?php
							}
							mysqli_close($conn);
							?>
						</tbody>
					</table>
				<?php } else {
					echo("<script>alert('Nenhum registro encontrado.')</script>");
					echo("<script>window.location = 'pesquisa_cliente.php';</script>");
				}
				?>

			</center>
			</html>
