<style>
table {
  border-collapse: collapse;
  width:600px;
  table-layout: fixed;
}


td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}


tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

<?php
    // listar pedidos
    $pedidos = "SELECT cliente.nom_cliente, pedido.num_pedido FROM pedido JOIN cliente ON cliente.cod_cliente = pedido.cod_cliente;";
    // listar itens
    $itens = "SELECT item_pedido.cod_item, item_pedido.qtd_solicitada, item_pedido.pre_unitario from item_pedido JOIN pedido on item_pedido.num_pedido = pedido.num_pedido";
    // conecta ao banco de dados
    $con = mysqli_connect("localhost", "root", "82371", "teste");
    // cria a instrução SQL que vai selecionar os dados dos pedidos
    $querypedidos = sprintf($pedidos);
    // executa a query dos pedidos
    $dadospedidos = mysqli_query($con, $querypedidos);
    // transforma os dados dos pedidos em um array
    $linhapedidos = mysqli_fetch_assoc($dadospedidos);
    // calcula quantos dados dos pedidos retornaram
    $totalpedidos = mysqli_num_rows($dadospedidos);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste</title>
    <?php
	// se o número de resultados for maior que zero, mostra os dados
	if($totalpedidos > 0) {
		// inicia o loop que vai mostrar todos os dados
		do {
?>
            <table>
              <tr>
                <th style="background-color: gray;">Pedido:</th>
                <th><?=$linhapedidos['num_pedido']?></th>
                <th>Cliente: </th>
                <th><?=$linhapedidos['nom_cliente']?></th>
                <th>botoes</th>
              </tr>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
          </table>
          <b>Total: </b>
          <br>
<?php
		// finaliza o loop que vai mostrar os dados
        // fim do if
    }while($linhapedidos = mysqli_fetch_assoc($dadospedidos));
	}
?>
</head>
<body>
    
</body>
</html>