<?php
require "DataBase.php";
$db = new DataBase();

if ($db->dbConnect()) {
    $restaurants = $db->getAllRestaurants($_POST['table']);
    echo json_encode($restaurants);
} else echo "Error: Database connection";

?>