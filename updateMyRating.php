<?php
require "DataBase.php";
$db = new DataBase();
if ($db->dbConnect()) {
    if ($db->updateMyRating($_POST['restaurant_id'], $_POST['usuario_id'], $_POST['calificacion'])) {
        echo "Data get";
    } else echo "Algo salio mal";
} else echo "Error: Database connection";
?>
