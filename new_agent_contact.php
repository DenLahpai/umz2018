<?php
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_agent_contacts('check', NULL);
    if ($rowCount == 0) {
        table_agent_contacts('insert', NULL);
    }
    else {
        $error_message = "Duplicate Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "New Agent Contact";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "New Agent Contact";
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
                                <?php select_titles(NULL); ?>
                            </select>
                        </li>
                        <li>
                            Name: &nbsp;
                            <input type="text" name="Name" id="Name" placeholder="Full Name" required>
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
                            <input type="text" name="Email" id="Email" placeholder="someone@company.com" required>
                        </li>
                        <li>
                            Agent: &nbsp;
                            <select name="AgentId" id="AgentId">
                                <option value="">Select</option>
                                <?php
                                $rows_agents =  table_agents('select_all', NULL, NULL);
                                foreach ($rows_agents as $row_agents) {
                                    echo "<option value=\"$row_agents->Id\">".$row_agents->Name."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit" onclick="check2Fields('Title', 'AgentId');">Submit</button>
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
