<?php
require "functions.php";

//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_service_types('check_before_insert', NULL, NULL);
    if ($rowCount == 0) {
        table_service_types('insert', NULL, NULL);
    }
    else {
        $error_message = "Duplicate Entry!";
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Service Types";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Service Types";
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
                                    <th>
                                        Code: &nbsp;
                                        <input type="text" name="Code" id="Code" maxlength="3" size="3em" requred>
                                    </th>
                                    <th>
                                        Name: &nbsp;
                                        <input type="text" name="Name" id="Name" placeholder="Service Type Name" required>
                                    </th>
                                    <th>
                                        <button type="button" class="button medium" id="buttonSubmit" name="buttonSubmit" onclick="check2Fields('Code', 'Name');">Create</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($error_message)) {
                                    echo "<tr>";
                                    echo "<th colspan=\"3\" class=\"notice error\">".$error_message."</td>";
                                    echo "</tr>";
                                }
                                
                                $rows_service_types = table_service_types ('select_all', NULL, NULL);
                                foreach ($rows_service_types as $row_service_types) {
                                    echo "<tr>";
                                    echo "<td>".$row_service_types->Code."</td>";
                                    echo "<td>".$row_service_types->Name."</td>";
                                    echo "<td><a href=\"edit_service_type.php?service_typesId=$row_service_types->Id\"><button type=\"button\" class=\"button link\">Edit</button></a></td>";
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
