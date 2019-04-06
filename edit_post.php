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
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Post";
    include "includes/head.html";
    ?>
    <body>

    </body>
</html>
