<?php
require "functions.php";

//getting services Id
$servicesId = trim($_REQUEST['servicesId']);
if (!is_numeric ($servicesId)) {
    echo "There was an error! Please go back and try again.";
    die();
}

// getting data from the table services
$rows_services = table_services('select_one', $servicesId, NULL);
foreach ($rows_services as $row_services) {
    // code...
}

// updating the table services
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_services('check_before_update', $servicesId, NULL);
    if ($rowCount == 0) {
        table_services('update', $servicesId, NULL);
    }
    else {
        $error_message = "Duplicate Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Service";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit Service";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <form id="theform" action="#" method="post">
                    <ul>
                        <li class="notice error">
                            <?php
                            if (!empty($error_message)) {
                                echo $error_message;
                            }
                            ?>
                        </li>
                        <li>
                            Supplier: &nbsp;
                            <select id="SupplierId" name="SupplierId">
                                <?php
                                $rows_suppliers = table_suppliers('select_all', NULL, NULL);
                                foreach ($rows_suppliers as $row_suppliers) {
                                    if ($row_services->SupplierId == $row_suppliers->Id) {
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
                            Service Type: &nbsp;
                            <select id="Service_TypeId" name="Service_TypeId">
                                <?php
                                $rows_service_types = table_service_types('select_all', NULL, NULL);
                                foreach ($rows_service_types as $row_service_types) {
                                    if ($row_services->Service_TypeId == $row_service_types->Id) {
                                        echo "<option value=\"$row_service_types->Id\" selected>".$row_service_types->Code."</option>";
                                    }
                                    else {
                                        echo "<option value=\"$row_service_types->Id\">".$row_service_types->Code."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            Service: &nbsp;
                            <input type="text" name="Service" id="Service" value="<?php echo $row_services->Service; ?>" required>
                        </li>
                        <li>
                            Additional: &nbsp;
                            <input type="text" name="Additional" id="Additional" value="<?php echo $row_services->Additional; ?>"
                            onchange="setRequired('Additional', 'Additional');">
                        </li>
                        <li>
                            Remark: &nbsp;
                            <input type="text" name="Remark" id="Remark" value="<?php echo $row_services->Remark; ?>">
                        </li>
                        <li>
                            Status: &nbsp;
                            <select id="Status" name="Status">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </li>
                        <li>
                            <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit"
                            onclick="check2Fields('SupplierId','Service_TypeId');">Update</button>
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
