<?php
require "../conn.php";

//loggin in
$Username = $_REQUEST['Username'];
$Password = $_REQUEST['Password'];

$database = new Database();
$part2 = "";
$query = "SELECT * FROM users
    WHERE BINARY Username = :Username
    AND BINARY Password = :Password
;";
$database->query($query);
$database->bind(':Username', $Username);
$database->bind(':Password', $Password);
$rowCount = $database->rowCount();
$rows_users = $database->resultset();
if($rowCount > 0) {
    header("location:home.php");
    foreach ($rows_users as $row_users) {
        $_SESSION['usersId'] = $row_users->Id;
    }
}
else {
    header("location:index.php?error=1");
}

?>
