<?php
require 'conectar.php';

$apellido = $_POST['apellido'];
$direccion = $_POST['direccion'];

$query = "INSERT INTO clientes (apellido, direccion) VALUES ('.$apellido.', '.$direccion.')";
$result = mysqli_query($mysqli, $query);
$last_id = mysqli_insert_id($mysqli);

if($result) {
    echo $last_id;
} else {
    "Something went wrong.";
}

?>