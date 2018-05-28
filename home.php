<?php
require_once "functions.php";

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <?php
        $title = "Posts";
        include "includes/head.html";
        ?>
    </head>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "includes/main_menu.html";
            $header = 'Posts';
            include "includes/header.html";
            ?>
            <div class="sub-menu">
            <!-- sub-menu -->
                <form action="" method="post">
                <ul>
                    <li>
                        <a href="new_post.php">
                            <button type="button" class="button medium" name="button">New Post</button></a>
                    </li>
                    <li>
                        <input type="text" name="search" placeholder="Search Posts">
                        <button type="submit" class="button search" name="buttonSearch">Search</button>
                    </li>
                </ul>
                </form>
            </div>
            <!-- end of sub-menu -->
            <section>
                <!-- TODO get data from the table Posts -->
            </section>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
