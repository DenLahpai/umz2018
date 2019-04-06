<?php
require "functions.php";

if ($d > 2) {
    header("location: no_access.php");
}
//getting suppliers Id to be edited
$suppliersId = trim($_REQUEST['suppliersId']);
if (!is_numeric ($suppliersId)) {
    echo "There was an error! Please go back and try again.";
    die();
}

//getting data from the table suppliers
$rows_suppliers = table_suppliers('select_one', $suppliersId, NULL);
foreach ($rows_suppliers as $row_suppliers) {
    // code...
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_suppliers ('check_before_update', $suppliersId, NULL);
    if ($rowCount == 0) {
        table_suppliers('update', $suppliersId, NULL);
    }
    else {
            $error_message = "Duplicated Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Supplier";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php $header = "Edit Supplier";
            include "includes/header.html";
            include "includes/main_menu.html"
            ?>
            <main>
                <form id="theform" action="#" method="post">
                    <ul>
                        <li>
                            <?php
                            if(!empty($error_message)) {
                                echo $error_message;
                            }
                            ?>
                        </li>
                        <li>
                            Name: &nbsp;
                            <input type="text" id="Name" name="Name" value="<?php echo $row_suppliers->Name; ?>" required>
                        </li>
                        <li>
                            Address: &nbsp;
                            <input type="text" id="Address" name="Address" value="<?php echo $row_suppliers->Address; ?>">
                        </li>
                        <li>
                            City: &nbsp;
                            <input type="text" id="City" name="City" value="<?php echo $row_suppliers->City; ?>" required>
                        </li>
                        <li>
                            Phone: &nbsp;
                            <input type="text" id="Phone" name="Phone" value="<?php echo $row_suppliers->Phone; ?>" required>
                        </li>
                        <li>
                            Email: &nbsp;
                            <input type="email" id="Email" name="Email" value="<?php echo $row_suppliers->Email; ?>">
                        </li>
                        <li>
                            <button type="submit" class="button medium" name="buttonSubmit" id="buttonSubmit">Update</button>
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
