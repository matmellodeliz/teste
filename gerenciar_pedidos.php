<style>
  table {
    border-collapse: collapse;
    width: 600px;
    table-layout: fixed;
  }


  td,
  th {
    border: 1px solid lightgray;
    text-align: left;
    padding: 8px;
  }


  tr:nth-child(even) {
    background-color: lightgray;
  }
</style>

<?php
// conecta ao banco de dados
$con = mysqli_connect("localhost", "root", "", "teste");
// listar pedidos
$pedidos = "SELECT cliente.nom_cliente, pedido.num_pedido FROM pedido JOIN cliente 
    ON cliente.cod_cliente = pedido.cod_cliente;";
// cria a instrução SQL que vai selecionar os dados
$querypedidos = sprintf($pedidos);
// executa a query
$dadospedidos = mysqli_query($con, $querypedidos);
// transforma os dados em um array
$linhapedidos = mysqli_fetch_assoc($dadospedidos);
// calcula quantos dados retornaram
$totalpedidos = mysqli_num_rows($dadospedidos);


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teste</title>

</head>

<body>
  <?php
  // se o número de resultados for maior que zero, mostra os pedidos
  if ($totalpedidos > 0) {
    $preco_total = 0;
    // inicia o loop que vai mostrar todos os pedidos
    do {
  ?>
      <table>
        <tr>
          <th style="background-color: gray;">Pedido:</th>
          <th><?= $linhapedidos['num_pedido'] ?></th>
          <th>Cliente: </th>
          <th><?= $linhapedidos['nom_cliente'] ?></th>
          <th><form action="controlar_pedido.php" method="GET">
            <input type="submit" value="Inserir Item">
            <input type="hidden" value="<?= $linhapedidos['num_pedido'] ?>" name="pedido""></form>
          <form action="excluir_pedido.php" method="GET">
            <input type="submit" value="Excluir Pedido">
            <input type="hidden" value="<?= $linhapedidos['num_pedido'] ?>" name="pedido"></form></th>

        </tr>
        <?php
        // listar itens
        $itens = "SELECT item_pedido.cod_item, item_pedido.qtd_solicitada, item_pedido.pre_unitario, (item_pedido.qtd_solicitada * item_pedido.pre_unitario) AS preco_total
        FROM item_pedido JOIN pedido ON item_pedido.num_pedido = pedido.num_pedido JOIN cliente 
        ON pedido.cod_cliente = cliente.cod_cliente WHERE item_pedido.num_pedido = ";
        $num_pedido = $linhapedidos['num_pedido'] . " ORDER BY num_seq_item";
        // cria a instrução SQL que vai selecionar os dados
        $queryitens = sprintf($itens . $num_pedido);
        // executa a query
        $dadositens = mysqli_query($con, $queryitens);
        // transforma os dados em um array
        $linhaitens = mysqli_fetch_assoc($dadositens);
        // calcula quantos dados retornaram
        $totalitens = mysqli_num_rows($dadositens);
  // se o número de resultados for maior que zero, mostra os itens
  if ($totalitens > 0) {
    // inicia o loop que vai mostrar todos os itens
    do {
  ?>
        <table class="table-itens">
          <tr style="background-color: gray;">
            <th>Item</th>
            <th>Qtde</th>
            <th>Preço</th>
            <th>Total</th>
            <th></th>
            <th></th>
          </tr>
          <tr>
            <td><?= $linhaitens['cod_item'] ?></td>
            <td><?= number_format((float)$linhaitens['qtd_solicitada'], 0, '.', ''); ?></td>
            <td><?= "R$ " . number_format((float)$linhaitens['pre_unitario'], 2, '.', ''); ?></td>
            <td><?= "R$ " . number_format((float)$linhaitens['preco_total'], 2, '.', ''); ?></td>
            <td></td>
            <td></td>
          </tr>
        </table>
        <?php
        $preco_total += $linhaitens['preco_total'];
      // finaliza o loop que vai mostrar os itens
      // fim do if
    } while ($linhaitens = mysqli_fetch_assoc($dadositens));
  }
  ?>
      </table>
      <b>Total: <?= "R$ " . number_format((float)$preco_total, 2, '.', ''); ?></b>
      <br>
  <?php
      // finaliza o loop que vai mostrar os pedidos
      // fim do if
      $preco_total = 0;
    } while ($linhapedidos = mysqli_fetch_assoc($dadospedidos));
  }
  ?>
</body>

</html>