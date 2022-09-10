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
    include("auth_session.php");
    // Resultados del pedido
    $product_list = filter_input(INPUT_POST, 'cart_list');
    //Inserta Nueva Venta
    try {
        $consultaVenta = 'INSERT INTO pedidos (clientes_id, forma_pagos_id, fecha_pedido) VALUES ('.$_SESSION['id_usuario'].', 3, NOW())';
        $resVenta = mysqli_query($mysqli, $consultaVenta);
        $idVenta = mysqli_insert_id($mysqli);
    } catch (mysqli_sql_exception $e) {
        var_dump($e);
        exit;
    }
    // Convert JSON to array
    $product_list_array = json_decode($product_list);
    $result_html = '';
    //Variables de cálculo de total
    $sub_cant = 0;
    $sub_precio = 0;
    $total = 0;
    //Variables de descuento de stock
    $producto_id = '';
    $producto_stock = 0;
    $nuevoValor = 0;
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
                if ($key == 'product_id') {
                    $producto_id = $value;
                }
                if ($key == 'product_stock') {
                    $producto_stock = $value;
                }
            }
            //Calculo total a pagar
            $total = $total + ($sub_cant * $sub_precio);
            //Update de stock
            $nuevoValor = $producto_stock - $sub_cant;
            try {
                //Actualiza Stock
                $updateStock = "UPDATE productos SET stock=" . $nuevoValor . " WHERE id='" . $producto_id."'";
                $resStock = mysqli_query($mysqli, $updateStock);
                //Inserta detalle Pedido
                $detalleVenta = "INSERT INTO detalle_pedidos (pedidos_id, productos_id, precio_unitario, cantidad) VALUES (".$idVenta.", ".$producto_id.", ".$sub_precio.", ".$sub_cant.")";
                $resDetalle = mysqli_query($mysqli, $detalleVenta);               
            } catch (mysqli_sql_exception $e) {
                var_dump($e);
                exit;
            }
            $result_html .= '------------------------------------------<br />';
        }
    } else {
        $result_html .= "<strong>Pedido Vacío</strong>";
    }
    ?>

    <br />
    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Información Procesada del Pedido </br>
                        Nombre: <strong><?php echo $_SESSION['apellido'].', '.$_SESSION['nombres']; ?></strong> </br>
                        Dirección: <strong><?php echo $_SESSION['direccion']; ?></strong>
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
                        <strong><?php echo "Total a pagar: $ " . number_format($total, 2); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>