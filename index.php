<?php
require 'conectar.php';
$query = 'SELECT * FROM productos';
$res = mysqli_query($mysqli, $query);
//$row = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Café Corrientes</title>
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
                                                    <input class="sc-cart-item-qty" name="product_quantity" min="1" value="1" max="<?php echo $row["stock"]; ?>" type="number">
                                                </div>
                                                <strong class="price pull-left">$<?php echo $row["precio_unitario"]; ?></strong>

                                                <input name="product_price" value="<?php echo $row["precio_unitario"]; ?>" type="hidden" />
                                                <input name="product_stock" value="<?php echo $row["stock"]; ?>" type="hidden" />
                                                <input name="product_id" value="<?php echo $row["id"]; ?>" type="hidden" />
                                                <input name="product_codigo" value="<?php echo $row["codigo"]; ?>" type="hidden" />
                                                <!-- CONTROL STOCK -->
                                                <?php if ($row["stock"] < $row["stock_minimo"]) { ?>
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
                    <input name="user_id" value="<?php if(isset($_COOKIE['UserID'])) { echo $_COOKIE["UserID"]; } ?>" type="hidden" />
                </form>

            </aside>
        </div>
    </section>
    <!-- Modal -->

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ingresa tus datos para el envío</h4>
                </div>
                <div class="modal-body">
                    <input name="apellido" placeholder="Nombre completo" class="form-control" id="apellido" type="text" required />
                    <br>
                    <input name="direccion" placeholder="Dirección para enviar" class="form-control" id="direccion" type="text" required />
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="login();">Login</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
    <!-- Include Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> <!-- Include SmartCart -->
    <!-- Include smartCart -->
    <script src="dist/js/jquery.smartCart.js" type="text/javascript"></script>
    <!-- Initialize -->
    <script type="text/javascript">
        $(window).on('load', function() {
            //Si la cookie no existe muestra el modal
            if (document.cookie.indexOf("UserID") < 0) {
                $("#myModal").modal("show");
                $("#myModalClose").click(function() {
                    $("#myModal").modal("hide");
                });
            }
        });
    </script>
    <script type="text/javascript">
        function login() {
            var apellido = $("#apellido").val();
            var direccion = $("#direccion").val();
            //se genera id usuario
            $.ajax({
                type: 'POST',
                url: 'genera_usuario.php',
                data: "apellido=" + apellido + "&direccion=" + direccion,
                success: function( data ) { 
                    document.cookie = "UserID=" + data + "; expires=Tue, 19 Jan 2038 03:14:07 UTC; path=/";
                }
            });
            $("#myModal").modal("hide");
        }
    </script>
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

            }).on("quantityUpdated", function(pObj, quantity) {
                //alert(quantity[0]);
            });
        });
    </script>
</body>

</html>