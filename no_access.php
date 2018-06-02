<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "No Access!";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "includes/main_menu.html";
            $header = "Restricted Area!";
            include "includes/header.html";
            ?>
            <main>
                <h2 style="color: red;">
                    You do NOT have access to view this page!
                </h2>
            </main>
        </div>
        <!-- end of content  -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
