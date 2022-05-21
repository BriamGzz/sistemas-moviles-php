<?php
require "DataBase.php";
$db = new DataBase();

if ($db->dbConnect()) {
    $search = $db->searchForRestaurant($_POST['nombre'], $_POST['categoria'], $_POST['order'], $_POST['ascdsc']);
    echo json_encode($search);
} else echo "Error: Database connection";

?>