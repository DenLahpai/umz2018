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
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles/print.css">
        <link rel="Shortcut icon" href="images/Logo_small.png"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Driver Job Order</title>
	</head>
    <body>
        <!-- content -->
        <div class="content">
            <header>
                <h2>
                    Driver Job Order:
                </h2>
            </header>
            <main>
                <ul>
                    <li>Booking Reference: <? echo $row_bookings->Reference;?></li>
                    <li>Group Name: <? echo $row_bookings->bookingsName; ?></li>
                    <li>Pax: <? echo $row_bookings->bookingsPax; ?></li>
                </ul>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Service</th>
                            <th>Vehicle</th>
                            <th>Driver</th>
                            <th>Pickup</th>
                            <th>Dropoff</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rows_transfers = table_services_booking('driver_job', $bookingsId);
                        foreach ($rows_transfers as $row_transfers) {
                            echo "<tr>";
                            echo "<td>".date("d-m-y", strtotime($row_transfers->Service_Date))."</td>";
                            echo "<td>".$row_transfers->Service."</td>";
                            echo "<td>".$row_transfers->Additional."</td>";
                            echo "<td>".$row_transfers->driversName."</td>";
                            echo "<td>";
                            if (!empty($row_transfers->Pickup)) {
                                echo $row_transfers->Pickup." @ ".date("H:i", strtotime($row_transfers->Pickup_Time));
                            }
                            echo "</td>";
                            echo "<td>";
                            if (!empty($row_transfers->Dropoff)) {
                                echo $row_transfers->Dropoff." @ ".date("H:i", strtotime($row_transfers->Dropoff_Time));
                            }
                            echo "</td>";
                            echo "<td>".$row_transfers->service_statusesCode."</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <!-- signature -->
                <div class="signature">
                    <table>
                        <tr>
                            <th>Issued by:</th>
                            <th>Received by:</th>
                        </tr>
                        <tr>
                            <th><? echo $row_users->Fullname;?></th>
                            <th></th>
                        </tr>
                    </table>
                </div>
                <!-- end of signature -->
            </main>
        </div>
        <!-- end of content -->
    </body>
</html>
