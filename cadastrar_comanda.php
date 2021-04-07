<?php
session_start();
include('conexao.php');

$user_create=$_SESSION['UsuarioId'];
$empresa =$_SESSION['Empresa'];
$cod_cliente=$_POST['cod_cliente'];
$numero=$_POST['nume_comanda'];
$mesa=$_POST['mesa'];
$obs=$_POST['obs'];
$data = date('Y-m-d');
date_default_timezone_set('America/Sao_Paulo');
$hora=date('H:i');

$sql="INSERT INTO comanda (numero_comanda, empresa, cod_cliente, mesa, obs, user_create, dt_create, hr_create, finalizada)VALUES('$numero', '$empresa','$cod_cliente', '$mesa', '$obs', '$user_create', '$data', '$hora','0')";
$result=mysqli_query($conn, $sql);

if($result){

 echo("<script>alert('Comanda Cadastrada com Sucesso.')</script>");
 echo("<script>window.location = 'cadastro_comanda.php';</script>");
}
else {
echo "Não foi possível cadastrar a comanda, tente novamente ! \n Caso o problema persista entre em contato com o suporte." ;
echo mysqli_error($conn);
}
mysqli_close($conn);
?>
