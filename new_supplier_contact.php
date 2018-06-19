<?php
require "functions.php";

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "New Supplier Contact";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "New Supplier Contact"
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <form id="" action="#" method="post">
                    <ul>
                        <li>
                            <?php
                            if (!empty($error_message)) {
                                echo $error_message;
                            }
                            ?>
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <!-- end of content -->
    </body>
</html>
