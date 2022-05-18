<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['email'])) {
    if ($db->dbConnect()) {
        $restaurants = $db->getAllRestaurants("restaurantes");
        echo json_encode($restaurants);
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>