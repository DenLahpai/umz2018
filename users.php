<?php
require_once "functions.php";
//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

//getting data from the table
if (isset($_REQUEST['buttonSearch'])) {
    $search = $_REQUEST['search'];
}
else {
    $search = NULL;
}

if(empty($search) || $search == NULL || $search == "") {
    $rows_users = table_users('select_all', NULL, NULL);
}
else {
    $rows_users = table_users('search', $search, NULL);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Users";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "./includes/main_menu.html";
            $header = "Users";
            include "./includes/header.html";
            ?>
            <!-- sub-menu -->
            <div class="sub-menu">
                <form action="#" method="post">
                <ul>
                    <li>
                        <a href="new_user.php">
                            <button type="button" class="button medium" name="button">Create New User</button></a>
                    </li>
                    <li>
                        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search Users">
                        <button type="submit" class="button search" name="buttonSearch">Search</button>
                    </li>
                </ul>
                </form>
            </div>
            <!-- end of sub-menu -->
            <main>
                <!-- table medium -->
                <div class="table medium">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Title</th>
                                <th>Fullname</th>
                                <th>Position</th>
                                <th>Department</th>
                                <th>Access</th>
                                <th>Status</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Ctl</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rows_users as $row_users) {
                                echo "<tr>";
                                echo "<td>".$row_users->Id."</td>";
                                echo "<td>".$row_users->Username."</td>";
                                echo "<td>".$row_users->Password."</td>";
                                echo "<td>".$row_users->Title."</td>";
                                echo "<td>".$row_users->Fullname."</td>";
                                echo "<td>".$row_users->Position."</td>";
                                echo "<td>".$row_users->DepartmentsName."</td>";
                                echo "<td>".$row_users->Access."</td>";
                                echo "<td>".$row_users->Status."</td>";
                                echo "<td>".$row_users->Email."</td>";
                                echo "<td>".$row_users->Mobile."</td>";
                                echo "<td><a href=\"edit_user.php?Id=$row_users->Id\"><button class=\"button link\">Edit</button></a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- end of table medium -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "./includes/footer.html"; ?>
    </body>
</html>
