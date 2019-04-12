<?php
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $rowCount = table_bookings('check_before_insert', NULL,  NULL);
    if ($rowCount == 0) {
        table_bookings('insert', NULL, NULL);
    }
    else {
        $error_message = "Duplicate entry";
    }
}
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
                            Reference: &nbsp;
                            <input type="text" name="Reference" id="Reference" placeholder="Reference from the Agent" required>
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
                                $rows_agents = table_agents('select_all', NULL, NULL);
                                foreach ($rows_agents as $row_agents) {
                                    echo "<option value=\"$row_agents->Id\">".$row_agents->Name."</option>";
                                }
                                 ?>
                            </select>
                        </li>
                        <li>
                            Guide Request: &nbsp;
                            <select id="Guide_RequestId" name="Guide_RequestId">
                                <option value="">Select</option>
                                <?php
                                $rows_guide_requests = table_guide_requests('select_all', NULL, NULL);
                                foreach ($rows_guide_requests as $row_guide_requests) {
                                    echo "<option value=\"$row_guide_requests->Id\">".$row_guide_requests->Request."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            Guide: &nbsp;
                            <select name="Tour_GuideId" id="Tour_GuideId">
                                <option value="">Select</option>
                                <?php
                                // getting data from the table tour_guides
                                $rows_tour_guides = table_tour_guides('select_all', NULL, NULL);
                                foreach ($rows_tour_guides as $row_tour_guides) {
                                    echo "<option value=\"$row_tour_guides->Id\" id=\"guideOption$row_tour_guides->Id\">".$row_tour_guides->Name."</option>";
                                }
                                ?>
                            </select>
                            <button type="button" class="button search" id="modalOpen" name="button">Search Guide</button>
                        </li>
                        <li>
                            Arrival Date: &nbsp;
                            <input type="date" name="Arrival_Date" id="Arrival_Date" required>
                        </li>
                        <li>
                            Remark: &nbsp;
                            <input type="text" name="Remark" id="Remark" placeholder="Remark">
                        </li>
                        <li>
                            Status: &nbsp;
                            <select id="StatusId" name="StatusId">
                                <?php
                                $rows_booking_statuses = table_booking_statuses('select_all', NULL, NULL);
                                foreach ($rows_booking_statuses as $row_booking_statuses) {
                                    echo "<option value=\"$row_booking_statuses->Id\">".$row_booking_statuses->Status."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit" onclick="check2Fields('AgentId', 'Guide_RequestId');">Create</button>
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <!-- end of content -->
        <?php
        include "includes/modal-guide_select.php";
        include "includes/footer.html";
        ?>
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>
</html>
