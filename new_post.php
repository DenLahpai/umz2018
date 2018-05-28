<?php
require_once "functions.php";
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
                <form class="" action="#" method="post">
                    <ul>
                        <li>
                            Title: &nbsp; <input type="text" name="" value="">
                        </li>
                        <li>
                            <textarea name="name" rows="8" cols="36" placeholder="Write your annoucement here!"></textarea>
                        </li>
                        <li>
                            <button type="submit" class="button medium" name="button">Submit</button>
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html";?>
    </body>
</html>
