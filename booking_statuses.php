<?php
require "functions.php";

//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_booking_statuses('check_before_insert', NULL, NULL);
    if ($rowCount == 0) {
        table_booking_statuses('insert', NULL, NULL);
    }
    else {
        $error_message = "Duplicate Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "booking_statuses.php";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Booking Statuses";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <!-- table medium -->
                <div class="table medium">
                    <form id="theform" action="#" method="post">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>
                                        Status:
                                        <input type="text" name="Status" id="Status" placeholder="Status" required>
                                    </th>
                                    <th>
                                        <button type="button" class="button medium" id="buttonSubmit" name="buttonSubmit" onclick="check2Fields('Status', 'Status');">Create</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($error_message)) {
                                    echo "<tr class=\"notice error\">";
                                    echo "<th colspan=\"3\">".$error_message."</th>";
                                    echo "</tr>";
                                }
                                    $rows_booking_statuses = table_booking_statuses('select_all', NULL, NULL);
                                    foreach ($rows_booking_statuses as $row_booking_statuses) {
                                        echo "<tr>";
                                        echo "<td>".$row_booking_statuses->Id."</td>";
                                        echo "<td>".$row_booking_statuses->Status."</td>";
                                        echo "<td><a href=\"edit_booking_status.php?booking_statusesId=$row_booking_statuses->Id\">";
                                        echo "<button class=\"button link\" type=\"button\">Edit</button></a></td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </form>
                </div>
                <!-- end of table medium -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
