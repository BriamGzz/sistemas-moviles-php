<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['name']) && isset($_POST['desc']) && isset($_POST['inicio']) && isset($_POST['cierre']) && isset($_POST['precio']) && isset($_POST['categoria']) && isset($_POST['usuario'])) {
    if ($db->dbConnect()) {
        if ($db->newRestaurant($_POST['name'], $_POST['desc'], $_POST['inicio'], $_POST['cierre'], $_POST['precio'], $_POST['categoria'], $_POST['usuario'], $_POST['image'])) {
            echo "Restaurante Creado";
        } else echo "Fallo creando restaurante";
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>
