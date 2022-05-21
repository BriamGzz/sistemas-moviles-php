<?php
require "DataBase.php";
$db = new DataBase();

if ($db->dbConnect()) {
    $rating = $db->getMyRating($_POST['restaurant_id'], $_POST['usuario_id']);
    echo json_encode($rating);
} else echo "Error: Database connection";

?>