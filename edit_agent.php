<?php
require_once "functions.php";
if ($d > 2) {
    header("location: no_access.php");
}
//getting agants Id to be edited
$agentsId = trim($_REQUEST['agentsId']);
if (!is_numeric ($agentsId)) {
    echo "There was an error! Please go back and try again.";
    die();
}

//getting the agentsId and data from the table agents
$rows_agents = table_agents('select_one', $agentsId, NULL);
foreach ($rows_agents as $row_agents) {
    // code...
}

//updating the table agents when clicked update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_agents ('check_before_update', $agentsId, NULL);
    if ($rowCount == 0) {
        table_agents ('update', $agentsId, NULL);
    }
    else {
        $error_message = "Duplicate Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Agent";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = 'Edit Agent';
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <form action="#" method="post">
                    <ul>
                        <li class="notice error">
                            <?php
                            if(!empty($error_message)) {
                                echo $error_message;
                            }
                            ?>
                        </li>
                        <li>
                            Name: &nbsp;
                            <input type="text" name="Name" id="Name" value="<?php echo $row_agents->Name; ?>" required>
                        </li>
                        <li>
                            Address: &nbsp;
                            <input type="text" name="Address" id="Address" value="<?php echo $row_agents->Address; ?>" required>
                        </li>
                        <li>
                            Township: &nbsp;
                            <input type="text" name="Township" id="Township" value="<?php echo $row_agents->Township; ?>">
                        </li>
                        <li>
                            City: &nbsp;
                            <input type="text" name="City" id="City" value="<?php echo $row_agents->City; ?>">
                        </li>
                        <li>
                            Country: &nbsp;
                            <input type="text" name="Country" id="Country" value="<?php echo $row_agents->Country; ?>">
                        </li>
                        <li>
                            Phone: &nbsp;
                            <input type="text" name="Phone" id="Phone" value="<?php echo $row_agents->Phone; ?>">
                        </li>
                        <li>
                            Fax: &nbsp;
                            <input type="text" name="Fax" id="Fax" value="<?php echo $row_agents->Fax; ?>">
                        </li>
                        <li>
                            Email: &nbsp;
                            <input type="email" name="Email" id="Email" value="<?php echo $row_agents->Email; ?>">
                        </li>
                        <li>
                            Website: &nbsp;
                            <input type="text" name="Website" id="Website" value="<?php echo $row_agents->Website; ?>">
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
    <script type="text/javascript" src="js/scripts.js"></script>
</html>
