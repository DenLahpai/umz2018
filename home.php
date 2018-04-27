<?php
require_once "functions.php";
$orderby = "ORDER BY Id";
$rows_users = get_users(NULL, $orderby);
var_dump($rows_users);
?>
