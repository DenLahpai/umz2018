<?php
require "functions.php";

//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

//getting data from the table
if (isset($_REQUEST['buttonSearch'])) {
    $search = $_REQUEST['search'];
}
else {
    $search = NULL;
}

// if(empty($search) || $search == NULL || $search == "") {
//     $rows_services = table_services('select', NULL);
// }
// else {
//     $rows_services = table_services('search', $search);
// }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Services";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Services";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <!-- sub-menu -->
            <div class="sub-menu">
                <form action="#" method="post">
                <ul>
                    <li>
                        <a href="new_service.php">
                            <button type="button" class="button medium" name="button">Create New Service</button></a>
                    </li>
                    <li>
                        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search Services">
                        <button type="submit" class="button search" name="buttonSearch">Search</button>
                    </li>
                </ul>
                </form>
            </div>
            <!-- end of sub-menu -->
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
