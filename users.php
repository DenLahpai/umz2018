<?php
require_once "functions.php";
//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

// getting data from the table users
$rows_users = table_users('select', NULL);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Users";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "./includes/main_menu.html";
            $header = "Users";
            include "./includes/header.html";
            ?>
            <main>
                <table>
                    <form action="#" method="post">
                        <thead>
                            <tr>
                                <th></th>
                            </tr>
                        </thead>
                    </form>
                        <tbody>
                            <?php
                            foreach ($rows_users as $rows_users) {

                            }
                            ?>
                        </tbody>
                </table>
            </main>
        </div>
        <!-- end of content -->
        <?php include "./includes/footer.html"; ?>
    </body>
</html>
