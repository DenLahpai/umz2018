<?php
require_once "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    table_tour_guides ('voucher', NULL, NULL);
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
                    <form id="theform" action="guide_voucher.php" method="post">
                        <ul>
                            <li>
                                Guide:
                                <select name="tour_guidesId" id="tour_guidesId">
                                    <option value="">Select One</option>
                                    <?php
                                    $rows_tour_guides = table_tour_guides ('select_all', NULL, NULL);
                                    foreach ($rows_tour_guides as $row_tour_guides) {
                                        echo "<option value=\"$row_tour_guides->Id\">".$row_tour_guides->Name."</option>";
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                From:
                                <input type="date" name="Service_Date1" id="Service_Date1">
                                &nbsp;
                                Until:
                                <input type="date" name="Service_Date2" id="Service_Date2">
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
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
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
