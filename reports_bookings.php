<?php
require_once "functions.php";
require_once "functions_reports.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    reports_bookings (NULL, NULL, NULL);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Bookings Reports";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Bookings Reports";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <!-- report form -->
                <div class="report form">
                    <form class="" action="#" method="post">
                        <ul>
                            <li>
                                Agent:
                                <select name="AgentId">
                                    <option value="">Select One</option>
                                    <?php
                                    $rows_agents = table_agents ('select_all', NULL, NULL);
                                    foreach ($rows_agents as $row_agents) {
                                        if ($row_report_bookings->AgentsId == $row_agents->Id) {
                                            echo "<option value=\"$row_agents->Id\" selected>$row_agents->Name</option>";
                                        }
                                        else {
                                            echo "<option value=\"$row_agents->Id\">$row_agents->Name</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                &nbsp;
                                Status:
                                <select name="StatusId">
                                    <option value="">Select One</option>
                                    <?php
                                    $rows_booking_statuses = table_booking_statuses ('select_all', NULL, NULL);
                                    foreach ($rows_booking_statuses as $row_booking_statuses) {
                                        if ($row_report_bookings->StatusId == $row_booking_statuses->Id) {
                                            echo "<option value=\"$row_booking_statuses->Id\" selected>$row_booking_statuses->Status</option>";
                                        }
                                        else {
                                            echo "<option value=\"$row_booking_statuses->Id\">$row_booking_statuses->Status</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                Guide Request:
                                <select name="Guide_RequestId">
                                    <option value="">Select One</option>
                                    <?php
                                    $rows_guide_requests = table_guide_requests ('select_all', NULL, NULL);
                                    foreach ($rows_guide_requests as $row_guide_requests) {
                                        if ($row_report_bookings->Guide_RequestsId == $row_guide_requests->Id) {
                                            echo "<option value=\"$row_guide_requests->Id\" selected>$row_guide_requests->Request</option>";
                                        }
                                        else {
                                            echo "<option value=\"$row_guide_requests->Id\">$row_guide_requests->Request</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                &nbsp;
                                Guide:
                                <select name="Tour_GuideId">
                                    <option value="">Select One</option>
                                    <?php
                                    $rows_tour_guides = table_tour_guides ('select_all', NULL, NULL);
                                    foreach ($rows_tour_guides as $row_tour_guides) {
                                        if ($row_report_bookings->Tour_GuideId == $row_tour_guides->Id) {
                                            echo "<option value=\"$row_tour_guides->Id\" selected>$row_tour_guides->Name</option>";
                                        }
                                        else {
                                            echo "<option value=\"$row_tour_guides->Id\">$row_tour_guides->Name</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </li>
                            <li class="bold">
                                Arrival Date
                            </li>
                            <li>
                                From:
                                <input type="date" name="Arrival_Date1">
                                &nbsp;
                                To:
                                <input type="date" name="Arrival_Date2">
                            </li>
                            <li>
                                <button type="submit" class="button medium" name="buttonSubmit" id="buttonSubmit">Generate Report</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of report form -->
            </main>
        </div>
        <!-- end of content -->
    </body>
</html>
