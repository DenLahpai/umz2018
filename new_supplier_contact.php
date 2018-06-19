<?php
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_supplier_contacts('check', NULL);
    if ($rowCount == 0) {
        table_supplier_contacts('insert', NULL);
    }
    else {
        $error_message = "Duplicate Entry!";
    }
}

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
            $header = "New Supplier Contact";
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
                        <li>
                            Title &nbsp;
                            <select id="Title" name="Title">
                                <?php select_titles(NULL); ?>
                            </select>
                        </li>
                        <li>
                            Name: &nbsp;
                            <input type="text" name="Name" id="Name" placeholder="Name" required>
                        </li>
                        <li>
                            Position: &nbsp;
                            <input type="text" name="Position" id="Position" placeholder="Position or Rank" required>
                        </li>
                        <li>
                            Department: &nbsp;
                            <input type="text" name="Department" id="Department" placeholder="Department" required>
                        </li>
                        <li>
                            Mobile: &nbsp;
                            <input type="text" name="Mobile" id="Mobile" placeholder="Mobile Number" required>
                        </li>
                        <li>
                            Email: &nbsp;
                            <input type="email" name="Email" id="Email" placeholder="someone@email.com">
                        </li>
                        <li>
                            Supplier: &nbsp;
                            <select id="SupplierId" name="SupplierId">
                                <option value="">Select</option>
                                <?php
                                $rows_suppliers = table_suppliers('select', NULL);
                                foreach ($rows_suppliers as $row_suppliers) {
                                    echo "<option value=\"$row_suppliers->Id\">".$row_suppliers->Name."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit" onclick="check2Fields('Title', 'SupplierId');">Submit</button>
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <?php include "includes/footer.html"; ?>
        <!-- end of content -->
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
</html>
