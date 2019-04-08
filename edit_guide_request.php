<?php
require "functions.php";

//getting guide_requestsId
$guide_requestsId = trim($_REQUEST['guide_requestsId']);
if (!is_numeric ($guide_requestsId)) {
    echo "There was an error! Please go back and try again.";
    die();
}

//getting data from the table guide_requests
$rows_guide_requests = table_guide_requests('select_one', $guide_requestsId, NULL);
foreach ($rows_guide_requests as $row_guide_requests) {
    // code...
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_guide_requests ('check_before_update', $guide_requestsId, NULL);
    if ($rowCount == 0) {
        table_guide_requests ('update', $guide_requestsId, NULL);
    }
    else {
        $error_message = 'Duplicate Entry!';
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Guide Request";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit Guide Request";
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
                                        <input type="text" name="Request" id="Request" value="<?php echo $row_guide_requests->Request; ?>">
                                    </th>
                                    <th>
                                        <button type="button" class="button medium" id="buttonSubmit" name="buttonSubmit" onclick="check2Fields('Request', 'Request');">Update</button>
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
