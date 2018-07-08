<?php
require "functions.php";

//getting bookingsId
$bookingsId = trim($_REQUEST['bookingsId']);

//getting data from the table bookings
$rows_bookings = table_bookings('select', $bookingsId);
foreach ($rows_bookings as $row_bookings) {
    // code...
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Booking Summary";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Booking Summary: ";
            $header .= $row_bookings->Reference;
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <section>
                <?php include "includes/booking_menu.html"; ?>    
            </section>
        </div>
        <!-- end of content -->
    </body>
</html>
