<?php
require "functions.php";

//getting drivers Id to be edited
$driversId = trim($_REQUEST['driversId']);
if (!is_numeric ($driversId)) {
    echo "There was a problem! Please go back and try again.";
    die();
}

//getting the drivers Id and data from the table drivers
$rows_drivers = table_drivers('select_one', $driversId, NULL);
foreach ($rows_drivers as $row_drivers) {
    // code...
}

//checking and updating the table drivers
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_drivers('check_before_update', $driversId, NULL);
    if ($rowCount == 0) {
        table_drivers('update', $driversId, NULL);
    }
    else {
        $error_message = "Duplicate Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Driver";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit Driver";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
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
                            Title: &nbsp;
                            <select id="Title" name="Title">
                                <?php select_titles($row_drivers->Title); ?>
                            </select>
                        </li>
                        <li>
                            Name: &nbsp;
                            <input type="text" name="Name" id="Name" value="<?php echo $row_drivers->Name; ?>" required>
                        </li>
                        <li>
                            Mobile: &nbsp;
                            <input type="text" name="Mobile" id="Mobile" value="<?php echo $row_drivers->Mobile; ?>" required>
                        </li>
                        <li>
                            License: &nbsp;
                            <input type="text" name="License" id="License" value="<?php echo $row_drivers->License; ?>" required>
                        </li>
                        <li>
                            Class: &nbsp;
                            <input type="text" name="Class" id="Class" value="<?php echo $row_drivers->Class; ?>" required>
                        </li>
                        <li>
                            Supplier: &nbsp;
                            <select id="SupplierId" name="SupplierId">
                                <?php
                                $rows_suppliers = table_suppliers('select_all', NULL, NULL);
                                foreach ($rows_suppliers as $row_suppliers) {
                                    if ($row_suppliers->Id == $row_drivers->SupplierId) {
                                        echo "<option value=\"$row_suppliers->Id\" selected>".$row_suppliers->Name."</option>";
                                    }
                                    else {
                                        echo "<option value=\"$row_suppliers->Id\">".$row_suppliers->Name."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <button type="button" class="button medium" id="buttonSubmit" name="buttonSubmit" onclick="check2Fields('Title', 'SupplierId');">Update</button>
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
