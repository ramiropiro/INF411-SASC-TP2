<!DOCTYPE html>
<html>
<head>
    <title>Registro Café Corrientes</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css"/>
</head>
<body>
<?php
    require 'conectar.php';
    if (isset($_REQUEST['usuario'])) {
        $usuario = stripslashes($_REQUEST['usuario']);
        $usuario = mysqli_real_escape_string($mysqli, $usuario);
        $apellido    = stripslashes($_REQUEST['apellido']);
        $apellido    = mysqli_real_escape_string($mysqli, $apellido);
        $nombres    = stripslashes($_REQUEST['nombres']);
        $nombres    = mysqli_real_escape_string($mysqli, $nombres);
        $direccion    = stripslashes($_REQUEST['direccion']);
        $direccion    = mysqli_real_escape_string($mysqli, $direccion);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($mysqli, $password);
        $create_datetime = date("Y-m-d H:i:s");
        $query = "INSERT into `clientes` (usuario, password, direccion, apellido, nombres) VALUES ('$usuario', '" . md5($password) . "', '$direccion', '$apellido', '$nombres')";
        $result   = mysqli_query($mysqli, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>Registro Exitoso!!!.</h3><br/>
                  <p class='link'>Click para iniciar sesión to <a href='login.php'>Iniciar Sesión</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Todos los campos son requeridos.</h3><br/>
                  <p class='link'>Clieck para <a href='registration.php'>registrar</a> nuevamente.</p>
                  </div>";
        }
    } else {
?>
    <form class="form" action="" method="post">
        <h1 class="login-title"><img src="img/logo.jpg"></h1>
        <input type="text" class="login-input" name="apellido" placeholder="Apellido">
        <input type="text" class="login-input" name="nombres" placeholder="Nombres">
        <input type="text" class="login-input" name="direccion" placeholder="Dirección">
        <input type="text" class="login-input" name="usuario" placeholder="Usuario" required />
        <input type="password" class="login-input" name="password" placeholder="Password">
        <input type="submit" name="submit" value="Registrarse" class="login-button">
        <p class="link"><a href="login.php">Iniciar Sesión</a></p>
    </form>
<?php
    }
?>
</body>
</html>