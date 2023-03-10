<?php
// conecta ao banco de dados
$con = mysqli_connect("localhost", "root", "", "teste");
$num_pedido = $_GET['pedido'];
// listar itens
$itens = "SELECT den_item FROM item;";
// cria a instrução SQL que vai selecionar os dados
$queryitens = sprintf($itens);
// executa a query
$dadositens = mysqli_query($con, $queryitens);
// transforma os dados em um array
$linhaitens = mysqli_fetch_assoc($dadositens);
// calcula quantos dados retornaram
$totalitens = mysqli_num_rows($dadositens);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inserir Item</title>
</head>
<body>
  
<h3>Inserir item</h3>
<form action="gerenciar_pedidos.php">
  <label for="item"></label>
  <select name="item" id="item">
    <?php
      if ($totalitens > 0) {
        // inicia o loop que vai mostrar todos os itens
        do {
  ?>
    <option value="<?= $linhaitens['den_item'] ?>"><?= $linhaitens['den_item'] ?></option>
    <?php
      // finaliza o loop que vai mostrar os itens
      // fim do if
      } while ($linhaitens = mysqli_fetch_assoc($dadositens));
    }
  ?>
  </select>
  <br>
  <h3>Quantidade</h3>
  <label for="quantidade"></label>
  <input type="number" name="quantidade" id="quantidade" value="1" min="1" step="1">
  <br><br>
  <input type="submit" value="Inserir">
</form>

</body>
</html>