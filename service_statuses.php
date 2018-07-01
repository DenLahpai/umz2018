<?php
require "functions.php";

//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_service_statuses('check', NULL);
    if ($rowCount == 0) {
        table_service_statuses('insert', NULL);
    }
    else {
        $error_messge = "Duplicate Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Service Statuses";
    include "includes/head.html";
    ?>
    <body>
        <!-- content  -->
        <div class="content">
            <?php
            $header = "Service Statuses";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <!-- table medium     -->
                <div class="table medium">
                    <form id="theform" action="#" method="post">
                        <table>
                            <thead>
                                <tr>
                                    <th>
                                        Code: &nbsp;
                                        <input type="text" name="Code" id="Code" size="2em" maxlength="2" required>
                                    </th>
                                    <th>
                                        Description: &nbsp;
                                        <input type="text" name="Description" id="Description" required>
                                    </th>
                                    <th>
                                        <button type="button" class="button medium" id="buttonSubmit" name="buttonSubmit" onclick="check2Fields('Code', 'Description');">Create</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($error_messge)) {
                                    echo "<tr>";
                                    echo "<th colspan=\"3\" class=\"notice erorr\">".$error_messge."</th>";
                                    echo "</tr>";
                                }

                                $rows_service_statuses = table_service_statuses('select', NULL);
                                foreach ($rows_service_statuses as $row_service_statuses) {
                                    echo "<tr>";
                                    echo "<td>".$row_service_statuses->Code."</td>";
                                    echo "<td>".$row_service_statuses->Description."</td>";
                                    echo "<td><a href=\"edit_service_statuses.php?service_statusesId=$row_service_statuses->Id\"><button>Edit</button></a></td>";
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
