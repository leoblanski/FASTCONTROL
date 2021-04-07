<?php
session_start();
include_once("conexao.php");

$cod_cliente = $_POST['cod_cliente'];
$documento = $_POST['documento'];
$empresa = $_SESSION['Empresa']; 
$data = $_POST['data'];




$sql_doc = "SELECT identificador 
                FROM movimentacoes WHERE empresa = $empresa
				   AND data = '$data'
				   AND cod_cliente = '$cod_cliente'				   
				   AND documento = $documento 
				   ORDER BY id_movimento DESC LIMIT 1";
$sql_doc_result = mysqli_query($conn, $sql_doc);
$rows = mysqli_num_rows($sql_doc_result);
$array = mysqli_fetch_array($sql_doc_result);
$identificador = $array['identificador'];

if ($rows){
    
    $sql_update = "UPDATE movimentacoes SET cancelado = 'S'
                       WHERE empresa = $empresa
    				   AND data = '$data'
    				   AND cod_cliente = '$cod_cliente'				   
    				   AND documento = $documento 
    				   AND identificador = '$identificador'";
    $result_update = mysqli_query($conn, $sql_update);
    
    
    
    $sql_cancela = "DELETE FROM movimentacoes 
    				   WHERE empresa = $empresa
    				   AND data = '$data'
    				   AND cod_cliente = '$cod_cliente'				   
    				   AND documento = $documento 
    				   AND identificador = '$identificador'";
    $result = mysqli_query($conn, $sql_cancela);


    $sql_cancela_mv = "DELETE FROM movimentacoes_valores 
    				   WHERE identificador = '$identificador'";
    $result = mysqli_query($conn, $sql_cancela_mv);
    
    $sql_cancela_mpl = "DELETE FROM movimentacoes_planos 
    				   WHERE identificador = '$identificador'";
    $result = mysqli_query($conn, $sql_cancela_mpl);


    
    if($result){
    	echo("<script>alert('Documento Cancelado com Sucesso.')</script>");
    	echo("<script>window.location = 'cancela_saida.php';</script>");
    
    }else{
    	echo("<script>alert('Atenção! Não foi possível cancelar a venda, tente novamente !')</script>");
        echo("<script>window.location = 'cancela_saida.php';</script>");
    }
}else{

    echo("<script>alert('Atenção! Não foi possível localizar a venda informada, revise os filtros e tente novamente !')</script>");
    echo("<script>window.location = 'cancela_saida.php';</script>");
}




?>