<?php
require "functions.php";

//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_suppliers('check', NULL);
    if ($rowCount == 0) {
        table_suppliers('insert', NULL);
    }
    else {
        $error_message = "Duplicate Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "New Supplier";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "New Supplier";
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
                            Name: &nbsp;
                            <input type="text" name="Name" id="Name" placeholder="Name" required>
                        </li>
                        <li>
                            Address: &nbsp;
                            <input type="text" name="Address" id="Address" placeholder="Address">
                        </li>
                        <li>
                            City: &nbsp;
                            <input type="text" name="City" id="City" placeholder="City" required>
                        </li>
                        <li>
                            Phone: &nbsp;
                            <input type="text" name="Phone" id="Phone" placeholder="Phone" required>
                        </li>
                        <li>
                            Email: &nbsp;
                            <input type="email" name="Email" id="Email" placeholder="someone@email.com">
                        </li>
                        <li>
                            <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit">Submit</button>
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
