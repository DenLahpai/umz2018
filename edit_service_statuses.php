<?php
require "functions.php";

if ($d > 2) {
    header("location: no_access.php");
}

//getting Id for service_statuses
$service_statusesId = trim($_REQUEST['service_statusesId']);

if (!is_numeric ($service_statusesId)) {
    echo "There was an error! Please go back and try again!";
    die();
}

//getting data from the table service_statuses
$rows_service_statuses = table_service_statuses('select_one', $service_statusesId, NULL);
foreach ($rows_service_statuses as $row_service_statuses) {
    // code...
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo $rowCount = table_service_statuses ('check_before_update', $service_statusesId, NULL);

    if ($rowCount == 0) {
        table_service_statuses ('update', $service_statusesId, NULL);
    }
    else {
        $error_messge = "Duplicate entry!";
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
