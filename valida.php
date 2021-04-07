<?php
session_start();
include_once('conexao.php');

$usuario = $_POST['usuario'];
$senha   = $_POST['senha'];


if ((!empty($usuario)) AND  (!empty($senha))) {
    
            // Autenticação base de logins para posterior redirecionamento
            $host_aut="localhost"; // Host name 
            $username_aut="fastcon1_master"; // Mysql username 
            $password_aut="$}4aSu@&$0}x"; // Mysql password 
            $db_name_aut="fastcon1_autentica"; // Database name 

            $conn_aut = mysqli_connect("$host_aut", "$username_aut", "$password_aut", "$db_name_aut");  
        
            $sql_con_aut = "SELECT * FROM users where usuario = '$usuario' LIMIT 1";
            $result_con_aut = mysqli_query($conn_aut, $sql_con_aut);
            $resultado_conexao_row = mysqli_fetch_assoc($result_con_aut);
            $_SESSION['id_entrada'] = $resultado_conexao_row['id_entrada'];
        
            
        if ($result_con_aut) {
            if ($senha == $resultado_conexao_row['senha']) {
             
           
            $sql_empresa = "SELECT emp.id_empresa, 
                                   emp.nome_empresa, 
                                   us.nome, 
                                   us.id_usuario, 
                                   usuario, 
                                   emp.venda_direta,
                                   emp.utiliza_comanda,
                                   emp.controla_nasci_cliente            
                            FROM empresa emp LEFT JOIN usuarios us ON (us.id_empresa = emp.id_empresa)
                            WHERE us.usuario = '$usuario'";
            $sql_empresa_exec = mysqli_query($conn,$sql_empresa);
            $row_empresa = mysqli_fetch_assoc($sql_empresa_exec);   
            
            $_SESSION['UsuarioNome'] = $row_empresa['nome'];
            $_SESSION['UsuarioId']   = $row_empresa['id_usuario'];
            $_SESSION['Usuario']     = $row_empresa['usuario'];
            $_SESSION['Empresa']     = $row_empresa['id_empresa'];
            $_SESSION['Empresa_nome']= $row_empresa['nome_empresa'];  
            
            //Parâmetros

            $_SESSION['venda_direta'] = $row_empresa['venda_direta'];
            $_SESSION['comanda'] = $row_empresa['utiliza_comanda'];
            $_SESSION['controle_data_nasci'] = $row_empresa['controla_nasci_cliente'];

            //Validação de Logo

            switch($_SESSION['id_entrada']){
                case '100': 
                    $_SESSION['caminho_logo'] = 'logo_molinari.jpg';
                break;
                case '101':
                    $_SESSION['caminho_logo'] = 'Logog2_kids.jpg';
                break;
                
                case '102':
                    $_SESSION['caminho_logo'] = 'logo_gorilla.jpg';
                break;
                case '103':
                    $_SESSION['caminho_logo'] = 'logo_encruzilhada.png';
                break;
                case '104':
                    $_SESSION['caminho_logo'] = 'logo_centralpark.png';
                break;
                case '105':
                    $_SESSION['caminho_logo'] = 'logo_clothes.png';
                break;
            }
            header("Location: venda_direta.php");
        } else {
            $_SESSION['msg'] = "Login e/ou senha incorreto!";
            header("Location: login.php");
        }
    }
} else {
    //$_SESSION['msg'] = "Login e/ou senha incorreto!";
    //header("Location: login.php");
}

?>