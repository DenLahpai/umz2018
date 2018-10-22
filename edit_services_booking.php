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
                <form id="theform" action="#" method="post">
                    <ul>
                        <li class="notice error">
                            <?php
                            if (!empty($error_message)) {
                                echo $error_message;
                            }
                            ?>
                        </li>
                        <li style="font-weight: bold">
                            Service:
                            <?php
                            echo $row_services_booking->service_typesCode." - ".$row_services_booking->Service;
                            ?>
                        </li>
                        <li>
                            Date:
                            <input type="date" name="Service_Date" value="<?php echo $row_services_booking->Service_Date; ?>">
                        </li>
                        <li>
                            Pickup:
                            <input type="text" name="Pickup" value="<?php echo $row_services_booking->Pickup; ?>">
                            @
                            <input type="time" name="Pickup_Time" value="<?php echo $row_services_booking->Pickup_Time;?>">
                        </li>
                        <li>
                            Dropoff:
                            <input type="text" name="Dropoff" value="<?php echo $row_services_booking->Dropoff; ?>">
                            @
                            <input type="time" name="Dropoff_Time" value="<?php echo $row_services_booking->Dropoff_Time; ?>">
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
</html>
