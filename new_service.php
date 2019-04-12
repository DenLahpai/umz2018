<?php
require "functions.php";

//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_services('check_before_insert', NULL, NULL);
    if ($rowCount == 0) {
        table_services('insert', NULL, NULL);
    }
    else {
        $error_message = "Duplicate Entry!";
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "New Service";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "New Service";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <form class="theform" action="#" method="post">
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
                                <option value="">Select</option>
                                <?php
                                $rows_suppliers = table_suppliers('select_all', NULL, NULL);
                                foreach ($rows_suppliers as $row_suppliers) {
                                    echo "<option value=\"$row_suppliers->Id\">".$row_suppliers->Name."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            Service Type: &nbsp;
                            <select id="Service_TypeId" name="Service_TypeId" onchange="setRequired('Additional', 'Additional');">
                                <option value="">Select</option>
                                <?php
                                $rows_service_types = table_service_types('select_all', NULL, NULL);
                                foreach ($rows_service_types as $row_service_types) {
                                    echo "<option value=\"$row_service_types->Id\">".$row_service_types->Code." - ".$row_service_types->Name."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            Service: &nbsp;
                            <input type="text" name="Service" id="Service" placeholder="Service Name" required>
                        </li>
                        <li>
                            Additional: &nbsp;
                            <input type="text" name="Additional" id="Additional">
                        </li>
                        <li>
                            Remark: &nbsp;
                            <input type="text" name="Remark" id="Remark">
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
                            onclick="check2Fields('SupplierId','Service_TypeId');">Submit</button>
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
