<?php
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_tour_guides('check_before_insert', NULL, NULL);
    if ($rowCount == 0) {
        table_tour_guides('insert', NULL, NULL);
    }
    else {
        $error_message = "Duplicate Username!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "New Tour Guide";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "New Tour Guide";
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
                            Title: &nbsp;
                            <select id="Title" name="Title">
                                <?php
                                select_titles(NULL);
                                ?>
                            </select>
                        </li>
                        <li>
                            Name: &nbsp;
                            <input type="text" id="Name" name="Name" placeholder="Name" required>
                        </li>
                        <li>
                            Mobile: &nbsp;
                            <input type="text" id="Mobile" name="Mobile" placeholder="Mobile Number" required>
                        </li>
                        <li>
                            License: &nbsp;
                            <input type="text" id="License" name="License" placeholder="G-????" required>
                        </li>
                        <li>
                            License Type: &nbsp;
                            <input type="text" id="Type" name="Type" placeholder="Regional or Country" required>
                        </li>
                        <li>
                            Language(s): &nbsp;
                            <input type="text" id="Language" name="Language" placeholder="Language(s)" required>
                        </li>
                        <li>
                            Email: &nbsp;
                            <input type="email" id="Email" name="Email" placeholder="someone@email.com">
                        </li>
                        <li>
                            <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit" onclick="check2Fields('Title', 'Title');">Create</button>
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
