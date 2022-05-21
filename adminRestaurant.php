<?php
require "DataBase.php";
$db = new DataBase();
if ($db->dbConnect()) {
    if ($db->adminRestaurant($_POST['accepted'], $_POST['restaurant_id'])) {
        echo "Hecho";
    } else echo "Algo salio mal";
} else echo "Error: Database connection";
?>
