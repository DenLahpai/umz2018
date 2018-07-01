<?php
require "functions.php";

//getting data from the table
if (isset($_REQUEST['buttonSearch'])) {
    $search = $_REQUEST['search'];
}
else {
    $search = NULL;
}

if(empty($search) || $search == NULL || $search == "") {
    $rows_drivers = table_drivers('select', NULL);
}
else {
    $rows_drivers = table_drivers('search', $search);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Drivers";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Drivers";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <!-- sub-menu -->
            <div class="sub-menu">
                <form action="#" method="post">
                    <ul>
                        <li>
                            <a href="new_driver.php">
                                <button type="button" class="button medium" name="button">Create New Driver</button></a>
                        </li>
                        <li>
                            <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search Drivers">
                            <button type="submit" class="button search" name="buttonSearch">Search</button>
                        </li>
                    </ul>
                </form>
            </div>
            <!-- end of sub-menu -->
            <main>
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    foreach ($rows_drivers as $row_drivers) {
                        echo "<!-- grid-item -->";
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        echo "<li>".$row_drivers->Title.". ".$row_drivers->Name."</li>";
                        echo "<li>".$row_drivers->Mobile."</li>";
                        echo "<li>".$row_drivers->License." Class: ".$row_drivers->Class."</li>";
                        echo "<li>".$row_drivers->suppliersName."</li>";
                        echo "<li style=\"text-align: center;\"><a href=\"edit_driver.php?driversId=$row_drivers->Id\"><button>Edit</button></a></li>";
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
