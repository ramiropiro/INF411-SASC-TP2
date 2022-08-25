<?php
require 'conectar.php';
$query = 'SELECT * FROM productos';
$res = mysqli_query($mysqli, $query);
//$row = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>

<head>
    <title>jQuery Smart Cart - The smart interactive jQuery Shopping Cart plugin with PayPal payment support</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- Include SmartCart CSS -->
    <link href="dist/css/smart_cart.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <br />
    <section class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Productos
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <!-- BEGIN PRODUCTS -->
                            <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                                <div class="col-md-4 col-sm-6">
                                    <div class="sc-product-item thumbnail">
                                        <img data-name="product_image" src="<?php echo $row["imagen"]; ?>">
                                        <div class="caption">
                                            <h4 data-name="product_name"><?php echo $row["descripcion"]; ?></h4>
                                            <p data-name="product_desc"><?php echo $row["descripcion"]; ?></p>
                                            <hr class="line">

                                            <div>
                                                <div class="form-group2">
                                                    <input class="sc-cart-item-qty" name="product_quantity" min="1" max="<?php echo $row["stock"]; ?>" value="1" type="number">
                                                </div>
                                                <strong class="price pull-left">$<?php echo $row["precio_unitario"]; ?></strong>

                                                <input name="product_price" value="<?php echo $row["precio_unitario"]; ?>" type="hidden" />
                                                <input name="product_id" value="<?php echo $row["codigo"]; ?>" type="hidden" />
                                                <!-- CONTROL STOCK -->
                                                <?php if($row["stock"]<$row["stock_minimo"]) { ?>
                                                <button class="sc-add-to-cart btn btn-danger btn-sm pull-right" disabled>Sin Stock</button>
                                                <?php } else { ?>
                                                <button class="sc-add-to-cart btn btn-primary btn-sm pull-right">Agregar</button>
                                                <?php } ?>
                                                <!-- CONTROL STOCK -->
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                            $mysqli->close(); ?>
                            <!-- END PRODUCTS -->
                        </div>
                    </div>
                </div>

            </div>

            <aside class="col-md-4">

                <!-- Cart submit form -->
                <form action="results.php" method="POST">
                    <!-- SmartCart element -->
                    <div id="smartcart"></div>
                </form>

            </aside>
        </div>
    </section>

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
    <!-- Include SmartCart -->
    <script src="dist/js/jquery.smartCart.min.js" type="text/javascript"></script>
    <!-- Initialize -->
    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize Smart Cart    	
            $('#smartcart').smartCart({
                lang: {
                    cartTitle: "Tu Pedido",
                    checkout: 'Proceder',
                    clear: 'Limpiar',
                    subtotal: 'Subtotal:',
                    cartRemove: '×',
                    cartEmpty: 'Pedido Vacío!<br />Elije Productos'
                },
                currencySettings: {
                    locales: 'es-AR',
                    currencyOptions: {
                        style: 'currency',
                        currency: 'ARS',
                        currencyDisplay: 'symbol'
                    }
                },

            }).on("quantityUpdated", function(eobj, qty) {
                var product_id = obj.attr("product_id");
                var quantity = obj.attr("product_quantity");
            });
        });
    </script>
</body>

</html>