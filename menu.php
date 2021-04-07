<?php
session_start();
include('conexao.php');
include('verifica_login.php');
$sql_nome_empresa = "SELECT nome_empresa, venda_direta, utiliza_comanda FROM empresa WHERE id_empresa = 1";
$sql_empresa_result = mysqli_query($conn,$sql_nome_empresa);
$sql_empresa_array = mysqli_fetch_array($sql_empresa_result);



?>
<!DOCTYPE html>
<html lang="pt-br">

    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <link rel="stylesheet" type="text/css" href="css/estilomenu.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body>
        
        <div id="container_menu">
            <div id="barra_sup_menu">
                <div>
                    <img src="fotos/<?php echo $_SESSION['caminho_logo']?>"width=100 height=50>
                </div>
                <div id="texto_emp">
                    <?php echo $sql_empresa_array['nome_empresa'];?><br>
                    
                    <div id="texto_user">
                        <?php echo "Usuário: ".$_SESSION['UsuarioId']." - ".$_SESSION['UsuarioNome'];?>
                    </div>
                </div>
            </div>             
    
                <nav id="nav" role="navigation">
                    <a href="#nav" title="Show navigation">Mostrar Navegação</a>
                    <a href="#" title="Hide navigation">Ocultar Navegação</a>
                    <ul>
                        <li>
                            <a a href="#nav" aria-haspopup="true">Início</a>
                            <!--<ul>
                                <li><a href="cadastro_cliente_fornec.php">Lançamento de Fatura</a></li>
                                <li><a href="cadastro_cliente_fornec.php">Baixa de Faturas</a></li>
                                <li><a href="relat_faturas.php">Listagem de Faturas</a></li>
                            </ul>-->
                        </li>   
                        <li>
                            <a aria-haspopup="true">Clientes</a>
                            <ul>
                                <li><a href="cadastro_cliente_fornec.php">Cadastro de Clientes</a></li>
                                <li><a href="pesquisa_cliente.php">Pesquisa</a></li>
                                <li>
                                    <a href="#">Relatórios <font color="red">*</font></a>
                                    <ul>
                                        <li><a href="relat_clientes.php">Relatório de Clientes</a></li>
                                    </ul>

                                </li>
                            </ul>
                        </li>
                        <li>
                            <a aria-haspopup="true">Estoque</a>
                            <ul>
                                <li><a href="cadastro_produto.php">Cadastro de Produtos</a></li>
                                <li><a href="cadastro_linha.php">Cadastro de Linha</a></li>
                                <li><a href="cadastro_marca.php">Cadastro de Marca</a></li>
                                <li><a href="pesquisa_produtos.php">Pesquisa</a></li>
                                <li>
                                    <a href="#">Relatórios <font color="red">*</font></a>
                                    <ul>
                                        <li><a href="relat_inventario.php">Inventário</a></li>
                                    </ul>

                                </li>
                            </ul>

                        </li>
                        <li>
                            <a aria-haspopup="true">Faturamento</a>
                            <ul>
                                <?php if($sql_empresa_array['utiliza_comanda'] == 1){?>
                                <li><a href="cadastro_mesa.php">Cadastro de Mesas</a></li>
                                <?php } ?>
                                <li><a href="cadastro_plano.php">Cadastro de Pagamento</a></li>
                                <?php if($sql_empresa_array['utiliza_comanda'] == 1){?>
                                <li><a href="cadastro_comanda.php">Cadastro de Comanda</a></li>
                                <?php }
                                if($sql_empresa_array['utiliza_comanda'] == 1){?>
                                <li><a href="comanda_aberto.php">Listagem de Comandas</a></li>
                                <?php } if($sql_empresa_array['venda_direta'] == 1){?>
                                <li><a href="venda_direta.php">Venda Direta</a></li>
                                <?php } ?>
                                <li><a href="cancela_saida.php">Cancelamento de Saída</a></li>
                                <li>
                                    <a href="#">Relatórios <font color="red">*</font></a>
                                    <ul>
                                        <li><a href="relat_vendas_per.php">Vendas por Período</a></li>
                                    </ul>

                                </li>
                            </ul>
                        </li>
                        <li><a href="logout.php">Sair</a></li>
                    </ul>
                </nav>
            </div>
        
        </div>
    </body>

</html>