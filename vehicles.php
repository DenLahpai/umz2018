<?php
require "functions.php";

//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

//getting data from the table
if (isset($_REQUEST['buttonSearch'])) {
    $search = $_REQUEST['search'];
}
else {
    $search = NULL;
}

if(empty($search) || $search == NULL || $search == "") {
    $rows_vehicles = table_vehicles('select_all', NULL, NULL);
}
else {
    $rows_vehicles = table_vehicles('search', $search, NULL);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Vehicles";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Vehicles";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <!-- sub-menu -->
            <div class="sub-menu">
                <form action="#" method="post">
                <ul>
                    <li>
                        <a href="new_vehicle.php">
                            <button type="button" class="button medium" name="button">Create New Vehicle</button></a>
                    </li>
                    <li>
                        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search Vehicles">
                        <button type="sumit" class="button search" name="buttonSearch">Search</button>
                    </li>
                </ul>
                </form>
            </div>
            <!-- end of sub-menu -->
            <main>
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    foreach ($rows_vehicles as $row_vehicles) {
                        echo "<!-- grid-item -->";
                        echo "<div>";
                        echo "<ul>";
                        echo "<li>License: &nbsp;".$row_vehicles->License."</li>";
                        echo "<li>Type: &nbsp;".$row_vehicles->Type."</li>";
                        echo "<li>Seats: &nbsp;".$row_vehicles->Seats."</li>";
                        echo "<li>Supplier: &nbsp;".$row_vehicles->suppliersName."</li>";
                        echo "<li style=\"text-align: center;\"><a href=\"edit_vehicle.php?vehiclesId=$row_vehicles->Id\"><button class=\"button link\">Edit</button></a></li>";
                        echo "</ul>";
                        echo "</div>";
                        echo "<!-- end of grid-item -->";
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
