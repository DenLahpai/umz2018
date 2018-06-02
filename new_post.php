<?php
require_once "functions.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    table_post('insert', NULL);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <?php
        $page_title = "New Post";
        include "includes/head.html";
        ?>
    </head>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "includes/main_menu.html";
            $header = 'New Posts';
            include "includes/header.html";
            ?>
            <main>
                <form id="new_post" action="#" method="post">
                    <ul>
                        <li>
                            Subject: &nbsp; <input type="text" class="wide" name="Subject" id="Subject" placeholder="Subject of your post!">
                        </li>
                        <li>
                            <textarea name="Post" class="wide" id="Post" rows="8" cols="36" placeholder="Write your annoucement here!"></textarea>
                        </li>
                        <li>
                            <button type="button" class="button medium" id="buttonSubmit" name="buttonSubmit" onclick="check2Fields('Subject','Post')">Submit</button>
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html";?>
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
</html>
