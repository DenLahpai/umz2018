<?php
require_once "functions.php";

//getting posts Id
$postsId = trim($_REQUEST['postsId']);

if (!is_numeric ($postsId)) {
    echo "There has been an error! Please go back and try again!";
    die();
}

$rows_posts = table_posts ('select_one', $postsId, NULL);
foreach ($rows_posts as $row_posts) {
    // code...
}

if ($_SESSION['usersId'] != $row_posts->UsersId) {
    echo "Only the user can edit this post!";
    die();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Post";
    include "includes/head.html";
    ?>
    <body>
        <?php
        $header = "Edit Post";
        include "includes/header.html";
        include "includes/main_menu.html";
        ?>
    </body>
</html>
