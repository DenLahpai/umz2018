<?php
require_once "functions.php";

//getting data from the table
if (isset($_REQUEST['buttonSearch'])) {
    $search = trim($_REQUEST['search']);
}
else {
    $search = NULL;
}

if(empty($search) || $search == NULL || $search == "") {
    $rows_bookings = table_bookings('select_all', NULL, NULL);
}
else {
    $rows_bookings = table_bookings('search', $search, NULL);
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
            <main>
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    foreach ($rows_bookings as $row_bookings) {
                        echo "<!-- grid-item -->";
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        echo "<li style=\"font-weight: bold; font-size:large\">".$row_bookings->Reference."</li>";
                        echo "<li style=\"font-weight: bold;\">"
                        .$row_bookings->bookingsName." X ".$row_bookings->bookingsPax."</li>";
                        echo "<li>Arrival: &nbsp;".date('d-M-y', strtotime($row_bookings->Arrival_Date))."</li>";
                        echo "<li>Agent: &nbsp;".$row_bookings->agentsName."</li>";
                        echo "<li>Guide: &nbsp;".$row_bookings->guide_requestsRequest." - ".$row_bookings->tour_guidesTitle.". ".$row_bookings->tour_guidesName."</li>";
                        echo "<li>Status: &nbsp;".$row_bookings->booking_statusesStatus."</li>";
                        echo "<li>Remark: &nbsp;".$row_bookings->Remark."</li>";
                        echo "<li>User: &nbsp;".$row_bookings->Fullname."</li>";
                        echo "<li style=\"text-align:center;\"><a href=\"edit_booking.php?bookingsId=$row_bookings->bookingsId\"><button class=\"button link\">Edit</button></a>";
                        echo "&nbsp;<a href=\"booking_summary.php?bookingsId=$row_bookings->bookingsId\"><button class=\"button link\">Details</button></a></li>";
                        echo "</div>";
                        echo "<!-- end of grid-item -->";
                    }
                    ?>
                </div>
                <!-- end of grid-div -->
            </main>
        </div>
        <!-- end of content  -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
