<?php
require "functions.php";
if ($d > 2) {
    header("location: no_access.php");
}

//getting users Id to be edited
$Id = $_REQUEST['Id'];

//getting data from the tables users
$rows_users = table_users('select', $Id);
foreach ($rows_users as $row_users) {
    // code...
}

//update the users data when the form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Username = trim($_REQUEST['Username']);
    if ($Username == $row_users->Username) {
        table_users('update', $Id);
    }
    else {
        $rowCount = table_users('check', NULL);
        if($rowCount == 0) {
            table_users('update', $Id);
        }
        else {
            $error_message = "Username already exists!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit User";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit User";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <form id="theform" action="#" method="post">
                    <ul>
                        <li class="notice error">
                            <?php
                            if (!empty($error_message)) {
                                echo $error_message;
                            }
                            ?>
                        </li>
                        <li>
                            Username: &nbsp;
                            <input type="text" name="Username" id="Username" value="<?php echo $row_users->Username; ?>" required>
                        </li>
                        <li>
                            Password: &nbsp;
                            <input type="text" name="Password" id="Password" value="<?php echo $row_users->Password; ?>" required>
                        </li>
                        <li>
                            Title: &nbsp;
                            <select name="Title" id="Title">
                                <?php
                                select_titles($row_users->Title);
                                ?>
                            </select>
                        </li>
                        <li>
                            Fullname: &nbsp;
                            <input type="text" name="Fullname" id="Fullname" value="<?php echo $row_users->Fullname; ?>" required>
                        </li>
                        <li>
                            Position: &nbsp;
                            <input type="text" name="Position" id="Position" value="<?php echo $row_users->Position?>">
                        </li>
                        <li>
                            Department: &nbsp;
                            <select name="DepartmentId" id="DepartmentId">
                                <?php
                                $rows_departments = table_departments('select', $row_users->DepartmentId);
                                foreach ($rows_departments as $row_departments) {
                                    echo "<option value=\"$row_departments->Id\">".$row_departments->Name."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            Status: &nbsp;
                            <select name="Status">
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </li>
                        <li>
                            Email: &nbsp;
                            <input type="email" name="Email" id="Email" value="<?php echo $row_users->Email; ?>">
                        </li>
                        <li>
                            Mobile: &nbsp;
                            <input type="text" name="Mobile" id="Mobile" value="<?php echo $row_users->Mobile; ?>">
                        </li>
                        <li>
                            <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit" onclick="check2Fields('Title', 'DepartmentId');">Apply Changes</button>
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
