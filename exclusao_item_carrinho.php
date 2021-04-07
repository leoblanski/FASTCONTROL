<?php
session_start();
include_once("conexao.php");

$id_carrinho = filter_input(INPUT_GET, 'id_carrinho', FILTER_SANITIZE_NUMBER_INT);
$cod_produto = filter_input(INPUT_GET, 'cod_produto', FILTER_SANITIZE_NUMBER_INT);
$id_comanda = filter_input(INPUT_GET, 'id_comanda', FILTER_SANITIZE_NUMBER_INT);
$cod_cliente = filter_input(INPUT_GET, 'cod_cliente', FILTER_SANITIZE_NUMBER_INT);

$sql_delete = "DELETE FROM carrinho_tmp WHERE id_carrinho = $id_carrinho";
$result = mysqli_query($conn, $sql_delete);



if($result){
	 echo("<script>alert('Produto deletado com sucesso.')</script>");
 echo("<script>window.location = 'carrinho.php?id_comanda=$id_comanda&cod_cliente=$cod_cliente';</script>");

}else{
	echo("<script>alert('Não foi possível deletar o produto, tente novamente ! Caso o problema persista, entre em contato com o suporte.')</script>");
    echo("<script>window.location = 'carrinho.php?id_comanda=$id_comanda&cod_cliente=$cod_cliente';</script>");
    mysqli_close($conn);
}
