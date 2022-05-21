<?php
require "DataBase.php";
$db = new DataBase();
if ($db->dbConnect()) {
    if ($db->newDate($_POST['usuario_id'], $_POST['restaurante_id'], $_POST['fecha'], $_POST['hora'], $_POST['personas'], $_POST['total'], $_POST['restaurante_nombre'])) {
        echo "Cita agendada correctamente";
    } else echo "Algo salió mal";
} else echo "Error: Database connection";
?>
