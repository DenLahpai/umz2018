<?php
require "functions.php";

//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Request = trim($_REQUEST['Request']);
    $rowCount = table_guide_requests('check', NULL);
    if ($rowCount == 0) {
        table_guide_requests('insert', NULL);
    }
    else {
        $error_message = "Duplicate Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Guide Requests";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Guide Requests";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <!-- table medium -->
                <div class="table medium">
                    <form id="theform" action="#" method="post">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>
                                        Request: &nbsp;
                                        <input type="text" name="Request" id="Request" placeholder="Request" required>
                                    </th>
                                    <th>
                                        <button type="button" class="button medium" id="buttonSubmit" name="buttonSubmit" onclick="check2Fields('Request', 'Request');">Create</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($error_message)) {
                                    echo "<tr>";
                                    echo "<th colspan=\"3\" class=\"notice error\">";
                                    echo "</tr>";
                                }
                                $rows_guide_requests = table_guide_requests('select', NULL);
                                foreach ($rows_guide_requests as $row_guide_requests) {
                                    echo "<tr>";
                                    echo "<td>".$row_guide_requests->Id."</td>";
                                    echo "<td>".$row_guide_requests->Request."</td>";
                                    echo "<td><a href=\"edit_guide_request.php?guide_requestsId=$row_guide_requests->Id\"><button class=\"button link\">Edit</button></a></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                </div>
                <!-- end of table medium -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
</html>
