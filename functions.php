<?php
require "../conn.php";
// checking if a user is logged in
if (!isset($_SESSION['usersId'])){
    header("location:index.php?error=2");
}

// checking for deactivated users and getting users departmentId to check access
$ROWS = table_users('select', $_SESSION['usersId']);
foreach ($ROWS as $ROW) {
    $s = $ROW->Status;
    $d = $ROW->DepartmentId;
}

if ($s == 0) {
    header("location:index.php?error=3");
}

//function to select Titles for names
function select_titles($Title) {
    switch ($Title) {
        case 'Mr':
            echo "<option value=\"Mr\" selected>Mr</option>";
            echo "<option value=\"Ms\">Ms</option>";
            echo "<option value=\"Mrs\">Mrs</option>";
            break;
        case 'Ms':
            echo "<option value=\"Mr\">Mr</option>";
            echo "<option value=\"Ms\" selected>Ms</option>";
            echo "<option value=\"Mrs\">Mrs</option>";
            break;
        case 'Mrs':
            echo "<option value=\"Mr\">Mr</option>";
            echo "<option value=\"Ms\">Ms</option>";
            echo "<option value=\"Mrs\" selected>Mrs</option>";
            break;
        default:
            echo "<option value=\"\">Select</option>";
            echo "<option value=\"Mr\">Mr</option>";
            echo "<option value=\"Ms\">Ms</option>";
            echo "<option value=\"Mrs\">Mrs</option>";
            break;
    }
}

//function to get data from the table users
function table_users($job, $usersId) {
    $database = new Database();

    if ($job == 'insert') {
        $Username = trim($_REQUEST['Username']);
        $Password = trim($_REQUEST['Password']);
        $Title = trim($_REQUEST['Title']);
        $Fullname = trim($_REQUEST['Fullname']);
        $Position = trim($_REQUEST['Position']);
        $DepartmentId = trim($_REQUEST['DepartmentId']);
        $Status = trim($_REQUEST['Status']);
        $Email = trim($_REQUEST['Email']);
        $Mobile = trim($_REQUEST['Mobile']);
        $query = "INSERT INTO users (
            Username,
            Password,
            Title,
            Fullname,
            Position,
            DepartmentId,
            Status,
            Email,
            Mobile
            ) VALUES(
            :Username,
            :Password,
            :Title,
            :Fullname,
            :Position,
            :DepartmentId,
            :Status,
            :Email,
            :Mobile
            )
        ;";
        $database->query($query);
        $database->bind(':Username', $Username);
        $database->bind(':Password', $Password);
        $database->bind(':Title', $Title);
        $database->bind(':Fullname', $Fullname);
        $database->bind(':Position', $Position);
        $database->bind(':DepartmentId', $DepartmentId);
        $database->bind(':Status', $Status);
        $database->bind(':Email', $Email);
        $database->bind(':Mobile', $Mobile);
        if($database->execute()) {
            header('location:users.php');
        }
    }
    elseif ($job == 'select') {
        if ($usersId == NULL || empty($usersId) || $usersId == "") {
            $query = "SELECT
                users.Id,
                users.Username,
                users.Password,
                users.Title,
                users.Fullname,
                users.Position,
                users.DepartmentId,
                users.Access,
                users.Status,
                users.Email,
                users.Mobile,
                departments.Name AS DepartmentsName
                FROM users
                LEFT OUTER JOIN departments
                ON users.DepartmentId = departments.Id
            ;";
            $database->query($query);
        }
        else {
            $query = "SELECT
                users.Id,
                users.Username,
                users.Password,
                users.Title,
                users.Fullname,
                users.Position,
                users.DepartmentId,
                users.Access,
                users.Status,
                users.Email,
                users.Mobile,
                departments.Name AS DepartmentsName
                FROM users
                LEFT OUTER JOIN departments
                ON users.DepartmentId = departments.Id
                WHERE users.Id = :usersId
            ;";
            $database->query($query);
            $database->bind(':usersId', $usersId);
        }
        return $r = $database->resultset();
    }
    elseif ($job == 'search') {
        $search = '%'.$usersId.'%';
        $query = "SELECT
            users.Id,
            users.Username,
            users.Password,
            users.Title,
            users.Fullname,
            users.Position,
            users.DepartmentId,
            users.Access,
            users.Status,
            users.Email,
            users.Mobile,
            departments.Name AS DepartmentsName
            FROM users LEFT JOIN departments
            ON users.departmentId = departments.Id
            WHERE CONCAT(
            users.Username,
            users.Password,
            users.Title,
            users.Fullname,
            users.Position,
            departments.Name,
            users.Access,
            users.Status,
            users.Email,
            users.Mobile
        ) LIKE :search
        ;";
        $database->query($query);
        $database->bind(':search', $search);
        return $r = $database->resultset();
    }
    elseif ($job == 'update') {
        $Username = trim($_REQUEST['Username']);
        $Password = trim($_REQUEST['Password']);
        $Title = trim($_REQUEST['Title']);
        $Fullname = trim($_REQUEST['Fullname']);
        $Position = trim($_REQUEST['Position']);
        $DepartmentId = trim($_REQUEST['DepartmentId']);
        $Status = trim($_REQUEST['Status']);
        $Email = trim($_REQUEST['Email']);
        $Mobile = trim($_REQUEST['Mobile']);
        $Id = $_REQUEST['Id'];

        $query = "UPDATE users SET
        Username = :Username,
        Password = :Password,
        Title = :Title,
        Fullname = :Fullname,
        Position = :Position,
        DepartmentId = :DepartmentId,
        Status = :Status,
        Email = :Email,
        Mobile = :Mobile
        WHERE Id = :Id
        ;";
        $database->query($query);
        $database->bind(':Username', $Username);
        $database->bind(':Password', $Password);
        $database->bind(':Title', $Title);
        $database->bind(':Fullname', $Fullname);
        $database->bind(':Position', $Position);
        $database->bind(':DepartmentId', $DepartmentId);
        $database->bind(':Status', $Status);
        $database->bind(':Email', $Email);
        $database->bind(':Mobile', $Mobile);
        $database->bind(':Id', $Id);
        $database->execute();
    }
}

