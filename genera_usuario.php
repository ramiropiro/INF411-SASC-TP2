<?php
// need to decode JSON, if you don't use JSON just pass the $_POST to clean_data()
$apellido = $_POST['apellido'];
$direccion = $_POST['direccion'];

// MySQL portion
$conn = mysqli_connect("localhost", "root", "");
$query = "INSERT INTO cafe_corrientes.clientes (apellido, direccion) VALUES ('$apellido', '$direccion')";
$result = mysqli_query($conn, $query);
$last_id = mysqli_insert_id($conn);

if($result) {
    echo $last_id;
} else {
    "Something went wrong.";
}

?>