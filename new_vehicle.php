<?php
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_vehicles('check', NULL);
    if ($rowCount == 0) {
        table_vehicles('insert', NULL);
    }
    else {
        $error_message = "Duplicate Entry!";
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "New Vehicle";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "New Vehicle";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <form id="theform" action="#" method="post">
                    <ul>
                        <li>
                            <?php if (!empty($error_message)) {
                                echo $error_message;
                            }
                            ?>
                        </li>
                        <li>
                            License: &nbsp;
                            <input type="text" name="License" id="License" placeholder="License Plate #" required>
                        </li>
                        <li>
                            Type: &nbsp;
                            <input type="text" name="Type" id="Type" placeholder="Vehicle Type" required>
                        </li>
                        <li>
                            Number of Seats (excluding driver's): &nbsp;
                            <input type="number" name="Seats" id="Seats" min="2" max="99">
                        </li>
                        <li>
                            Supplier: &nbsp;
                            <select id="SupplierId" name="SupplierId">
                                <option value="">Select</option>
                                <?php
                                $rows_suppliers = table_suppliers('select', NULL);
                                foreach ($rows_suppliers as $row_suppliers) {
                                    echo "<option value=\"$row_suppliers->Id\">".$row_suppliers->Name."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit" onclick="check2Fields('Type', 'SupplierId')">Submit</button>
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
</html>
