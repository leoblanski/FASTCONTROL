<?php
   session_start();
   
   include('conexao.php');
   $sql = "SELECT c.cod_cliente, 
                  c.id_comanda, 
                  c.dt_create, 
                  c.hr_create, 
                  c.numero_comanda, 
                  cl.nome, 
                  cl.cod_cliente 
            FROM comanda c 
                LEFT JOIN clientes cl on (cl.cod_cliente = c.cod_cliente) 
            WHERE finalizada = '0' ORDER BY c.id_comanda
   ";
   
   $result=mysqli_query($conn, $sql);
   
   $nome_pagina = 'comanda';

   ?>
<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Comandas em Aberto</title>
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
      <link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon"/>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="css/estilo_comandas_aberto.css">
      <link rel="stylesheet" type="text/css" href="css/containeres.css">
   </head>
   <body>
      <script type='text/javascript'></script>
      <?php
         include_once 'menu.php';
         ?>
      <center>
         <div class="container_principal">
            <p>Comandas em aberto</p>
            <br>
            <div class="form-group">
               <input name="consulta" id="txt_consulta" placeholder="Informe o número da comanda" type="text" class="form-control" onkeyup="consultar()">
            </div>
            <table id="tabela" class="table table-hover">
               <thead>
                  <tr>
                     <th scope="col">Data</th>
                     <th scope="col">Hora</th>
                     <th scope="col">Número Comanda</th>
                     <th scope="col">Nome Cliente</th>
                     <th scope="col">Ações</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     while($rows = mysqli_fetch_array($result)){
                      ?>
                  <tr>
                     <td><?php echo  date('d/m/Y',  strtotime($rows['dt_create'])); ?></td>
                     <td><?php echo $rows['hr_create']; ?></td>
                     <td><?php echo $rows['numero_comanda']; ?></td>
                     <td><?php echo $rows['nome']; ?></td>
                     <td>
                        <a href="carrinho.php?id_comanda=<?php echo $rows["id_comanda"];?>&cod_cliente=<?php echo $rows["cod_cliente"];?>&nome_pagina=<?php echo $nome_pagina;?>">
                        <i class="fa fa-shopping-cart" style="font-size:25px;color:green"></i>
                        </a>&nbsp;
                        <a href="exclusao_comanda.php?id_comanda=<?php echo $rows["id_comanda"];?>" id="exclusao_comanda">
                        <i class="fa fa-close" style="font-size:25px;color:red"></i>
                        </a>
                     </td>
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
            td = tr[i].getElementsByTagName("td")[2];
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
         
        var excluir = document.getElementById('exclusao_comanda');
         
        excluir.onclick = function(){
        var r=confirm("Você deseja realmente cancelar a comanda ?\nA operação não poderá ser desfeita!");
          if (r==true)
          {
            return true;
          }
          else
          {
            return false;
          }
        }
      </script>
</html>