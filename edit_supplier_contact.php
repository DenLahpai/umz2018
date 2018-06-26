<?php
require "functions.php";

//getting agent_contact Id to be edited
$supplier_contactsId = trim($_REQUEST['supplier_contactsId']);

//getting data from the table agent_contacts
$rows_supplier_contacts = table_supplier_contacts('select', $supplier_contactsId);
foreach ($rows_supplier_contacts as $row_supplier_contacts) {
    // code
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Name = trim($_REQUEST['Name']);
    if ($Name == $row_supplier_contacts->Name) {
        table_supplier_contacts('update', $supplier_contactsId);
    }
    else {
        $rowCount = table_supplier_contacts('check', NULL);
        if ($rowCount == 0) {
            table_supplier_contacts('update', $supplier_contactsId);
        }
        else {
            $error_message = "Duplicate Entry!";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Supplier Contact";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit Supplier Contact";
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
                            Title: &nbsp;
                            <select id="Title" name="Title">
                                <?php select_titles($row_supplier_contacts->Title); ?>
                            </select>
                        </li>
                        <li>
                            Name: &nbsp;
                            <input type="text" name="Name" id="Name" value="<?php echo $row_supplier_contacts->Name; ?>" required>
                        </li>
                        <li>
                            Position: &nbsp;
                            <input type="text" name="Position" id="Position" value="<?php echo $row_supplier_contacts->Position; ?>" required>
                        </li>
                        <li>
                            Department: &nbsp;
                            <input type="text" name="Department" id="Department" value="<?php echo $row_supplier_contacts->Department; ?>" required>
                        </li>
                        <li>
                            Mobile: &nbsp;
                            <input type="text" name="Mobile" id="Mobile" value="<?php echo $row_supplier_contacts->Mobile; ?>">
                        </li>
                        <li>
                            Email: &nbsp;
                            <input type="email" name="Email" id="Email" value="<?php echo $row_supplier_contacts->Email; ?>">
                        </li>
                        <li>
                            Supplier: &nbsp;
                            <select id="SupplierId" name="SupplierId">
                                <?php
                                $rows_suppliers = table_suppliers('select', $row_supplier_contacts->SupplierId);
                                foreach ($rows_suppliers as $row_suppliers) {
                                    if ($row_supplier_contacts->SupplierId == $row_suppliers->Id) {
                                        echo "<option value=\"$row_suppliers->Id\" selected>".$row_suppliers->Name."</option>";
                                    }
                                    else {
                                        echo "<option value=\"$row_suppliers->Id\">".$row_suppliers->Name."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit" onclick="check2Fields('Title', 'SupplierId');">Update</button>
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
</html>
