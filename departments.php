<?php
require_once "functions.php";

//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Departments";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "includes/main_menu.html";
            $header = "Departments";
            include "includes/header.html";
            ?>
            <main>
                <!-- table medium -->
                <div class="table medium">
                    <table>
                        <thead>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Details</th>
                            <th>Access_Details</th>
                        </thead>
                        <tbody>
                        <?php
                        //getting data from the table departments
                        $rows_departments = get_departments();
                        foreach ($rows_departments as $row_departments) {
                            echo "<tr>";
                            echo "<td>".$row_departments->Id."</td>";
                            echo "<td>".$row_departments->Name."</td>";
                            echo "<td>".$row_departments->Details."</td>";
                            echo "<td>".$row_departments->Access_Details."</td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <!-- end of table medium -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
