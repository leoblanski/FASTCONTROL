<?php
session_start();
include ('conexao.php');

// #####  CADASTRO DE USUÁRIOS #####

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$confSenha = $_POST['confSenha'];
$foto = "fotos/" . $_POST['perfil'];
$erro = false;

	if(empty($nome) or empty($email) or empty($senha)){
		$erro = true;
		$_SESSION['msg'] = "Necessário preencher todos os campos";
		header("Location: login.php");
	}elseif(stristr($senha, "'")) {
		$erro = true;
		$_SESSION['msg'] = "Caracter ( ' ) utilizado na senha é inválido";
		header("Location: login.php");
	}
	else{
		$result_usuario = "SELECT email FROM tbl_usuarios WHERE email='". $email ."'";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
			$erro = true;
			$_SESSION['msg'] = "Este e-mail já está cadastrado!";
			header("Location: login.php");
		}
	}

	if(!$erro){
            $result_usuario = "INSERT INTO tbl_usuarios (nome, email, senha, foto) VALUES (
    						'" .$nome. "',
    						'" .$email. "',
                '" .base64_encode($senha). "',
    						'" .$foto. "'
    						)";
        		$resultado_usario = mysqli_query($conn, $result_usuario);
        		if(mysqli_insert_id($conn)){
                    $mensage ="Você foi cadastrado no sistema AppAut, confira os dados de acesso abaixo:\n";
                    $mensage .="\nUsuário: " . $email;
                    $mensage .="\nSenha: " . $senha;
                    $mensage .="\nAcesso: http://www.appaut.tk";
                    $mensage .="\n\nA equipe.";
                    $mensage .="\nAppAut";
                    mail($email, "Cadastro de usuário", $mensage);
        			$_SESSION['msgcad'] = "Usuário cadastrado com sucesso<br>A senha foi enviada para o e-mail cadastrado.";
        			header("Location: login.php");
        		}else{
        			$_SESSION['msg'] = "Erro ao cadastrar o usuário";
        			header("Location: login.php");
        		}
        }
?>
