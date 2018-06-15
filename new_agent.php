<?php
require "functions.php";

//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_agents('check', NULL);
    if ($rowCount == 0) {
        table_agents('insert', NULL);
    }
    else {
        $error_message = "Duplicate Entry!";
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = 'New Agent';
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = 'New Agent';
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <form id="theform" action="#" method="post">
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
                            <input type="text" name="Name" id="Name" placeholder="Agent Name" required>
                        </li>
                        <li>
                            Address: &nbsp;
                            <input type="text" name="Address" id="Address" placeholder="Address" required>
                        </li>
                        <li>
                            Township: &nbsp;
                            <input type="text" name="Township" id="Township" placeholder="Township">
                        </li>
                        <li>
                            City: &nbsp;
                            <input type="text" name="City" id="City" value="Yangon">
                        </li>
                        <li>
                            Country: &nbsp;
                            <input type="text" name="Country" id="Country" value="Myanmar">
                        </li>
                        <li>
                            Phone: &nbsp;
                            <input type="text" name="Phone" id="Phone" placeholder="Main Phone">
                        </li>
                        <li>
                            Fax: &nbsp;
                            <input type="text" name="Fax" id="Fax" placeholder="Fax">
                        </li>
                        <li>
                            Email: &nbsp;
                            <input type="email" name="Email" id="Email" placeholder="General Email">
                        </li>
                        <li>
                            Website: &nbsp;
                            <input type="text" name="Website" id="Website" placeholder="www.agent.com">
                        </li>
                        <li>
                            <button type="Submit" class="button medium" name="buttonSubmit" id="buttonSubmit">Submit</button>
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
