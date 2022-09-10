<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css"/>
</head>
<body>
<?php
    require 'conectar.php';
    session_start();
    if (isset($_POST['usuario'])) {
        $usuario = stripslashes($_REQUEST['usuario']);
        $usuario = mysqli_real_escape_string($mysqli, $usuario);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($mysqli, $password);
        $query    = "SELECT * FROM `clientes` WHERE usuario='$usuario'
                     AND password='" . md5($password) . "'";
        $result = mysqli_query($mysqli, $query);
        $rows = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        if ($rows == 1) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['id_usuario'] = $row['id'];
            $_SESSION['apellido'] = $row['apellido'];
            $_SESSION['nombres'] = $row['nombres'];
            $_SESSION['direccion'] = $row['direccion'];
            header("Location: index.php");
        } else {
            echo "<div class='form'>
                  <h3>Contraseña o Usuario Incorrectos.</h3><br/>
                  <p class='link'>Click para <a href='login.php'>Iniciar Sesión</a> nuevamente.</p>
                  </div>";
        }
    } else {
?>
    <form class="form" method="post" name="login">
        <h1 class="login-title"><img src="img/logo.jpg"></h1>
        <input type="text" class="login-input" name="usuario" placeholder="Usuario" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Password"/>
        <input type="submit" value="Iniciar Sesión" name="submit" class="login-button"/>
        <p class="link"><a href="registration.php">Registrarse</a></p>
  </form>
<?php
    }
?>
</body>
</html>