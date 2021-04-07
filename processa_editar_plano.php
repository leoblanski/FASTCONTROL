<?php
session_start();
include_once("conexao.php");

$cod_plano = $_POST['cod_plano'];
$descricao = $_POST['descricao'];
$forma_pagamento = $_POST['forma_pagamento'];
$deb_cred = $_POST['deb_cred'];
$ativo = $_POST['ativo'];
$deb_cred = $_POST['deb_cred'];
$parcelas = $_POST['parcelas'];

/*Se o plano for cadastrado como crédito e com parcelas e for alterado para débito, seta a variável parcelas pra 1.*/
if ($deb_cred == 'debito'){
    $parcelas = '1';
}


$result_plano = "UPDATE planos SET descricao='$descricao',forma_pagamento='$forma_pagamento', credito_debito='$deb_cred', parcelas='$parcelas', ativo='$ativo'  WHERE cod_plano = '$cod_plano'";
$resultado_plano = mysqli_query($conn, $result_plano);


if($resultado_plano){
	 echo("<script>alert('Plano de Pagamento Editado com Sucesso.')</script>");
 echo("<script>window.location = 'editar_plano.php?cod_plano=$cod_plano';</script>");

}else{
	echo("<script>alert('O plano nao foi editado com Sucesso, tente novamente ! Caso o problema persista, entre em contato com o suporte.')</script>");
    echo("<script>window.location = 'editar_plano.php?cod_plano=$cod_plano';</script>");
    mysqli_close($conn);
}
