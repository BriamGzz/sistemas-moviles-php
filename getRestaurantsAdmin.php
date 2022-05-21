<?php
require "DataBase.php";
$db = new DataBase();

if ($db->dbConnect()) {
    if($_POST['admin'] == "2") {
        $restaurant = $db->getRestaurantsAdmin();
        echo json_encode($restaurant);
    }
    else { 
        echo("Necesitas ser admin\n usuario encontrado: ");
        echo $_POST['admin'];
    }
} else echo "Error: Database connection";

?>