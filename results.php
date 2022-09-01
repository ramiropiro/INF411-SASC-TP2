<!DOCTYPE html>
<html>

<head>
    <title>Smart Cart - jQuery Shopping Cart Plugin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Include Bootstrap CSS -->
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../node_modules/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />

</head>

<body>
    <?php
    require 'conectar.php';
    // Resultados del pedido
    $product_list = filter_input(INPUT_POST, 'cart_list');
    $user_id = filter_input(INPUT_POST, 'user_id');

    //Obtener Datos Usuario
    $consultaCliente = 'SELECT * FROM clientes WHERE id=' . $user_id;
    $resCliente = mysqli_query($mysqli, $consultaCliente);
    $rowCliente = mysqli_fetch_assoc($resCliente);

    // Convert JSON to array
    $product_list_array = json_decode($product_list);
    $result_html = '';
    $sub_cant = 0;
    $sub_precio = 0;
    $total = 0;
    if ($product_list_array) {
        foreach ($product_list_array as $p) {
            foreach ($p as $key => $value) {
                //var_dump($key, $value);
                $result_html .= $key . ": " . $value . "<br />";
                //Calcula Total
                if ($key == 'product_quantity') {
                    $sub_cant = $value;
                }
                if ($key == 'product_price') {
                    $sub_precio = $value;
                }
            }
            $total = $total + ($sub_cant * $sub_precio);
            $result_html .= '------------------------------------------<br />';
        }
    } else {
        $result_html .= "<strong>Cart is Empty</strong>";
    }
    ?>

    <br />
    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Información Procesada del Pedido </br>
                        Nombre: <strong><?php echo $rowCliente['apellido']; ?></strong> </br>
                        Dirección: <strong><?php echo $rowCliente['direccion']; ?></strong>
                    </div>
                    <br />
                    <div class="panel-body">
                        Resultado en formáto JSON
                        <hr />
                        <code>
                            <?= isset($product_list) ? $product_list : '' ?>
                        </code>
                        <br /><br />
                        Ticket HTML
                        <hr />
                        <?= isset($result_html) ? $result_html : '' ?>
                        <strong><?php echo "Total a pagar: $ ".number_format($total, 2); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>