<?php
  if (!isset($_SESSION)) session_start();
  if (!isset($_SESSION['UsuarioNome'])) {
      session_destroy();
      header("Location: index.php"); exit;
  }
include('conexao.php');
$uid = $_SESSION['UsuarioId'];
$sql="SELECT * FROM tbl_usuarios WHERE email != 'admin'";
$result=mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    <meta name="viewport" content="width=device-width, user-scalable=no"> 
    <link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon"/>
    <title>AppAut - Usuarios</title>
    <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.3.1/jquery.quicksearch.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
  
  <body>
    <?php include 'menu.php';?>
    <br><br>
    <center>
        <br><br>
                <table>
                    <tr>
                        <td>
                            <img src="fotos/appaut_fundo.png" width="80" height="80"></img>
                        </td>
                        <td>
                            <h1>Usuários</h1>
                        </td>
                    </tr>
                </table>
                <br><br>
                <button type="button" class="btn btn-primary" onclick="window.location='home_adm.php'">Voltar</button>
                <br><br>
                
        <div class="position_topico">
            <div class="form-group input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                <input name="consulta" id="txt_consulta" placeholder="Pesquisar" type="text" class="form-control" onkeyup="consultar()">
            </div>
        
                    <table id="tabela" class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Foto</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Ação</th>
                                <th scope="col">E-mail</th>
                            </tr>
                        </thead>
                      <tbody>
                        <?php
                        while($rows = mysqli_fetch_array($result)){
                        ?>
                        <tr>
                            <td><img src=<?php echo $rows['foto']; ?> height="24" width="24"></img></td>
                            <td><?php echo $rows['nome']; ?></td>
                            <td><button class="btn btn-danger" onclick="del_user(<?php echo $rows['usuario_id']; ?>)">Exluir</button></td>
                            <td><?php echo $rows['email']; ?></td>
                            
                        </tr>
                        <?php
                        }
                        mysqli_close($conn);
                        ?>
                        </tbody>
                    </table>
        </div>            
    </center>
    
<script>
    function consultar() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("txt_consulta");
      filter = input.value.toUpperCase();
      table = document.getElementById("tabela");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }
    }
</script>
<script>
function del_user(id){
    var resposta = confirm("Deseja excluir este usuário?");
    if(resposta == true){
            const Http = new XMLHttpRequest();
            const url='excluir_user.php?id='+id;
            Http.open("GET", url);
            Http.send();
            
            Http.onreadystatechange=function(){
                if(this.readyState==4 && this.status==200){
                    document.location.reload();
                }
            }
        
    }
}
</script>
  </body>
</html>

