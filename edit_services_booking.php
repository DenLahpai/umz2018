<?php
require "functions.php";

$services_bookingId = trim($_REQUEST['services_bookingId']);
$rows_services_booking = table_services_booking('select_one', $services_bookingId);

foreach ($rows_services_booking as $row_services_booking) {
    $bookingsId = $row_services_booking->BookingsId;
}

// //getting bookingsId
// $bookingsId = trim($_REQUEST['bookingsId']);
//
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

//getting data from the table tour_guides
$rows_tour_guides = table_tour_guides('select', NULL);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Services Booking";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit Service Booking: ";
            $header .= $row_bookings->Reference;
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <section>
                <?php include "includes/booking_menu.html"; ?>
            </section>
            <main>
                <?php
                switch ($row_services_booking->Service_TypeId) {
                    case '1':
                        // TODO
                        break;

                    case '2':
                        // TODO
                        break;

                    case '3':
                        // TODO
                        break;

                    case '4':
                        include "edit_services_booking_forms/guide.html";
                        break;

                    case '5':
                        // TODO
                        break;
                    default:
                        // code...
                        break;
                }
                ?>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
</html>