//function to insert date to the table posts
function table_posts($job, $postsId) {
    $database = new Database();

    if($job == 'insert') {
        $UserId = $_SESSION['usersId'];
        $Subject = trim($_REQUEST['Subject']);
        $Post = $_REQUEST['Post'];
        $query = "INSERT INTO posts (
            Subject,
            Post,
            UserId
            ) VALUE (
            :Subject,
            :Post,
            :UserId
            )
        ;";
        $database->query($query);
        $database->bind(':Subject', $Subject);
        $database->bind(':Post', $Post);
        $database->bind(':UserId', $UserId);
        if($database->execute()) {
            header('location:home.php');
        }
    }
    elseif ($job == 'select') {
        if ($postsId == NULL || empty($postsId) || $postsId == "") {
            $query = "SELECT
                posts.Id AS postsId,
                posts.Subject AS Subject,
                posts.Post AS Post,
                posts.Generator AS Generator,
                posts.UserId AS UserId,
                posts.Created AS Created,
                posts.Updated AS Updated,
                users.Fullname AS Fullname
                FROM posts
                LEFT OUTER JOIN users
                ON posts.UserId = users.Id
                ORDER BY posts.Updated
            ;";
            $database->query($query);
            return $r = $database->resultset();
        }
        else {
            $query = "SELECT
                posts.Id AS postsId,
                posts.Subject AS Subject,
                posts.Post AS Post,
                posts.Generator AS Generator,
                posts.UserId AS UserId,
                posts.Created AS Created,
                posts.Updated AS Updated,
                users.Fullname AS Fullname
                FROM posts
                LEFT OUTER JOIN users
                ON posts.UserId = users.Id
                WHERE posts.Id = :postsId
                ORDER BY posts.Updated
            ;";
            $database->query($query);
            $database->bind(':postsId', $postsId);
            return $r = $database->resultset();
        }
    }
    elseif($job == 'search') {
        $search = '%'.$postsId.'%';
        $query = "SELECT
            posts.Id AS postsId,
            posts.Subject AS Subject,
            posts.Post AS Post,
            posts.Generator AS Generator,
            posts.UserId AS UserId,
            posts.Created AS Created,
            posts.Updated AS Updated,
            users.Fullname AS Fullname
            FROM posts
            LEFT OUTER JOIN users
            ON posts.UserId = users.Id
            WHERE CONCAT(
                posts.Subject,
                posts.Post,
                users.Fullname
            ) LIKE :search
        ;";
        $database->query($query);
        $database->bind(':search', $search);
        return $r = $database->resultset();
    }
}

// function to get data from the table departments
function table_departments($job, $departmentId) {
    $database = new Database();
    if ($job == 'select') {
        if($departmentId == NULL || $departmentId == "" || empty($departmentId)) {
            $query = "SELECT * FROM departments ORDER BY Id ;";
            $database->query($query);
        }
        else {
            $query = "SELECT * FROM departments WHERE Id = :departmentId ;";
            $database->query($query);
            $database->bind(':departmentId', $departmentId);
        }
        return $r = $database->resultset();
    }
}


