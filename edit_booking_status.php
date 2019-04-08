<?php
require "functions.php";

//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

//getting booking_statusesId
$booking_statusesId = trim($_REQUEST['booking_statusesId']);
if (!is_numeric ($booking_statusesId)) {
    echo "There was an error! Please go back and try again.";
    die();
}

//getting data  from the table booking_statuses
$rows_booking_statuses = table_booking_statuses('select_one', $booking_statusesId, NULL);
foreach ($rows_booking_statuses as $row_booking_statuses) {
    // code...
}
//updating the table booking_statuses
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_booking_statuses('check_before_update', NULL, NULL);
    if ($rowCoun == 0) {
        table_booking_statuses ('update', $booking_statusesId, NULL);
    }
    else {
        $error_message = "Duplicate Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Booking Status";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit Booking Status";
            include "includes/head.html";
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
                                        Status: &nbsp;
                                        <input type="text" name="Status" id="Status" value="<?php echo $row_booking_statuses->Status; ?>" required>
                                    </th>
                                    <th>
                                        <button type="button" class="button medium" id="buttonSubmit" name="buttonSubmit" onclick="check2Fields('Status', 'Status');">Update</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($error_message)) {
                                    echo "<tr>";
                                    echo "<th colspan=\"3\" class=\"notice error\">";
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
