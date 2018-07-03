<?php
require "functions.php";

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "New Booking";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "New Booking";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <form id="theform" action="#" method="post">
                    <ul>
                        <li>
                            <?php
                            if (!empty($error_message)) {
                                echo $error_message;
                            }
                            ?>
                        </li>
                        <li>
                            Grp Name: &nbsp;
                            <input type="text" name="Name" id="Name" placeholder="Group Name" required>
                        </li>
                        <li>
                            Pax: &nbsp;
                            <input type="number" name="Pax" id="Pax" min="1" max="999" required>
                        </li>
                        <li>
                            Agent:&nbsp;
                            <select id="AgentId" name="AgentId">
                                <option value="">Select</option>
                                <?php
                                $rows_agents = table_agents('select', NULL);
                                foreach ($rows_agents as $row_agents) {
                                    echo "<option value=\"$row_agents->Id\">".$row_agents->Name."</option>";
                                }
                                 ?>
                            </select>
                        </li>
                        <li>
                            Guide: &nbsp;
                            <select class="" name="">
                                <!-- TODO Guide Request Table-->
                            </select>
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
