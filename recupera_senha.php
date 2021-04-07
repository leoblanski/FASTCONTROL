<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <script src="scripts/jquery-1.11.2.min.js"></script>
  </head>
  
  <header class="header green-bg" >
        <img src="fotos/logo.png" style="height="50"; width="50";"></img>
    </header>
<body>
  <center>
    <h2>Recuperar senha</h2>
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
			<form method="POST" action="recupera.php">
				<input type="text" name="email" placeholder="Seu e-mail"><br><br>
				<input type="submit" value="Recuperar" onClick="ValidaEmail();"><br><br>
			</form>
      <a href="login.php">Voltar</a>
    </center>
</body>
</html>
