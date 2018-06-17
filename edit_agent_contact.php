<?php
require "functions.php";

//getting agent_contact Id to be edited
$agent_contactsId = trim($_REQUEST['agent_contactsId']);

//getting data from the table agent_contacts
$rows_agent_contacts = table_agent_contacts('select', $agent_contactsId);
foreach ($rows_agent_contacts as $row_agent_contacts) {
    // code
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Name = trim($_REQUEST['Name']);
    if ($Name == $row_agent_contacts->Name) {
        table_agent_contacts('update', $agent_contactsId);
    }
    else {
        $rowCount = table_agent_contacts('check', NULL);
        if ($rowCount == 0) {
            table_agent_contacts('update', $agent_contactsId);
        }
        else {
            $error_message = "Duplicate entry!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Agent Contact";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit Agent Contact";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <main>
                <form id="theform" action="#" method="post">
                    <ul>
                        <li class="notice error">
                            <?php
                            if(!empty($error_message)) {
                                echo $error_message;
                            }
                            ?>
                        </li>
                        <li>
                            Title: &nbsp;
                            <select id="Title" name="Title">
                                <?php select_titles($row_agent_contacts->Title);?>
                            </select>
                        </li>
                        <li>
                            Name: &nbsp;
                            <input type="text" name="Name" id="Name" value="<?php echo $row_agent_contacts->Name;?>" required>
                        </li>
                        <li>
                            Position: &nbsp;
                            <input type="text" name="Position" id="Position" value="<?php echo $row_agent_contacts->Position;?>" required>
                        </li>
                        <li>
                            Department: &nbsp;
                            <input type="text" name="Department" id="Department" value="<?php echo $row_agent_contacts->Department;?>">
                        </li>
                        <li>
                            Mobile: &nbsp;
                            <input type="text" name="Mobile" id="Mobile" value="<?php echo $row_agent_contacts->Mobile;?>" required>
                        </li>
                        <li>
                            Email: &nbsp;
                            <input type="email" name="Email" id="Email" value="<?php echo $row_agent_contacts->Email;?>" required>
                        </li>
                        <li>
                            Agent: &nbsp;
                            <select id="AgentId" name="AgentId">
                                <?php
                                $rows_agents = table_agents('select', NULL);
                                foreach ($rows_agents as $row_agents) {
                                    if  ($row_agents->Id == $row_agent_contacts->AgentId) {
                                        echo "<option value=\"$row_agents->Id\" selected>".$row_agents->Name."</option>";
                                    }
                                    else {
                                        echo "<option value=\"$row_agents->Id\">".$row_agents->Name."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit" onclick="check2Fields('Title', 'AgentId');">Update</button>
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
