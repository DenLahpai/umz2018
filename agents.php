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
    $rows_agents = table_agents('select_all', NULL, NULL);
}
else {
    $rows_agents = table_agents('search', $search, NULL);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Agents";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Agents";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <!-- sub-menu -->
            <div class="sub-menu">
                <form action="#" method="post">
                <ul>
                    <li>
                        <a href="new_agent.php">
                            <button type="button" class="button medium" name="button">Create New Agent</button></a>
                    </li>
                    <li>
                        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search Agents">
                        <button type="submit" class="button search" name="buttonSearch">Search</button>
                    </li>
                </ul>
                </form>
            </div>
            <!-- end of sub-menu -->
            <main>
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    foreach ($rows_agents as $row_agents) {
                        echo "<!-- grid-item -->";
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        echo "<li><h4>".$row_agents->Name."</h4></li>";
                        echo "<li>".$row_agents->Address."</li>";
                        echo "<li>".$row_agents->Township.", ".$row_agents->City."</li>";
                        echo "<li>".$row_agents->Phone."</li>";
                        echo "<li>".$row_agents->Fax."</li>";
                        echo "<li>".$row_agents->Email."</li>";
                        echo "<li>".$row_agents->Website."</li>";
                        echo "<li style=\"text-align: center;\"><a href=\"edit_agent.php?agentsId=$row_agents->Id\"><button class=\"button link\">Edit</button></a>";
                        echo "</ul>";
                        echo "</div>";
                        echo "<!-- end of grid-item -->";
                    }
                    ?>
                </div>
                <!-- endo of grid-div -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
