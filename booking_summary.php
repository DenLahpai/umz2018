<?php
require "functions.php";

//getting bookingsId
$bookingsId = trim($_REQUEST['bookingsId']);

//getting data from the table bookings
$rows_bookings = table_bookings('select', $bookingsId);
foreach ($rows_bookings as $row_bookings) {
    // code...
}

//checking if the user has the right to view this page
$rows_users = table_users('select', $_SESSION['usersId']);
foreach ($rows_users as $row_users) {
    $DepartmentId = $row_users->DepartmentId;
}
switch ($DepartmentId) {
    case '5':
        if ($row_bookings->agentsName != 'Exo Travel') {
            header("location: logout.php");
        }
        break;
    case '6':
        if ($row_bookings->agentsName != 'Tour Mandalay') {
            header("location: logout.php");
        }
        break;
    case '7':
        if ($row_bookings->agentsName == 'Exo Travel' || $row_bookings->agentsName == 'Tour Mandalay') {
            header("location: logout.php");
        }
        break;

    default:
        // code...
        break;
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
            <main>
                <div class="grid-div">
                    <?php

                    ?>
                </div>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
