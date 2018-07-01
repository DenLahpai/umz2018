<?php
require "functions.php";

//getting data from the table
if (isset($_REQUEST['buttonSearch'])) {
    $search = $_REQUEST['search'];
}
else {
    $search = NULL;
}

if(empty($search) || $search == NULL || $search == "") {
    $rows_agent_contacts = table_agent_contacts('select', NULL);
}
else {
    $rows_agent_contacts = table_agent_contacts('search', $search);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Agent Contacts";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Agent Contacts";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <!-- sub-menu -->
            <div class="sub-menu">
                <form action="#" method="post">
                <ul>
                    <li>
                        <a href="new_agent_contact.php">
                            <button type="button" class="button medium" name="button">Create New Contact</button></a>
                    </li>
                    <li>
                        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search Agent Contacts">
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
                    foreach ($rows_agent_contacts as $row_agent_contacts) {
                        echo "<!-- grid-item -->";
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        echo "<li style=\"font-weight: bold;\">".$row_agent_contacts->Title.". ".$row_agent_contacts->Name."</li>";
                        echo "<li>".$row_agent_contacts->Position."</li>";
                        echo "<li>".$row_agent_contacts->Department."</li>";
                        echo "<li style=\"font-weight: bold;\">".$row_agent_contacts->AgentName."</li>";
                        echo "<li>Mobile: &nbsp;".$row_agent_contacts->Mobile."</li>";
                        echo "<li><a href=\"mailto:$row_agent_contacts->Email\">".$row_agent_contacts->Email."</a></li>";
                        echo "<li style=\"text-align: center;\"><a href=\"edit_agent_contact.php?agent_contactsId=$row_agent_contacts->Id\"><button>Edit</button></a></li>";
                        echo "</ul>";
                        echo "</div>";
                        echo "<!-- end of grid-item>";
                    }
                    ?>
                </div>
                <!-- end of grid-div -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
</html>
