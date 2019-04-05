<?php
require_once "functions.php";

//getting data from the table
if (isset($_REQUEST['buttonSearch'])) {
    $search = $_REQUEST['search'];
}
else {
    $search = NULL;
}

if(empty($search) || $search == NULL || $search == "") {
    $rows_posts = table_posts('select_all', NULL, NULL);
}
else {
    $rows_posts = table_posts('search', $search, NULL);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <?php
        $page_title = "Posts";
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
                <form action="#" method="post">
                <ul>
                    <li>
                        <a href="new_post.php">
                            <button type="button" class="button medium" name="button">New Post</button></a>
                    </li>
                    <li>
                        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search Posts">
                        <button type="submit" class="button search" name="buttonSearch">Search</button>
                    </li>
                </ul>
                </form>
            </div>
            <!-- end of sub-menu -->
            <main>
                <!-- grid-div -->
                <div class="grid-div">
                <?php
                foreach ($rows_posts as $row_posts) {
                    echo "<!-- grid-item -->";
                    echo "<div class=\"grid-item\">";
                    echo "<ul>";
                    echo "<li><h4>Subject:&nbsp;".$row_posts->Subject."</h4></li>";
                    echo "<li>".$row_posts->Post."</li>";
                    echo "<li style=\"font-style:italic; \"><span style=\"color: blue;\">".$row_posts->Fullname."</span>";
                    echo "&nbsp;on ".$row_posts->Created."</li>";
                    echo "<li><a href=\"edit_post.php?postsId=$row_posts->postsId\"><button class=\"button link\">Edit</button></a></li>";
                    echo "</ul>";
                    echo "</div>";
                    echo "<!-- end of grid-item -->";
                }
                ?>
                </div>
                <!-- end of grid-div -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
