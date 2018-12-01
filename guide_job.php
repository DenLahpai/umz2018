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
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles/print.css">
        <link rel="Shortcut icon" href="images/Logo_small.png"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Guide Job Order</title>
	</head>
    <body>
        <!-- content -->
        <div class="content">
            <header>
                <h2>
                    Guide Job Order:
                </h2>
            </header>
            <main>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Service</th>
                            <th>Pickup</th>
                            <th>Dropoff</th>
                            <th>Guide Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rows_guide = table_services_booking('guide_job', $bookingsId);
                        foreach($rows_guide as $row_guide) {
                            echo "<tr>";
                            echo "<td>".date("d-M-y", strtotime($row_guide->Service_Date))."</td>";
                            echo "<td>".$row_guide->Service."</td>";
                            echo "<td>";
                            if (!empty($row_guide->Pickup)) {
                                echo $row_guide->Pickup." @ ".date("H:i", strtotime($row_guide->Pickup_Time));
                            }
                            echo "</td>";
                            echo "<td>";
                            if (!empty($row_guide->Dropoff)) {
                                echo $row_guide->Dropoff." @ ".date("H:i", strtotime($row_guide->Dropoff_Time))."</td>";
                            }
                            // TODO review it.
                            echo "</td>";
                            echo "<td>".$row_guide->tour_guidesName."</td>";
                            echo "<td>".$row_guide->service_statusesCode."</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </main>
        </div>
        <!-- end of content -->
    </body>
</html>
