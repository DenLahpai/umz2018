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

if ($_SESSION['usersId'] != $row_posts->UserId) {
    echo "Only the user can edit this post!";
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    table_posts ('update', $postsId, NULL);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Post";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit Post";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <form id="theform" action="#" method="post">
                    <ul>
                        <li>
                            Subject: &nbsp; <input type="text" class="wide" name="Subject" id="Subject" value="<? echo $row_posts->Subject;?>">
                        </li>
                        <li>
                            <textarea name="Post" class="wide" id="Post" rows="8" cols="36" placeholder="Write your annoucement here!"><? echo $row_posts->Post;?></textarea>
                        </li>
                        <li>
                            <button type="button" class="button medium" id="buttonSubmit" name="buttonSubmit" onclick="check2Fields('Subject','Post')">Update</button>
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
</html>