//function to get data from the table agents
function table_agents($job, $agentsId) {
    $database = new Database();

    if ($job == 'insert') {
        $Name = trim($_REQUEST['Name']);
        $Address = trim($_REQUEST['Address']);
        $Township = trim($_REQUEST['Township']);
        $City = trim($_REQUEST['City']);
        $Country = trim($_REQUEST['Country']);
        $Phone = trim($_REQUEST['Phone']);
        $Fax = trim($_REQUEST['Fax']);
        $Email = trim($_REQUEST['Email']);
        $Website = trim($_REQUEST['Website']);

        $query = "INSERT INTO agents (
            Name,
            Address,
            Township,
            City,
            Country,
            Phone,
            Fax,
            Email,
            Website
            ) VALUES (
            :Name,
            :Address,
            :Township,
            :City,
            :Country,
            :Phone,
            :Fax,
            :Email,
            :Website
            )
        ;";
        $database->query($query);
        $database->bind(':Name', $Name);
        $database->bind(':Address', $Address);
        $database->bind(':Township', $Township);
        $database->bind(':City', $City);
        $database->bind(':Country', $Country);
        $database->bind(':Phone', $Phone);
        $database->bind(':Fax', $Fax);
        $database->bind(':Email', $Email);
        $database->bind(':Website', $Website);
        if ($database->execute()) {
            header("location: agents.php");
        }
    }
    elseif ($job == 'select') {
        if ($agentsId == NULL || $agentsId == "" || empty($agentsId)) {
            $query = "SELECT * FROM agents ;";
            $database->query($query);
            return $r = $database->resultset();
        }
        else {
            $query = "SELECT * FROM agents WHERE Id = :Id ;";
            $database->query($query);
            $database->bind(':Id', $agentsId);
            return $r = $database->resultset();
        }
    }
    elseif ($job == 'search') {
        $search = '%'.$agentsId.'%';
        $query = "SELECT * FROM agents
            WHERE CONCAT(
            Name,
            Address,
            Township,
            City,
            Country,
            Phone,
            Fax,
            Email,
            Website
            ) LIKE :search
        ;";
        $database->query($query);
        $database->bind(':search', $search);
        return $r = $database->resultset();
    }
    elseif ($job == 'update') {
        $Name = trim($_REQUEST['Name']);
        $Address = trim($_REQUEST['Address']);
        $Township = trim($_REQUEST['Township']);
        $City = trim($_REQUEST['City']);
        $Country = trim($_REQUEST['Country']);
        $Phone = trim($_REQUEST['Phone']);
        $Fax = trim($_REQUEST['Fax']);
        $Email = trim($_REQUEST['Email']);
        $Website = trim($_REQUEST['Website']);

        $query = "UPDATE agents SET
            Name = :Name,
            Address = :Address,
            Township = :Township,
            City = :City,
            Country = :Country,
            Phone = :Phone,
            Fax = :Fax,
            Email = :Email,
            Website = :Website
            WHERE Id = :agentsId
        ;";
        $database->query($query);
        $database->bind(':Name', $Name);
        $database->bind(':Address', $Address);
        $database->bind(':Township', $Township);
        $database->bind(':City', $City);
        $database->bind(':Country', $Country);
        $database->bind(':Phone', $Phone);
        $database->bind(':Fax', $Fax);
        $database->bind(':Email', $Email);
        $database->bind(':Website', $Website);
        $database->bind(':agentsId', $agentsId);
        if ($database->execute()) {
            header("location:edit_agent.php?agentsId=$agentsId");
        }
    }
    elseif ($job == 'check') {
        $Name = trim($_REQUEST['Name']);
        $Address = trim($_REQUEST['Address']);
        $Township = trim($_REQUEST['Township']);
        $City = trim($_REQUEST['City']);
        $Country = trim($_REQUEST['Country']);
        $Phone = trim($_REQUEST['Phone']);
        $Fax = trim($_REQUEST['Fax']);
        $Email = trim($_REQUEST['Email']);
        $Website = trim($_REQUEST['Website']);

        $query = "SELECT Id FROM agents WHERE
            Name = :Name
        ;";
        $database->query($query);
        $database->bind(':Name', $Name);
        $database->execute();
        return $r = $database->rowCount();
    }
}

