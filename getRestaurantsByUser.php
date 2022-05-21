<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['usuario_id'])) {
    if ($db->dbConnect()) {
        $restaurants = $db->getRestaurantsByUser($_POST['usuario_id']);
        echo json_encode($restaurants);
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>