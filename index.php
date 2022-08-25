<?php
    require 'conectar.php';
    $query = 'SELECT * FROM productos';
    $res = mysqli_query($mysqli,$query);
    $row = mysqli_fetch_assoc($res);
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
                            <div class="col-md-4 col-sm-6">
                                <div class="sc-product-item thumbnail">
                                    <img data-name="product_image" src="img_productos/chai_late.png">
                                    <div class="caption">
                                        <h4 data-name="product_name"><?php echo $row["descripcion"]; ?></h4>
                                        <p data-name="product_desc">Chai Late Coffe</p>
                                        <hr class="line">

                                        <div>
                                            <strong class="price pull-left">$2,990.50</strong>

                                            <input name="product_price" value="2990.50" type="hidden" />
                                            <input name="product_id" value="12" type="hidden" />
                                            <button class="sc-add-to-cart btn btn-success btn-sm pull-right">Agregar</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
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
                    cartTitle: "Shopping Cart",
                    checkout: 'Checkout',
                    clear: 'Clear',
                    subtotal: 'Subtotal:',
                    cartRemove: '×',
                    cartEmpty: 'Cart is Empty!<br />Choose your products'
                },
                currencySettings: {
                    locales: 'es-AR',
                    currencyOptions: {
                        style: 'currency',
                        currency: 'ARS',
                        currencyDisplay: 'symbol'
                    }
                },
            });
        });
    </script>
</body>

</html>