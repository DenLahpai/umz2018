<?php
require "../conn.php";
// checking if a user is logged in
if (!isset($_SESSION['usersId'])){
    header("location:index.php?error=2");
}

//function to get data from the table users
function get_users($usersId, $orderby) {
    $database = new Database();

    if ($usersId == NULL) {
        $query = "SELECT * FROM users; ".$orderby;
        $database->query($query);
    }
    else {
        $query = "SELECT * FROM users WHERE Id = :usersId; ";
        $database->query($query);
        $database->bind(':usersId', $usersId);
    }
    return $r = $database->resultset();
}

?>
