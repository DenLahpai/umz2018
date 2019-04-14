<?php
require_once "functions.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tour_guidesId = $_REQUEST['tour_guidesId'];
    $Service_Date1 = $_REQUEST['Service_Date1'];
    $Service_Date2 = $_REQUEST['Service_Date2'];
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Guide Voucher";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = $page_title;
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <!-- report form -->
                <div class="report form">
                    <form id="theform" action="#" method="post">
                        <ul>
                            <li>
                                Guide:
                                <select name="tour_guidesId" id="tour_guidesId">
                                    <option value="">Select One</option>
                                    <?php
                                    $rows_tour_guides = table_tour_guides ('select_all', NULL, NULL);
                                    foreach ($rows_tour_guides as $row_tour_guides) {
                                        if ($tour_guidesId == $row_tour_guides->Id) {
                                            echo "<option value=\"$row_tour_guides->Id\" selected>".$row_tour_guides->Name."</option>";
                                        }
                                        else {
                                            echo "<option value=\"$row_tour_guides->Id\">".$row_tour_guides->Name."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <button type="button" class="button search" id="modalOpen" name="button">Search Guide</button>
                            </li>
                            <li>
                                From:
                                <input type="date" name="Service_Date1" id="Service_Date1" value="<? echo $Service_Date1; ?>">
                                &nbsp;
                                Until:
                                <input type="date" name="Service_Date2" id="Service_Date2" value="<? echo $Service_Date2; ?>">
                            </li>
                            <li class="error">

                            </li>
                            <li>
                                <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit" onclick="view_tour_guidesVoucher();">View</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of report form -->
                <div class="table medium">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>Booking Name</th>
                                <th>Service</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $rows_guide = report_guide_assignment_per_guide ('guide_assignment', NULL, NULL);
                                foreach ($rows_guide as $row_guide) {
                                    echo "<tr>";
                                    echo "<td>".date('d-M-y', strtotime($row_guide->Service_Date))."</td>";
                                    echo "<td><a href=\"booking_summary.php?bookingsId=$row_guide->BookingsId\">".$row_guide->Reference."</a></td>";
                                    echo "<td>".$row_guide->bookingsName."</td>";
                                    echo "<td>".$row_guide->Service."</td>";
                                    echo "<td>".$row_guide->Code."</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
        <!-- end of content -->
        <?php
        include "includes/footer.html";
        include "includes/modal-guide_select.php";
        ?>
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
	<script type="text/javascript" src="js/modal.js"></script>
    <script type="text/javascript">
        //function to check and submit to generate the report for guide vouchers
        function view_tour_guidesVoucher () {
            var tour_guidesId = document.getElementById('tour_guidesId');
            var Service_Date1 = document.getElementById('Service_Date1');
            var Service_Date2 = document.getElementById('Service_Date2');
            var error = 0;

            if (tour_guidesId.value == "" || tour_guidesId.value == null || tour_guidesId.value <= 0) {
                tour_guidesId.style.background = 'red';
                error = 1;
            }

            if (Service_Date1.value == "") {
                Service_Date1.style.background = 'red';
                error = 1;
            }

            if (Service_Date2.value == "") {
                Service_Date2.value = Service_Date1.value;
            }

            if (Service_Date1.value > Service_Date2.value) {
                Service_Date1.style.background = 'brown';
                Service_Date2.style.background = 'brown';
                erorr = 2;
            }

            if (error == 1) {
                document.getElementsByClassName('error')[0].innerHTML = 'Please fill out all the field(s) in red';
            }
            else if (error == 2) {
                document.getElementsByClassName('error')[0].innerHTML = 'Please input proper dates in brown!';
            }
            else if (error == 0) {
                document.getElementById('buttonSubmit').type = 'Submit';
            }
        }
    </script>
</html>
