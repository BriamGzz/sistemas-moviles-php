<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['email'])) {
    if ($db->dbConnect()) {
        $thisUser = $db->getUser("usuarios", $_POST['email']);
        echo json_encode($thisUser);
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>