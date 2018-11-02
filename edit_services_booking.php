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

//getting data from the table vehicles
$rows_vehicles = table_vehicles('select', NULL);

//getting data from the table drivers
$rows_drivers = table_drivers('select', NULL);

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
                <form id="theform" action="#" method="post">
                    <ul>
                        <li class="notice error">
                            <?php
                            if (!empty($error_message)) {
                                echo $error_message;
                            }
                            ?>
                        </li>
                        <li style="font-weight: bold;">
                            Service: &nbsp;
                            <?php echo $row_services_booking->service_typesCode." - ".$row_services_booking->Service; ?>
                        </li>
                        <li>
                            Date: &nbsp;
                            <input type="date" name="Service_Date" value="<?php echo $row_services_booking->Service_Date; ?>">
                        </li>
                        <li>
                            Pickup: &nbsp;
                            <input type="text" name="Pickup" id="Pickup" value="<?php echo $row_services_booking->Pickup; ?>">
                            @
                            <input type="time" name="Pickup_Time" value="<?php echo $row_services_booking->Pickup_Time;?>">
                        </li>
                        <li>
                            Dropoff: &nbsp;
                            <input type="text" name="Dropoff" id="Dropoff" value="<?php echo $row_services_booking->Dropoff; ?>">
                            @
                            <input type="time" name="Dropoff_Time" value="<?php echo $row_services_booking->Dropoff_Time; ?>">
                        </li>
                        <li>
                            Assign Vehicle: &nbsp;
                            <select name="VehicleId" id="Vehicleid">
                                <option value="0">Select One</option>
                                <?php
                                foreach ($rows_vehicles as $row_vehicles) {
                                    echo "<option value=\"$row_vehicles->Id\">".$row_vehicles->Type." - ".$row_vehicles->License."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            Assign Driver: &nbsp;
                            <select name="DriverId" id="DriverId">
                                <option value="0">Select One</option>
                                <?php
                                foreach ($rows_drivers as $row_drivers) {
                                    echo "<option value=\"$row_drivers->Id\">".$row_drivers->Name."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit"
                            onclick="check2Fields('Pickup','Dropoff');">Update</button>
                        </li>
                    </ul>
                </form>
                <?php
                // switch ($row_services_booking->Service_TypeId) {
                //     case '1':
                //         // TODO
                //         break;
                //
                //     case '2':
                //         // TODO
                //         break;
                //
                //     case '3':
                //         // TODO
                //         break;
                //
                //     case '4':
                //         include "edit_services_booking_forms/guide.html";
                //         break;
                //
                //     case '5':
                //         // TODO
                //         break;
                //     default:
                //         // code...
                //         break;
                // }
                ?>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
</html>
