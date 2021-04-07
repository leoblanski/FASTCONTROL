<?php
session_start();
include_once("conexao.php");

$id_comanda = filter_input(INPUT_GET, 'id_comanda', FILTER_SANITIZE_NUMBER_INT);;

$sql_delete_comanda = "DELETE FROM comanda WHERE id_comanda = $id_comanda";
$resultado_comanda = mysqli_query($conn, $sql_delete_comanda);
$sql_delete_carrinho = "DELETE FROM carrinho_tmp WHERE id_comanda = $id_comanda";
$resultado_carrinho = mysqli_query($conn, $sql_delete_carrinho);


if($resultado_comanda and $resultado_carrinho){
	 echo("<script>alert('Comanda deletada com sucesso! Todos os produtos foram deletados do carrinho.')</script>");
 echo("<script>window.location = 'comanda_aberto.php';</script>");

}else{
	echo("<script>alert('Comanda não foi deletada com sucesso, tente novamente ! Caso o problema persista, entre em contato com o suporte.')</script>");
    echo("<script>window.location = 'comanda_aberto.php';</script>");
    mysqli_close($conn);
}
