<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['secondname']) && 
    isset($_POST['email']) && isset($_POST['password'])) {
    if ($db->dbConnect()) {
        $wasUpdated = $db->updateUser("usuarios", $_POST['id'], $_POST['name'], $_POST['secondname'], $_POST['email'], $_POST['password'], $_POST['image']);
        if($wasUpdated) {
            echo "Cambios realizados con exito";
        }else echo "Cambios NO realizados";
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>