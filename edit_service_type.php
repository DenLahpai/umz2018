<?php
require "functions.php";

//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

//getting the service_typesId
$service_typesId = trim($_REQUEST['service_typesId']);
if (!is_numeric ($service_typesId)) {
    echo "There was an error! Please go back and try again!";
    die();
}

//getting data from the table service_types
$rows_service_types = table_service_types('select_one', $service_typesId, NULL);
foreach ($rows_service_types as $row_service_types) {
    // code...
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_service_types ('check_before_update', $service_typesId, NULL);

    if ($rowCount == 0) {
        table_service_types ('update', $service_typesId, NULL);
    }
    else {
        $error_message = "Duplicate Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Service Type";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit Service Type";
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
                            <input type="text" name="Code" id="Code" value="<?php echo $row_service_types->Code; ?>">
                        </li>
                        <li>
                            Name: &nbsp;
                            <input type="text" name="Name" id="Name" value="<?php echo $row_service_types->Name; ?>">
                        </li>
                        <li>
                            <button type="button" class="button medium" id="buttonSubmit" name="buttonSubmit" onclick="check2Fields('Code', 'Name');">Update</button>
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
