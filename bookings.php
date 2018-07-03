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
    $rows_drivers = table_drivers('select', NULL);
}
else {
    $rows_drivers = table_drivers('search', $search);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Bookings";
    include_once "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "includes/main_menu.html";
            $header = "Bookings";
            include "includes/header.html";
            ?>
            <!-- sub-menu -->
            <div class="sub-menu">
                <form action="#" method="post">
                    <ul>
                        <li>
                            <a href="new_booking.php">
                                <button type="button" class="button medium" name="button">Create New Booking</button></a>
                        </li>
                        <li>
                            <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search Bookings">
                            <button type="submit" class="button search" name="buttonSearch">Search</button>
                        </li>
                    </ul>
                </form>
            </div>
            <!-- end of sub-menu -->
        </div>
        <!-- end of content  -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
