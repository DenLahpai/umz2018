<?php
require "functions.php";

//getting bookingsId
$bookingsId = trim($_REQUEST['bookingsId']);
if (!is_numeric ($bookingsId)) {
    echo "There was an error! Please go back and try again.";
    die();
}

//getting data from the table bookings
$rows_bookings = table_bookings('select_one', $bookingsId, NULL);
foreach ($rows_bookings as $row_bookings) {
    // code...
}

//checking if the user has the right to view this page
$rows_users = table_users('select_one', $_SESSION['usersId'], NULL);
foreach ($rows_users as $row_users) {
    $DepartmentId = $row_users->DepartmentId;
}

$rows_services_booking = table_services_booking('select_for_one_booking', $bookingsId, NULL);

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
                <h3>Station Guide</h3>
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    foreach ($rows_services_booking as $row_services_booking) {
                        if ($row_services_booking->service_typesCode == 'GUI') {
                            echo "<!-- grid-item -->";
                            echo "<div class=\"grid-item\">";
                            echo "<ul>";
                            echo "<li style=\"font-weight: bold\">".date("d-M-y", strtotime($row_services_booking->Service_Date))."</li>";
                            echo "<li style=\"font-weight: bold\">".$row_services_booking->Service."</li>";
                            echo "<li>".$row_services_booking->service_typesCode." - ".$row_services_booking->suppliersName."</li>";
                            echo "<li>Pickup: ".$row_services_booking->Pickup." @ ".date('H:i', strtotime($row_services_booking->Pickup_Time))."</li>";
                            echo "<li>Dropoff: ".$row_services_booking->Dropoff." @ ".date('H:i', strtotime($row_services_booking->Dropoff_Time))."</li>";
                            if ($row_services_booking->Tour_GuideId < 1) {
                                echo "<li>Station Guide: Unassigned </li>";
                            }
                            else {
                                echo "<li>Station Guide: ".$row_services_booking->tour_guidesTitle.". ";
                                echo $row_services_booking->tour_guidesName." - ";
                                echo $row_services_booking->tour_guidesMobile."</li>";
                            }
                            echo "<li>Status: ".$row_services_booking->service_statusesCode."</li>";

                            echo "<li style=\"text-align:center;\"><a href=\"edit_services_booking.php?services_bookingId=$row_services_booking->Id\">";
                            echo "<button class=\"button link\">Edit</button></a>&nbsp;";

                            echo "&nbsp;<a href=\"delete_services_booking.php?services_bookingId=$row_services_booking->Id\">";
                            echo "<button class=\"button link\">Delete</button></a></li>";

                            echo "</ul>";
                            echo "</div>";
                            echo "<!-- end of grid-item -->";
                        }
                    }
                    ?>
                </div>
                <!-- end of grid-div -->

                <h3>Transfers</h3>
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    foreach ($rows_services_booking as $row_services_booking) {
                        if ($row_services_booking->service_typesCode == 'TRF') {
                            echo "<!-- grid-item -->";
                            echo "<div class=\"grid-item\">";
                            echo "<ul>";
                            echo "<li style=\"font-weight: bold\">".date("d-M-y", strtotime($row_services_booking->Service_Date))."</li>";
                            echo "<li style=\"font-weight: bold\">".$row_services_booking->Service."</li>";
                            echo "<li>".$row_services_booking->Additional."</li>";
                            echo "<li>".$row_services_booking->service_typesCode." - ".$row_services_booking->suppliersName."</li>";
                            echo "<li>Pickup: ".$row_services_booking->Pickup." @ ".date('H:i', strtotime($row_services_booking->Pickup_Time))."</li>";
                            echo "<li>Dropoff: ".$row_services_booking->Dropoff." @ ".date('H:i', strtotime($row_services_booking->Dropoff_Time))."</li>";

                            if ($row_services_booking->driversName == NULL) {
                                echo "<li>Driver: Unassigned</li>";
                            }
                            else {
                                echo "<li>Driver: ".$row_services_booking->driversName." ($row_services_booking->driversMobile)</li>";
                            }

                            if ($row_services_booking->vehiclesLicense == NULL) {
                                echo "<li>Vehicle: Unassigned</li>";
                            }
                            else {
                                echo "<li>Driver: ".$row_services_booking->vehiclesLicense." ($row_services_booking->vehiclesType)</li>";
                            }

                            if ($row_services_booking->service_statusesCode == NULL) {
                                echo "<li>Status: Unassigned</li>";
                            }
                            else {
                                echo "<li>Status: ".$row_services_booking->service_statusesCode."</li>";
                            }

                            echo "<li style=\"text-align:center;\"><a href=\"edit_services_booking.php?services_bookingId=$row_services_booking->Id\">";
                            echo "<button class=\"button link\">Edit</button></a>&nbsp;";

                            echo "&nbsp;<a href=\"delete_services_booking.php?services_bookingId=$row_services_booking->Id\">";
                            echo "<button class=\"button link\">Delete</button></a></li>";

                            echo "</ul>";
                            echo "</div>";
                            echo "<!-- end of grid-item -->";
                        }
                    }
                    ?>
                </div>
                <!-- end of grid-div -->
                <h3>
                    Boats
                </h3>
                    <!-- grid-div -->
                    <div class="grid-div">
                        <?php
                        foreach ($rows_services_booking as $row_services_booking) {
                            if ($row_services_booking->service_typesCode == 'BOT') {
                            echo "<!-- grid-item -->";
                            echo "<div class=\"grid-item\">";
                            echo "<ul>";
                            echo "<li style=\"font-weight: bold\">".date("d-M-y", strtotime($row_services_booking->Service_Date))."</li>";
                            echo "<li style=\"font-weight: bold\">".$row_services_booking->Service."</li>";

                            echo "<li>".$row_services_booking->service_typesCode." - ".$row_services_booking->suppliersName."</li>";
                            echo "<li>Pickup: ".$row_services_booking->Pickup." @ ".date('H:i', strtotime($row_services_booking->Pickup_Time))."</li>";
                            echo "<li>Dropoff: ".$row_services_booking->Dropoff." @ ".date('H:i', strtotime($row_services_booking->Dropoff_Time))."</li>";

                            if ($row_services_booking->service_statusesCode == NULL) {
                                echo "<li>Status: Unassigned</li>";
                            }
                            else {
                                echo "<li>Status: ".$row_services_booking->service_statusesCode."</li>";
                            }

                            echo "<li style=\"text-align:center;\"><a href=\"edit_services_booking.php?services_bookingId=$row_services_booking->Id\">";
                            echo "<button class=\"button link\">Edit</button></a>&nbsp;";

                            echo "&nbsp;<a href=\"delete_services_booking.php?services_bookingId=$row_services_booking->Id\">";
                            echo "<button class=\"button link\">Delete</button></a></li>";

                            echo "</ul>";
                            echo "</div>";
                            echo "<!-- end of grid-item -->";

                            }
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
