<?php
require "functions.php";

$services_bookingId = trim($_REQUEST['services_bookingId']);
if (!is_numeric ($services_bookingId)) {
    echo "There was an error! Please go back and try again.";
    die();
}
$rows_services_booking = table_services_booking('select_one', $services_bookingId, NULL);

foreach ($rows_services_booking as $row_services_booking) {
    $bookingsId = $row_services_booking->BookingsId;
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

//deleting the service by setting the Visible Field no false
if (isset($_REQUEST['buttonYes'])) {
    $delete = new Database();
    $query_delete = "UPDATE services_booking SET
        Visible = FALSE
        WHERE Id = :services_bookingId
    ;";
    $delete->query($query_delete);
    $delete->bind(':services_bookingId', $services_bookingId);
    if ($delete->execute()) {
        header("location:booking_summary.php?bookingsId=$bookingsId");
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Delete Service";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Delete Service Booking: ";
            $header .= $row_bookings->Reference;
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <section>
                <?php include "includes/booking_menu.html"; ?>
            </section>
            <main>
                <h3>
                    <form class="" action="#" method="post">
                        Are you sure to delete the below service from this booking?
                        <br>
                        <button type="submit" class="button link" name="buttonYes">Yes</button>
                        <button type="button" class="button link" name="button" onclick="goBack();">No</button>
                    </form>
                </h3>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
</html>
