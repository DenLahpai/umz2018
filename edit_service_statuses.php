<?php
require "functions.php";

if ($d > 2) {
    header("location: no_access.php");
}

//getting Id for service_statuses
$service_statusesId = trim($_REQUEST['service_statusesId']);

//getting data from the table service_statuses
$rows_service_statuses = table_service_statuses('select', $service_statusesId);
foreach ($rows_service_statuses as $row_service_statuses) {
    // code...
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Code = strtoupper($_REQUEST['Code']);
    if ($Code == $row_service_statuses->Code) {
        table_service_statuses('update', $service_statusesId);
    }
    else {
        $rowCount = table_service_statuses('check', NULL);
        if ($rowCount == 0) {
            table_service_statuses('update', $service_statusesId);
        }
        else {
            $error_message = "Duplicate entry!";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Service Status";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit Service Status";
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
                            Code: &nbsp;
                            <input type="text" name="Code" id="Code" value="<?php echo $row_service_statuses->Code; ?>" required>
                        </li>
                        <li>
                            Description: &nbsp;
                            <input type="text" name="Description" id="Description" value="<?php echo $row_service_statuses->Description; ?>">
                        </li>
                        <li>
                            <button type="button" class="button medium" id="buttonSubmit" name="buttonSubmit" onclick="check2Fields('Code', 'Description')">Update</button>
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
