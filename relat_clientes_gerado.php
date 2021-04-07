<?php
session_start();
include('conexao.php');

$ativo = $_POST['cadastros_ativos'];
$filtro_data = $_POST['data_cadastro'];
$data_inicial = $_POST['data_inicial'];
$data_final = $_POST['data_final'];

 
$sql_cliente = "SELECT cl.cod_cliente,
			   nome,
			   data_nasci,
			   cl.sexo,
			   email,
			   telefone,
			   cl.ativo,
			   nome_dependente,
			   data_nasci_dep, 
			   cd.sexo as sexo_dep 
		FROM clientes cl
			LEFT JOIN clientes_dependentes cd ON (cd.cod_cliente = cl.cod_cliente)
			WHERE cl.cod_cliente <> 1";
IF($ativo){
	$sql_cliente = $sql_cliente." AND ativo = 'S'";
}
IF($filtro_data){
	$sql_cliente = $sql_cliente." AND data_cadastro BETWEEN '$data_inicial' AND '$data_final'";
}

$resultado = mysqli_query($conn, $sql_cliente);

function descobrirIdade($dataNascimento){
    // formato da data de nascimento
    // yyyy-mm-dd
    $data       = explode("-",$dataNascimento);
    $anoNasc    = $data[0];
    $mesNasc    = $data[1];
    $diaNasc    = $data[2];
 
    $anoAtual   = date("Y");
    $mesAtual   = date("m");
    $diaAtual   = date("d");
 
    $idade      = $anoAtual - $anoNasc;
 
    if ($mesAtual < $mesNasc){
        $idade -= 1;
        return $idade;
    } elseif ( ($mesAtual == $mesNasc) && ($diaAtual <= $diaNasc) ){
        $idade -= 1;
        return $idade;
    }else
        return $idade;
}

function soNumero($str) {
    return preg_replace("/[^0-9]/", "", $str);
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Relatório de Clientes</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/estilo_relat_inventario.css">
	<link rel="stylesheet" type="text/css" href="css/containeres.css">
</head>
<body> 
 
	<?php
	include_once 'menu.php';
	?> 

	<center>
		<div class="container_principal">
			<p>Relatório de Clientes</p><br>

			<br>
			<?php if ($rows = mysqli_num_rows($resultado) > 0) {?>
				<table id="tabela" class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Cod / Nome</th>
							<th scope="col">Nascimento</th>
							<th scope="col">Idade</th>
							<th scope="col">Sexo</th>
							<th scope="col">Telefone <i class="fa fa-info-circle" title="Clique sobre o ícone do Whatsapp para encaminhar uma mensagem. O formato do número cadastrado deve ser: DDXXXXXXXXX."  style="font-size:125%; color:#367fbf;"></i></th>
							<th scope="col">E-mail</th>
							<?php if($_SESSION['controle_data_nasci']){?>
								<th scope="col">|   Nome Filho(a)</th>
								<th scope="col">Nascimento</th>
								<th scope="col">Idade</th>
								<th scope="col">Sexo   |</th>								
							<?php }?>
						</tr>
					</thead>
					<tbody>
						<?php
						while ($rows = mysqli_fetch_array($resultado)) {
							?>
							<tr>
								<td><?php echo $rows['cod_cliente']." - ".$rows['nome'];
									if($rows['ativo'] == 'N'){
										echo " - ";?>
										<label style="color: red; font-weight:none; padding:0px; margin-bottom:0;"><?php echo "(DESATIVADO)";
									}?>
									<!-- <a href="http://fastcontrol.com.br/relat_clientes_gerado.php?codCliente=<?php echo $rows['cod_cliente']?>" target="_blank">
								        <i class="fa fa-shopping-bag" style="color: black;" aria-hidden="true" tittle="Compras do Cliente"></i>
									</a>-->
									
								</td>
								<td>
								    <?php if ($rows['data_nasci'] == '0000-00-00'){
								        echo "-";
								    }
								    else{
								        echo date('d/m/Y',  strtotime($rows['data_nasci']));
								    }
								    ?>
								</td>
								<td>
								    <?php if ($rows['data_nasci'] == '0000-00-00'){
								        echo "-";
								    }
								    else{
								        echo descobrirIdade($rows['data_nasci']);
								    }
								    ?>
								<td><?php echo strtoupper($rows['sexo']); ?></td>
								<td>
								    <?php 
								        if($rows['telefone']){
								            echo $rows['telefone'];?>
								        <a href="https://api.whatsapp.com/send?phone=55<?php echo soNumero($rows['telefone'])?>" target="_blank">
								            <i class="fa fa-whatsapp" style="color: green;" aria-hidden="true"></i>
									    </a>
								            <?php
								        }else{
								            echo "-";
								        } 
								    ?>

								</td>
								<td><?php echo $rows['email']; ?></td>
								<?php if($_SESSION['controle_data_nasci']){?>
									<td>
										<?php if($rows['nome_dependente']){
											echo strtoupper($rows['nome_dependente']); 
										}else{
											echo "-";
										}?>										
									</td>
									<td>
										<?php if($rows['data_nasci_dep']){
											echo date('d/m/Y',  strtotime($rows['data_nasci_dep']));
										}else{
											echo "-";
										}?>
									</td>
									<td>	
										<?php if($rows['data_nasci_dep']){
											echo descobrirIdade($rows['data_nasci_dep']);
										}else{
											echo "-";
										}?>
									</td>
									<td>	
										<?php if($rows['sexo_dep']){
											echo strtoupper($rows['sexo_dep']); 
										}else{
											echo "-";
										}?>
									</td>
								<?php }?>
							</tr>
							<?php
						}
						mysqli_close($conn);
						?>
					</tbody>
				</table>
			<?php } else {
				//echo $sql_cliente;
				echo("<script>alert('Nenhum registro encontrado, realize uma nova busca utilizando novos filtros.')</script>");
				echo("<script>window.location = 'relat_clientes.php';</script>");
			}
			?>

		</center> 
		</html>
