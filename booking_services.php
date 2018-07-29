<?php
require "functions.php";

//getting bookingsId
$bookingsId = trim($_REQUEST['bookingsId']);

//getting data from the table bookings
$rows_bookings = table_bookings('select', $bookingsId);
foreach ($rows_bookings as $row_bookings) {
    // code...
}

if (isset($_REQUEST['buttonSubmit'])) {
    $Service_TypeId = $_REQUEST['Service_TypeId'];
    $rows_services = search_services($Service_TypeId);
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
                                $rows_service_types = table_service_types('select', NULL);
                                foreach ($rows_service_types as $row_service_types) {
                                    echo "<option value=\"$row_service_types->Id\">".$row_service_types->Code." - ".$row_service_types->Name."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <button type="submit" class="button medium" name="buttonSubmit" id="buttonSubmit">Search</button>
                        </li>
                    </ul>
                </form>
            </main>
            <aside>
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
                                    echo "<td>".$row_services->suppliersName."</td>";
                                    echo "<td>".$row_services->Service."</td>";
                                    echo "<td>".$row_services->Additional."</td>";
                                    echo "<td>".$row_services->Remark."</td>";
                                    echo "<td><button type=\"submit\" class=\"button link\">Add</button></td>";
                                    echo "</tr>";
                                    echo "</form>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </aside>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
    <script type="text/javascript"></script>
</html>
