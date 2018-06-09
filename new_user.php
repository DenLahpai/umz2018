<?php
require_once "functions.php";
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "New User";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Create New User";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <form id="new_user" action="#" method="post">
                    <ul>
                        <li>
                            Username: &nbsp;
                            <input type="text" name="Username" id="Username" placeholder="Username" required>
                        </li>
                        <li>
                            Password: &nbsp;
                            <input type="text" name="Password" id="Password" placeholder="Password" required>
                        </li>
                        <li>
                            Title: &nbsp;
                            <select name="Title">
                                <?php
                                select_titles(NULL);
                                ?>
                            </select>
                        </li>
                        <li>
                            Fullname: &nbsp;
                            <input type="text" name="Fullname" id="Fullname" placeholder="Full Name of the user" required>
                        </li>
                        <li>
                            Position: &nbsp;
                            <input type="text" name="Position" id="Position" placeholder="Position">
                        </li>
                        <li>
                            Department: $nbsp;
                            <select name="DepartmentId">
                                <option value="">Select</option>
                                <?php
                                $rows_departments = table_departments('select', NULL);
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
                                <option value="0">Inactive</option>
                            </select>
                        </li>
                        <li>
                            Email: &nbsp;
                            <input type="Email" name="Email" id="Email" placeholder="someone@email.com">
                        </li>
                        <li>
                            Mobile: &nbsp;
                            <input type="text" name="Mobile" id="Mobile" placeholder="">
                        </li>
                        <li>
                            <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit">Create</button>
                        </li>
                    </ul>
                </form>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
