<?php
require "functions.php";
//getting agants Id to be edited
$tour_guidesId = trim($_REQUEST['tour_guidesId']);

//getting the agentsId and data from the table agents
$rows_tour_guides = table_tour_guides('select', $tour_guidesId);
foreach ($rows_tour_guides as $row_tour_guides) {
    // code...
}

//updating the table tour_guides when clicked update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Name = trim($_REQUEST['Name']);
    $Mobile = trim($_REQUEST['Mobile']);
    if ($Name == $row_tour_guides->Name) {
        table_tour_guides('update', $tour_guidesId);
    }
    else {
        $rowCount = table_tour_guides('check', NULL);
        if ($rowCount == 0) {
            table_tour_guides('update', $tour_guidesId);
        }
        else {
            $error_message = "Dupicate Entry!";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Tour Guide";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit Tour Guide";
            include "includes/header.html";
            include "includes/main_menu.html";
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
                            Title: &nbsp;
                            <select name="Title">
                                <?php select_titles($row_tour_guides->Title); ?>
                            </select>
                        </li>
                        <li>
                            Name: &nbsp;
                            <input type="text" id="Name" name="Name" value="<?php echo $row_tour_guides->Name; ?>" required>
                        </li>
                        <li>
                            Mobile: &nbsp;
                            <input type="text" id="Mobile" name="Mobile" value="<?php echo $row_tour_guides->Mobile; ?>" required>
                        </li>
                        <li>
                            License: &nbsp;
                            <input type="text" id="License" name="License" value="<?php echo $row_tour_guides->License; ?>" required>
                        </li>
                        <li>
                            License Type: &nbsp;
                            <input type="text" id="Type" name="Type" value="<?php echo $row_tour_guides->Type; ?>" required>
                        </li>
                        <li>
                            Language: &nbsp;
                            <input type="text" id="Language" name="Language" value="<?php echo $row_tour_guides->Language; ?>" required>
                        </li>
                        <li>
                            Email: &nbsp;
                            <input type="email" id="Email" name="Email" value="<?php echo $row_tour_guides->Email; ?>">
                        </li>
                        <li>
                            <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit" onclick="check2Fields('Title', 'Title');">Update</button>
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
