<?php
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Admin";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "includes/main_menu.html";
            $header = "Admin";
            include "includes/header.html";
            ?>
            <main>
                <!-- links -->
                <div class="links">
                    <ul>
                        <li>
                            <a href="#">Agents</a>
                        </li>
                        <li>
                            <a href="#">Agent Contacts</a>
                        </li>
                        <li>
                            <a href="#">Tour Guides</a>
                        </li>
                        <li>
                            <a href="#">Vehicles</a>
                        </li>
                        <li>
                            <a href="#">Drivers</a>
                        </li>
                        <li>
                            <a href="#">Suppliers</a>
                        </li>
                        <li>
                            <a href="#">Supplier Contacts</a>
                        </li>
                        <li>
                            <a href="departments.php">Departments</a>
                        </li>
                        <li>
                            <a href="users.php">Users</a>
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
