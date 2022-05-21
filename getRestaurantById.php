<?php
require "DataBase.php";
$db = new DataBase();

if ($db->dbConnect()) {
    $restaurant = $db->getRestaurantById($_POST['table'], $_POST['id']);
    echo json_encode($restaurant);
} else echo "Error: Database connection";

?>