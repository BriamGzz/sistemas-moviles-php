<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['usuario_id'])) {
    if ($db->dbConnect()) {
        $dates = $db->getDatesByUser($_POST['usuario_id']);
        echo json_encode($dates);
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>