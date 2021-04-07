<?php
   session_start();
   include('conexao.php');
   
   $sql_linha = "SELECT id_linha, descricao FROM produtos_linha WHERE ativo = 'S'";
   $result_linha = mysqli_query($conn, $sql_linha);
   
   $sql_marca = "SELECT id_marca, descricao FROM produtos_marca WHERE ativo = 'S'";
   $result_marca = mysqli_query($conn, $sql_marca);
   
   date_default_timezone_set('America/Sao_Paulo');
   $data = date('d/m/yy');
   
   ?>
<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Inventário</title>
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
         integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
         integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="css/estilo_relat_inventario.css">
      <link rel="stylesheet" type="text/css" href="css/containeres.css">
   </head>
   <body>
      <?php
         include_once 'menu.php';
         ?>
      <center>
         <div class="container_principal">
            <p>Inventário Produtos</p>
            <br>
            <form method="POST" action="relat_inventario_gerado.php">
               <div class="row">
                  <div class="col-25">
                     <label for="lname">Linha: </label>
                  </div>
                  <div class="col-60">
                     <select name="linha" id="linha" onchange="preenche_items();" multiple>
                        <?php
                           while($rows = mysqli_fetch_assoc($result_linha)){ ?>
                        <option value="<?php echo $rows['id_linha']; ?>"><?php echo $rows['id_linha']." - ".$rows['descricao']; ?></option>
                        <?php
                           }
                           ?>
                     </select>
                     <input type="hidden" name="linha_selecionada" id="linha_selecionada" value="">
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="lname">Marca: </label>
                  </div>
                  <div class="col-60">
                     <select name="marca" id="marca" multiple>
                        <?php
                           while($rows = mysqli_fetch_assoc($result_marca)){ ?>
                        <option value="<?php echo $rows['id_marca']; ?>"><?php echo $rows['id_marca']." - ".$rows['descricao']; ?></option>
                        <?php
                           }
                           ?>
                     </select>
                     <input type="hidden" name="marca_selecionada" id="marca_selecionada" value="">
                  </div>
               </div>
               <br>
               <div class="align_check">
                  <div class="row">
                     <div class="checkbox">
                        <label><b><input type="radio" value="somente_positivo" id="saldo" name="saldo"
                           >Listar somente produtos com saldo positivo</b></label>
                     </div>
                  </div>
                  <div class="row">
                     <div class="checkbox">
                        <label><b><input type="radio" value="somente_negativo" id="saldo" name="saldo">Listar somente produtos com saldo negativo</b></label>
                     </div>
                  </div>
                  <div class="row">
                     <div class="checkbox">
                        <label><b><input type="radio" value="indiferente" id="saldo" name="saldo" checked >Listar todos os produtos</b></label>
                     </div>
                  </div>
               </div>
               <br>
               <div class="botoes_align">
                  <input type="button" value="Limpar" onclick="limpar_campos()">
                  <input type="submit" value="Pesquisar">
               </div>
         </div>
         <br>
         </form>
         <br><br><br>
         </div>
      </center>
   </body>
   <script language="javascript">
      function limpar_campos() {
      	document.getElementById('data_inicial').value = "";
      	document.getElementById('data_final').value = "";
      	document.getElementById('somente_comanda').checked = false;
      	document.getElementById('somente_direta').checked = false;
      }
      
      
      const linha = document.getElementById('linha');
      linha.addEventListener('change', (e) => {
      
       const options = e.target.options;
       const selectedOptions = [];
       const selectedValues = [];
      
       for (let i = 0; i < options.length; i++) {
         if (options[i].selected) {
           selectedOptions.push(options[i]);
           selectedValues.push(options[i].value);
         }
       }
      
  		document.getElementById('linha_selecionada').value = selectedValues;
      });
      

        const marca = document.getElementById('marca');
      marca.addEventListener('change', (e) => {
      
       const options = e.target.options;
       const selectedOptions = [];
       const selectedValues = [];
      
       for (let i = 0; i < options.length; i++) {
         if (options[i].selected) {
           selectedOptions.push(options[i]);
           selectedValues.push(options[i].value);
         }
       }
      
  		document.getElementById('marca_selecionada').value = selectedValues;

      });
      
   </script>
</html>