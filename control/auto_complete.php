<?php

require_once '../clases/auto_complete.php';
$obj = new auto_com();

echo json_encode($obj->auto_com_mod(htmlspecialchars($_GET['term'])));

?>