<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no"> 
        <link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon"/>
        
        <title>FastControl - Login</title>
        <script src="scripts/jquery-1.11.2.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <link rel="stylesheet" type="text/css" href="css/cadastrarse.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
<body>
    <center>
        <!--<img src="fotos/back_log.png" class="fundo_login"></img><br>-->
        <div class="container_login">
            <br><br><img src="fotos/logo_login.png"></img><br><Br><br><Br>
            <p style="color:red">
                <?php
                    if(isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
            </p>
            <p style="color:green">
                <?php
                    if(isset($_SESSION['msgcad'])){
                        echo $_SESSION['msgcad'];
                        unset($_SESSION['msgcad']);
                    }
                ?>
            </p>
            <form method="POST" action="valida.php">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="text" required name="usuario"  placeholder="Informe o seu usuário" class="form-control">
                </div>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" required name="senha" placeholder="Informe a sua senha" class="form-control">
                </div>
                <br><br>
                <div class="botao_login"><b>
                    <input type="submit" value="Acessar" style="color:white;" class="btn btn-primary"></b><br><br>
                </div>
            </form>
        </div>  
    </center>
</body>

<script>
function validasenha(){ 
   	senha1 = document.formModalCadastro.senha.value 
   	senha2 = document.formModalCadastro.confSenha.value 
   	if (senha1 != senha2){
      	alert ("Senhas não conferem!");
             return false;
   	}
   	else{
      	 return true;
   	}
}
    function validaEmail(){
        var resultadoEmail = pesquisaEmail();
        if(resultadoEmail != true){
            alert("E-mail não confere!!!");
        }
    }
</script>
</html>
