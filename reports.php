<?php
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Reports";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Reports";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <!-- links -->
                <div class="links">
                    <ul>
                        <li>
                            <a href="voucher_guide.php">Vouchers for guides</a>
                        </li>
                    </ul>
                </div>
                <!-- end of links -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
