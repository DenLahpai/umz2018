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
                            <a href="agents.php" title="Agents">Agents</a>
                        </li>
                        <li>
                            <a href="agent_contacts.php" title="Agent Contacts">Agent Contacts</a>
                        </li>
                        <li>
                            <a href="tourguides.php" title="Tour Guides">Tour Guides</a>
                        </li>
                        <li>
                            <a href="guide_requests.php" title="Guide Requests">Guide Requests</a>
                        </li>
                        <li>
                            <a href="booking_statuses.php" title="Booking Status">Booking Statuses</a>
                        </li>
                        <li>
                            <a href="vehicles.php" title="Vehicles">Vehicles</a>
                        </li>
                        <li>
                            <a href="drivers.php" title="Drivers">Drivers</a>
                        </li>
                        <li>
                            <a href="suppliers.php" title="Suppliers">Suppliers</a>
                        </li>
                        <li>
                            <a href="supplier_contacts.php" title="Supplier Contacts">Supplier Contacts</a>
                        </li>
                        <li>
                            <a href="service_types.php" title="Service Types">Service Types</a>
                        </li>
                        <li>
                            <a href="service_statuses.php" title="Service Statuses">Service Statuses</a>
                        </li>
                        <li>
                            <a href="departments.php" title="Departments">Departments</a>
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
