<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['email']) && isset($_POST['password'])) {
    if ($db->dbConnect()) {
        $user = $db->logIn("usuarios", $_POST['email'], $_POST['password']);
        echo json_encode($user);
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>
