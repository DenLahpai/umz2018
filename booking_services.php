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

if (isset($_REQUEST['buttonSubmit'])) {
    $Service_TypeId = $_REQUEST['Service_TypeId'];
    $Service_Date = $_REQUEST['Service_Date'];
    $rows_services = search_services($Service_TypeId);
}

if (isset($_REQUEST['buttonAdd'])) {
    table_services_booking('insert', $bookingsId, NULL);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Services Booking";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Add Service for $row_bookings->Reference";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <section>
                <?php include "includes/booking_menu.html"; ?>
            </section>
            <main>
                <form id="theform" action="#" method="post">
                    <ul>
                        <li>
                            <?php
                            if (!empty($error_message)) {
                                echo $error_message;
                            }
                            ?>
                        </li>
                        <li>
                            Service Type:
                            <select id="Service_TypeId" name="Service_TypeId">
                                <option value="">Select</option>
                                <?php
                                $rows_service_types = table_service_types('select_all', NULL,  NULL);
                                foreach ($rows_service_types as $row_service_types) {
                                    echo "<option value=\"$row_service_types->Id\">".$row_service_types->Code." - ".$row_service_types->Name."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            Service Date:
                            <input type="date" name="Service_Date" id="Service_Date" value="<?php echo $Service_Date; ?>">
                        </li>
                        <li>
                            <button type="submit" class="button medium" name="buttonSubmit" id="buttonSubmit">Search</button>
                        </li>
                    </ul>
                </form>
                <!-- table_services -->
                <div class="table_services">
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Supplier</th>
                                <th>Service</th>
                                <th>Additonal</th>
                                <th>Remark</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($rows_services)) {
                                echo "<tr>";
                                echo "<th colspan=\"6\">Please choose a service to insert</th>";
                                echo "</tr>";
                                foreach ($rows_services as $row_services) {
                                    echo "<form action=\"#\" method=\"post\">";
                                    echo "<tr>";
                                    echo "<td><input type=\"number\" name=\"servicesId\" value=\"$row_services->Id\" min=\"1\" max=\"9999\" readonly></td>";
                                    echo "<td class=\"invisible\"><input type=\"text\" name=\"bookingsId\" value=\"$bookingsId\">";
                                    echo "<input type=\"date\" name=\"Service_Date\" value=\"$Service_Date\"></td>";
                                    echo "<td>".$row_services->suppliersName."</td>";
                                    echo "<td>".$row_services->Service."</td>";
                                    echo "<td>".$row_services->Additional."</td>";
                                    echo "<td>".$row_services->Remark."</td>";
                                    echo "<td><button type=\"submit\" name=\"buttonAdd\" class=\"button link\">Add</button></td>";
                                    echo "</tr>";
                                    echo "</form>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- end of table_services -->
            </main>
            <aside>

            </aside>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
    <script type="text/javascript"></script>
</html>
