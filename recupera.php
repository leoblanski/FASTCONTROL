<?php
session_start();
include ('conexao.php');

$email = $_POST['email'];

$result = mysqli_query($conn, "SELECT * FROM tbl_usuarios WHERE email='$email'");
$rows = mysqli_num_rows($result);

if($rows==1){

while($row = mysqli_fetch_array($result)){
$rowemail = $row['email'];
$rowsenha = base64_decode($row['senha']);
}

$mensage ="Você solicitou a recuperação de senha confira seu dados.\n";
$mensage .="\nE-mail = " . $rowemail;
$mensage .="\nSenha: " . $rowsenha;
mail($rowemail, "Recuperação de senha", $mensage);
//echo"<script>alert('Sua senha foi enviada para o e-mail indicado.')</script>";
$_SESSION['msgcad'] = "Sua senha foi enviada para o e-mail indicado.";
header("Location: login.php");
}else{
$_SESSION['msg'] = "E-mail não cadastrado.";
header("Location: login.php");
}

?>
