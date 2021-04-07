<?php
session_start();
include('conexao.php');

$cod_cliente = $_GET['cod_cliente'];
$result_cliente = "SELECT * FROM clientes WHERE cod_cliente = '$cod_cliente'";
$resultado_cliente = mysqli_query($conn, $result_cliente);
$row_cliente = mysqli_fetch_assoc($resultado_cliente);

$sexo = $row_cliente['sexo'];
$ativo = $row_cliente['ativo'];

function selected($value, $selected)
{
   return $value == $selected ? ' selected="selected"' : '';
}



?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Editar Cliente</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
   <link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon" />
   <link rel="stylesheet" type="text/css" href="css/estilo_cadastro_produto.css">
   <link rel="stylesheet" type="text/css" href="css/containeres.css">
</head>

<body>
   <?php
   session_start();
   ?>
   <!DOCTYPE html>
   <html lang="pt-br">

   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Cadastro - Clientes</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
      <link rel="shortcut icon" href="fotos/appaut.ico" type="image/x-icon" />
      <link rel="stylesheet" type="text/css" href="css/estilo_cadastro_clientes.css">
      <link rel="stylesheet" type="text/css" href="css/containeres.css">
      <script type="text/javascript" src="jquery-1.7.1.min.js"></script>
      <script type="text/javascript" src="js/funcoes.js"></script>
   </head>

   <body>
      <?php
      include 'menu.php';
      ?>
      <center>
         <div class="container_principal">

            <p>Edição de Clientes</p>
            <br>
            <form method="POST" action="processa_editar_clientes.php">
               <div class="row">
                  <div class="col-25">
                     <label for="fname">Código Cliente: <font color="red"></font></label>
                  </div>
                  <div class="col-75">
                     <input type="text" readonly name="cod_cliente" value="<?php echo $row_cliente['cod_cliente']; ?>">
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="fname">CPF: <font color="red">*</font></label>
                  </div>
                  <div class="col-75">
                     <input type="text" onblur="valida_cpf(cpf.value);" maxlength="11" name="cpf" placeholder="Informe o CPF" value="<?php echo $row_cliente['cpf']; ?>">
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="lname">Nome Completo: <font color="red">*</font></label>
                  </div>
                  <div class="col-75">
                     <input type="text" required name="nome" placeholder="Informe o nome completo" value="<?php echo $row_cliente['nome']; ?>">
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="lname">Data de Nascimento: <font color="red">*</font></label>
                  </div>
                  <div class="col-75">
                     <input type="text" value="<?php echo date('d/m/Y',  strtotime($row_cliente['data_nasci'])); ?>" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" id="data_nasci" name="data_nasci" title="Digite a data de nascimento no formato 00/00/0000" placeholder="Informe a data de nascimento no formado 00/00/0000" maxlength="11">
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="lname">Telefone: <font color="red">*</font></label>
                  </div>
                  <div class="col-75">
                     <input type="text" pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4,5}" id="telefone" name="telefone" value="<?php echo $row_cliente['telefone']; ?>" maxlength="12" placeholder="Informe o telefone com DDD">
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="lname">Sexo: <font color="red">*</font></label>
                  </div>
                  <select class="col-75" name="sexo">
                     <option value="Masculino" <?php echo selected('Masculino', $sexo); ?>>Masculino</option>
                     <option value="Feminino" <?php echo selected('Feminino', $sexo); ?>>Feminino</option>
                     <option value="Indefinido" <?php echo selected('Indefinido', $sexo); ?>>Indefinido</option>
                  </select>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="lname">E-mail: <font color="red">*</font></label>
                  </div>
                  <div class="col-75">
                     <input type="text" value="<?php echo $row_cliente['email']; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email" title="Digite o e-mail no formato xx@xx.xx" placeholder="Informe o email">
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="lname">CEP: <font color="red">*</font></label>
                  </div>
                  <div class="col-75">
                     <input type="number" value="<?php echo $row_cliente['cep']; ?>" id="cep" maxlength="9" onblur="pesquisacep(this.value);" name="cep" title="Digite o cep (Apenas Números)" placeholder="Informe o CEP">
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="lname">Estado: <font color="red">*</font></label>
                  </div>
                  <div class="col-75">
                     <input type="text" value="<?php echo $row_cliente['estado']; ?>" name="estado" id="estado">
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="lname">Cidade: <font color="red">*</font></label>
                  </div>
                  <div class="col-75">
                     <input type="text" value="<?php echo $row_cliente['cidade']; ?>" name="cidade" id="cidade">
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="lname">Observação: </label>
                  </div>
                  <div class="col-75">
                     <input type="text" name="obs" id="obs" value="<?php echo $row_cliente['observacao']; ?>" placeholder="Informe a observação">
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="lname">Cadastro ativo: <font color="red">*</font></label>
                  </div>
                  <select class="col-75" name="ativo">
                     <option value="S" <?php echo selected('S', $ativo); ?>>Sim</option>
                     <option value="N" <?php echo selected('N', $ativo); ?>>Não</option>
                  </select>
               </div>
               <?php if ($_SESSION['controle_data_nasci']) { ?>
                  <div class="row">
                     <div class="col-25">
                        <label for="lname">Dependentes: </label>
                     </div>
                     <div class="classdep">
                        <a href="cadastro_dependente.php?cod_cliente=<?php echo $cod_cliente; ?>">Cadastrar Dependentes</a>
                     </div>
                  </div>
               <?php } ?>
               <br>
               <br>
               <div class="botoes_align">
                  <input type="button" value="Limpar">
                  <input type="submit" value="Editar">
               </div>
            </form>
         </div>
      </center>
   </body>
   <script>
      function meu_callback(conteudo) {
         if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('obs').value = (conteudo.bairro) + ' - ' + (conteudo.logradouro);
            //document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value = (conteudo.localidade);
            document.getElementById('estado').value = (conteudo.uf);
            //document.getElementById('ibge').value=(conteudo.ibge);
         } //end if.
         else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
         }
      }

      function pesquisacep(valor) {

         //Nova variável "cep" somente com dígitos.
         var cep = valor.replace(/\D/g, '');

         //Verifica se campo cep possui valor informado.
         if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

               //Preenche os campos com "..." enquanto consulta webservice.
               document.getElementById('obs').value = "...";
               //document.getElementById('bairro').value="...";
               document.getElementById('cidade').value = "...";
               document.getElementById('estado').value = "...";
               //document.getElementById('ibge').value="...";

               //Cria um elemento javascript.
               var script = document.createElement('script');

               //Sincroniza com o callback.
               script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

               //Insere script no documento e carrega o conteúdo.
               document.body.appendChild(script);

            } //end if.
            else {
               //cep é inválido.
               alert("Formato de CEP inválido.");
               document.getElementById('estado').value = '';
            }
         } //end if.
         else {
            return;
         }
      };

      function limpar_campos() {
         document.getElementById('cpf').value = "";
         document.getElementById('nome').value = "";
         document.getElementById('data_nasci').value = "";
         document.getElementById('telefone').value = "";
         document.getElementById('sexo').value = "";
         document.getElementById('email').value = "";
         document.getElementById('estado').value = "";
         document.getElementById('cep').value = "";
         document.getElementById('cidade').value = "";
         document.getElementById('obs').value = "";
      }
      $("#telefone").mask("(00) 0000-00009");
      $("#cep").mask("00000000");
   </script>

   </html>