//function to insert and select data from the table agent_contacts
function table_agent_contacts($job, $agent_contactsId) {
    $database = new Database();

    switch ($job) {
        case 'insert':
            $Title = $_REQUEST['Title'];
            $Name = trim($_REQUEST['Name']);
            $Position = trim($_REQUEST['Position']);
            $Department = trim($_REQUEST['Department']);
            $Mobile = trim($_REQUEST['Mobile']);
            $Email = trim($_REQUEST['Email']);
            $AgentId = trim($_REQUEST['AgentId']);

            $query = "INSERT INTO agent_contacts(
                Title,
                Name,
                Position,
                Department,
                Mobile,
                Email,
                AgentId
                ) VALUES(
                :Title,
                :Name,
                :Position,
                :Department,
                :Mobile,
                :Email,
                :AgentId
                )
            ;";
            $database->query($query);
            $database->bind(':Title', $Title);
            $database->bind(':Name', $Name);
            $database->bind(':Position', $Position);
            $database->bind(':Department', $Department);
            $database->bind(':Mobile',$Mobile);
            $database->bind(':Email', $Email);
            $database->bind(':AgentId', $AgentId);
            if ($database->execute()) {
                header("location: agent_contacts.php");
            }
            break;

        case 'select':
            if ($agent_contactsId == NULL || $agent_contactsId == "" || empty($agent_contactsId)) {
                $query = "SELECT
                    agent_contacts.Id,
                    agent_contacts.Title,
                    agent_contacts.Name,
                    agent_contacts.Position,
                    agent_contacts.Department,
                    agent_contacts.Mobile,
                    agent_contacts.Email,
                    agent_contacts.AgentId,
                    agents.Name AS AgentName
                    FROM agent_contacts
                    LEFT OUTER JOIN agents
                    ON agent_contacts.AgentId = agents.Id
                ;";
                $database->query($query);
            }
            else {
                $query = "SELECT
                    agent_contacts.Id,
                    agent_contacts.Title,
                    agent_contacts.Name,
                    agent_contacts.Position,
                    agent_contacts.Department,
                    agent_contacts.Mobile,
                    agent_contacts.Email,
                    agent_contacts.AgentId,
                    agents.Name AS AgentName
                    FROM agent_contacts
                    LEFT OUTER JOIN agents
                    ON agent_contacts.AgentId = agents.Id
                    WHERE agent_contacts.Id = :agent_contactsId
                ;";
                $database->query($query);
                $database->bind(':agent_contactsId', $agent_contactsId);
            }
            return $r = $database->resultset();
            break;

        case 'search':
            $search = '%'.$agent_contactsId.'%';
            $query = "SELECT
                agent_contacts.Id,
                agent_contacts.Title,
                agent_contacts.Name,
                agent_contacts.Position,
                agent_contacts.Department,
                agent_contacts.Mobile,
                agent_contacts.Email,
                agent_contacts.AgentId,
                agents.Name AS AgentName
                FROM agent_contacts
                LEFT OUTER JOIN agents
                ON agent_contacts.AgentId = agents.Id
                WHERE CONCAT (
                agent_contacts.Title,
                agent_contacts.Name,
                agent_contacts.Position,
                agent_contacts.Department,
                agent_contacts.Mobile,
                agent_contacts.Email,
                agents.Name
                ) LIKE :search
            ;";
            $database->query($query);
            $database->bind(':search', $search);
            return $r = $database->resultset();
            break;

        case 'update':
            $Title = $_REQUEST['Title'];
            $Name = trim($_REQUEST['Name']);
            $Position = trim($_REQUEST['Position']);
            $Department = trim($_REQUEST['Department']);
            $Mobile = trim($_REQUEST['Mobile']);
            $Email = trim($_REQUEST['Email']);
            $AgentId = trim($_REQUEST['AgentId']);

            $query = "UPDATE agent_contacts SET
                Title = :Title,
                Name = :Name,
                Position = :Position,
                Department = :Department,
                Mobile = :Mobile,
                Email = :Email,
                AgentId = :AgentId
                WHERE Id = :agent_contactsId
            ;";
            $database->query($query);
            $database->bind(':Title', $Title);
            $database->bind(':Name', $Name);
            $database->bind(':Position', $Position);
            $database->bind(':Department', $Department);
            $database->bind(':Mobile', $Mobile);
            $database->bind(':Email', $Email);
            $database->bind(':AgentId', $AgentId);
            $database->bind(':agent_contactsId', $agent_contactsId);
            if ($database->execute()) {
                header("location: edit_agent_contact.php?agent_contactsId=$agent_contactsId");
            }
            break;

        case 'check':
            $Title = $_REQUEST['Title'];
            $Name = trim($_REQUEST['Name']);
            $Position = trim($_REQUEST['Position']);
            $Department = trim($_REQUEST['Department']);
            $Mobile = trim($_REQUEST['Mobile']);
            $Email = trim($_REQUEST['Email']);
            $AgentId = trim($_REQUEST['AgentId']);

            $query = "SELECT * FROM agent_contacts WHERE
                Name = :Name
                AND Email = :Email
                AND AgentId = :AgentId
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':Email', $Email);
            $database->bind(':AgentId', $AgentId);
            $database->execute();
            return $r = $database->rowCount();
            break;

        default:
            // code...
            break;
    }
}

?>
