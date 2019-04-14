<?php
require "conn.php";
// checking if a user is logged in
if (!isset($_SESSION['usersId'])){
    header("location:index.php?error=2");
}

// checking for deactivated users and getting users DepartmentId to check access
$ROWS = table_users('select_one', $_SESSION['usersId'], NULL);
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

//function to use the table users
function table_users($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'check_before_insert':
            $Username = trim($_REQUEST['Username']);
            $query = "SELECT * FROM users WHERE Username = :Username ;";
            $database->query($query);
            $database->bind(':Username', $Username);
            return $r = $database->rowCount();
            break;

        case 'insert':
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
            break;

        case 'select_all':
            // selecting all the users
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
            return $r = $database->resultset();
            break;

        case 'select_one':
            // $var1 = usersId
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
            $database->bind(':usersId', $var1);
            return $r = $database->resultset();
            break;

        case 'check_before_update':
            $Username = trim($_REQUEST['Username']);
            $query = "SELECT * FROM users
                WHERE Username = :Username
                AND Id != :Id
            ;";
            $database->query($query);
            $database->bind(':Username', $Username);
            $database->bind(':Id', $var1);
            return $r = $database->rowCount();
            break;

        case 'update':
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
            if ($database->execute()) {
                header("location:edit_user.php?Id=$Id");
            }
            break;

        case 'search':
            // $var1 = search
            $search = '%'.$var1.'%';
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
                ON users.DepartmentId = departments.Id
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
            break;

        default:
            // code...
            break;
    }
}

//function to use the table posts
function table_posts($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {

        case 'insert':
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
            break;

        case 'select_all':
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
            break;

        case 'search':
            // $var1 = search
            $search = '%'.$var1.'%';
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
            break;

        case 'select_one':
            // $var1 = postsId
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
            $database->bind(':postsId', $var1);
            return $r = $database->resultset();
            break;

        case 'update':
            // $var1 = postsId
            $Subject = trim($_REQUEST['Subject']);
            $Post = $_REQUEST['Post'];
            $query = "UPDATE posts SET
                Subject = :Subject,
                Post = :Post
                WHERE Id = :postsId
            ;";
            $database->query($query);
            $database->bind(':Subject', $Subject);
            $database->bind(':Post', $Post);
            $database->bind(':postsId', $var1);
            if ($database->execute()) {
                header("location: edit_post.php?postsId=$var1");
            }
            break;

        default:
            // code...
            break;
    }

}

// function to get the table departments
function table_departments($job, $departmentsId) {
    $database = new Database();
    if ($job == 'select') {
        if($departmentsId == NULL || $departmentsId == "" || empty($departmentsId)) {
            $query = "SELECT * FROM departments ORDER BY Id ;";
            $database->query($query);
        }
        else {
            $query = "SELECT * FROM departments WHERE Id = :departmentsId ;";
            $database->query($query);
            $database->bind(':departmentsId', $departmentsId);
        }
        return $r = $database->resultset();
    }
}

//function to use the table agents
function table_agents($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'check_before_insert':
            $Name = trim($_REQUEST['Name']);
            $query = "SELECT Id FROM agents WHERE
                Name = :Name
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->execute();
            return $r = $database->rowCount();
            break;

        case 'insert':
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
            break;

        case 'select_all':
            $query = "SELECT * FROM agents ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'select_one':
            //$var1 = agentsId
            $query = "SELECT * FROM agents WHERE Id = :Id ;";
            $database->query($query);
            $database->bind(':Id', $var1);
            return $r = $database->resultset();
            break;

        case 'check_before_update':
            //$var1 = $agentsId
            $Name = trim($_REQUEST['Name']);
            $query = "SELECT * FROM agents
                WHERE Name = :Name
                AND Id != :agentsId
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':agentsId', $var1);
            break;

        case 'update':
            //$var1 = $agentsId
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
            $database->bind(':agentsId', $var1);
            if ($database->execute()) {
                header("location:edit_agent.php?agentsId=$var1");
            }
            break;

        case 'search':
            // $var1 = search
            $search = '%'.$var1.'%';
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
            break;

        default:
            // code...
            break;
    }
}

//function to use the table agent_contacts
function table_agent_contacts($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {

        case 'check_before_insert':
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

        case 'select_all':
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
            return $r = $database->resultset();
            break;

        case 'select_one':
            // $var1 = $agent_contactsId
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
            $database->bind(':agent_contactsId', $var1);
            return $r = $database->resultset();
            break;

        case 'search':
            $search = '%'.$var1.'%';
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

        case 'check_before_update':
            // $var1 = $agent_contactsId
            $Name = trim($_REQUEST['Name']);
            $Email = trim($_REQUEST['Email']);

            $query = "SELECT * FROM agent_contacts
                WHERE Name = :Name
                AND Email = :Email
                AND Id != :agent_contactsId
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':Email', $Email);
            $database->bind(':agent_contactsId', $var1);
            return $r = $database->rowCount();
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
            $database->bind(':agent_contactsId', $var1);
            if ($database->execute()) {
                header("location: edit_agent_contact.php?agent_contactsId=$var1");
            }
            break;

        case 'search':
            // $var1 = search
            break;

        default:
            // code...
            break;
    }
}

//function to use the table tour_guides
function table_tour_guides($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {

        case 'check_before_insert':
            $Name = trim($_REQUEST['Name']);
            $License = trim($_REQUEST['License']);
            $Mobile = trim($_REQUEST['Mobile']);
            $Email = trim($_REQUEST['Email']);

            $query = "SELECT Id FROM tour_guides WHERE
                Name = :Name AND
                Mobile = :Mobile AND
                License = :License AND
                Email = :Email
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':License', $License);
            $database->bind(':Mobile', $Mobile);
            $database->bind(':Email', $Email);
            return $r = $database->rowCount();
            break;

        case 'insert':
            $Title = $_REQUEST['Title'];
            $Name = trim($_REQUEST['Name']);
            $Mobile = trim($_REQUEST['Mobile']);
            $License = trim($_REQUEST['License']);
            $Type = trim($_REQUEST['Type']);
            $Language = trim($_REQUEST['Language']);
            $Email = trim($_REQUEST['Email']);

            $query = "INSERT INTO tour_guides (
                Title,
                Name,
                Mobile,
                License,
                Type,
                Language,
                Email
                ) VALUES (
                :Title,
                :Name,
                :Mobile,
                :License,
                :Type,
                :Language,
                :Email
                )
            ;";
            $database->query($query);
            $database->bind(':Title', $Title);
            $database->bind(':Name', $Name);
            $database->bind(':Mobile', $Mobile);
            $database->bind(':License', $License);
            $database->bind(':Type', $Type);
            $database->bind(':Language', $Language);
            $database->bind(':Email', $Email);
            if ($database->execute()) {
                header("location: tourguides.php");
            }
            break;

        case 'select_all':
            $query = "SELECT * FROM tour_guides ORDER BY Name ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'select_one':
            // $var1 = $tour_guidesId
            $query = "SELECT * FROM tour_guides WHERE Id = :Id ;";
            $database->query($query);
            $database->bind(':Id', $var1);
            return $r = $database->resultset();
            break;

        case 'search':
            $search = '%'.$var1.'%';
            $query = "SELECT * FROM tour_guides WHERE CONCAT (
                Title,
                Name,
                Mobile,
                License,
                Type,
                Language,
                Email
                ) LIKE :search
            ;";
            $database->query($query);
            $database->bind(':search', $search);
            return $r = $database->resultset();
            break;

        case 'check_before_update':
            // $var1 = $tour_guidesId
            $Name = trim($_REQUEST['Name']);
            $License = trim($_REQUEST['License']);
            $query = "SELECT * FROM tour_guides
                WHERE Name = :Name
                AND License = :License
                AND Id != :tour_guidesId
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':License', $License);
            $database->bind(':tour_guidesId', $var1);
            break;

        case 'update':
            $Title = $_REQUEST['Title'];
            $Name = trim($_REQUEST['Name']);
            $Mobile = trim($_REQUEST['Mobile']);
            $License = trim($_REQUEST['License']);
            $Type = trim($_REQUEST['Type']);
            $Language = trim($_REQUEST['Language']);
            $Email = trim($_REQUEST['Email']);

            $query = "UPDATE tour_guides SET
                Title = :Title,
                Name = :Name,
                Mobile = :Mobile,
                License = :License,
                Type = :Type,
                Language = :Language,
                Email = :Email
                WHERE Id = :tour_guidesId
            ;";
            $database->query($query);
            $database->bind(':Title', $Title);
            $database->bind(':Name', $Name);
            $database->bind(':Mobile', $Mobile);
            $database->bind(':License', $License);
            $database->bind(':Type',$Type);
            $database->bind(':Language', $Language);
            $database->bind(':Email', $Email);
            $database->bind(':tour_guidesId', $var1);
            if ($database->execute()) {
                header("location: edit_tourguide.php?tour_guidesId=$var1");
            }
            break;

        default:
            // code...
            break;
    }
}

//function to use the table table_suppliers
function table_suppliers($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'check_before_insert':
            $Name = trim($_REQUEST['Name']);
            $query = "SELECT * FROM suppliers
                WHERE Name = :Name
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            return $r = $database->rowCount();
            break;

        case 'insert':
            $Name = trim($_REQUEST['Name']);
            $Address = trim($_REQUEST['Address']);
            $City = trim($_REQUEST['City']);
            $Phone = trim($_REQUEST['Phone']);
            $Email = trim($_REQUEST['Email']);

            $query = "INSERT INTO suppliers (
                Name,
                Address,
                City,
                Phone,
                Email
                ) VALUES(
                :Name,
                :Address,
                :City,
                :Phone,
                :Email
                )
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':Address', $Address);
            $database->bind(':City', $City);
            $database->bind(':Phone', $Phone);
            $database->bind(':Email', $Email);
            if ($database->execute()) {
                header("location: suppliers.php");
            }
            break;

        case 'select_all':
            $query = "SELECT * FROM suppliers ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'select_one':
            // $var1 = $suppliersId
            $query = "SELECT * FROM suppliers WHERE Id = :suppliersId ;";
            $database->query($query);
            $database->bind(':suppliersId', $var1);
            return $r = $database->resultset();
            break;

        case 'search':
            $search = '%'.$var1.'%';
            $query = "SELECT * FROM suppliers WHERE CONCAT(
                Name,
                Address,
                City,
                Phone,
                Email
                ) LIKE :search
            ;";
            $database->query($query);
            $database->bind(':search', $search);
            return $r = $database->resultset();
            break;

        case 'check_before_update':
            // $var1 = $suppliersId
            $Name = trim($_REQUEST['Name']);
            $query = "SELECT * FROM suppliers
                WHERE Name = :Name
                AND Id != :suppliersId
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':suppliersId', $var1);
            return $r = $database->rowCount();
            break;

        case 'update':
            // $var1 = $suppliersId
            $Name = trim($_REQUEST['Name']);
            $Address = trim($_REQUEST['Address']);
            $City = trim($_REQUEST['City']);
            $Phone = trim($_REQUEST['Phone']);
            $Email = trim($_REQUEST['Email']);

            $query = "UPDATE suppliers SET
                Name = :Name,
                Address = :Address,
                City = :City,
                Phone = :Phone,
                Email = :Email
                WHERE Id = :suppliersId
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':Address', $Address);
            $database->bind(':City', $City);
            $database->bind(':Phone', $Phone);
            $database->bind(':Email', $Email);
            $database->bind(':suppliersId', $var1);
            if ($database->execute()) {
                header("location: edit_supplier.php?suppliersId=$var1");
            }
            break;

        default:
            # code...
            break;
    }
}

//function to use data from the table supplier_contacts
function table_supplier_contacts ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {

        case 'check_before_insert':
            $Title = $_REQUEST['Title'];
            $Name = trim($_REQUEST['Name']);
            $SupplierId = $_REQUEST['SupplierId'];

            $query = "SELECT Id FROM supplier_contacts WHERE
                Title = :Title AND
                Name = :Name AND
                SupplierId = :SupplierId
            ;";
            $database->query($query);
            $database->bind(':Title', $Title);
            $database->bind(':Name', $Name);
            $database->bind(':SupplierId', $SupplierId);
            return $r = $database->rowCount();
            break;

        case 'insert':
            $Title = $_REQUEST['Title'];
            $Name = trim($_REQUEST['Name']);
            $Position = trim($_REQUEST['Position']);
            $Department = trim($_REQUEST['Department']);
            $Mobile = trim($_REQUEST['Mobile']);
            $Email = trim($_REQUEST['Email']);
            $SupplierId = $_REQUEST['SupplierId'];

            $query = "INSERT INTO supplier_contacts (
                Title,
                Name,
                Position,
                Department,
                Mobile,
                Email,
                SupplierId
                ) VALUES(
                :Title,
                :Name,
                :Position,
                :Department,
                :Mobile,
                :Email,
                :SupplierId
                )
            ;";
            $database->query($query);
            $database->bind(':Title', $Title);
            $database->bind(':Name', $Name);
            $database->bind(':Position', $Position);
            $database->bind(':Department', $Department);
            $database->bind(':Mobile', $Mobile);
            $database->bind(':Email', $Email);
            $database->bind(':SupplierId', $SupplierId);
            if ($database->execute()) {
                header("location: supplier_contacts.php");
            }
            break;

        case 'select_all':
            $query = "SELECT
                supplier_contacts.Id AS supplier_contactsId,
                supplier_contacts.Title AS Title,
                supplier_contacts.Name AS Name,
                supplier_contacts.Position AS Position,
                supplier_contacts.Department AS Department,
                supplier_contacts.Mobile AS Mobile,
                supplier_contacts.Email AS Email,
                supplier_contacts.SupplierId AS SupplierId,
                suppliers.Name AS suppliersName
                FROM supplier_contacts
                LEFT OUTER JOIN suppliers
                ON supplier_contacts.SupplierId = suppliers.Id
            ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'select_one':
            // $var1 = $supplier_contactsId
            $query = "SELECT
                supplier_contacts.Id AS supplier_contactsId,
                supplier_contacts.Title AS Title,
                supplier_contacts.Name AS Name,
                supplier_contacts.Position AS Position,
                supplier_contacts.Department AS Department,
                supplier_contacts.Mobile AS Mobile,
                supplier_contacts.Email AS Email,
                supplier_contacts.SupplierId AS SupplierId,
                suppliers.Name AS suppliersName
                FROM supplier_contacts
                LEFT OUTER JOIN suppliers
                ON supplier_contacts.SupplierId = suppliers.Id
                WHERE supplier_contacts.Id = :supplier_contactsId
            ;";
            $database->query($query);
            $database->bind(':supplier_contactsId', $var1);
            return $r = $database->resultset();
            break;

        case 'search':
            //$var1 = search;
            $search = '%'.$var1.'%';

            $query = "SELECT
                supplier_contacts.Id AS supplier_contactsId,
                supplier_contacts.Title AS Title,
                supplier_contacts.Name AS Name,
                supplier_contacts.Position AS Position,
                supplier_contacts.Department AS Department,
                supplier_contacts.Mobile AS Mobile,
                supplier_contacts.Email AS Email,
                supplier_contacts.SupplierId AS SupplierId,
                suppliers.Name AS suppliersName
                FROM supplier_contacts
                LEFT OUTER JOIN suppliers
                ON supplier_contacts.SupplierId = suppliers.Id
                WHERE CONCAT (
                supplier_contacts.Title,
                supplier_contacts.Name,
                supplier_contacts.Position,
                supplier_contacts.Department,
                supplier_contacts.Mobile,
                supplier_contacts.Email,
                suppliers.Name
                ) LIKE :search
            ;";
            $database->query($query);
            $database->bind(':search', $search);
            return $r = $database->resultset();
            break;

        case 'check_before_update':
            // $var = $supplier_contactsId
            $Name = trim($_REQUEST['Name']);
            $Mobile = trim($_REQUEST['Mobile']);
            $SupplierId = $_REQUEST['SupplierId'];
            $query = "SELECT * FROM supplier_contacts
                WHERE Name = :Name
                AND Mobile = :Mobile
                AND SupplierId = :SupplierId
                AND Id = :supplier_contactsId
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':Mobile', $Mobile);
            $database->bind(':SupplierId', $SupplierId);
            $database->bind(':supplier_contactsId', $var1);
            return $r = $database->rowCount();
            break;

        case 'update':
            // $var1 = $supplier_contactsId
            $Title = $_REQUEST['Title'];
            $Name = trim($_REQUEST['Name']);
            $Position = trim($_REQUEST['Position']);
            $Department = trim($_REQUEST['Department']);
            $Mobile = trim($_REQUEST['Mobile']);
            $Email = trim($_REQUEST['Email']);
            $SupplierId = $_REQUEST['SupplierId'];

            $query = "UPDATE supplier_contacts SET
                Title = :Title,
                Name = :Name,
                Position = :Position,
                Department = :Department,
                Mobile = :Mobile,
                Email = :Email,
                SupplierId = :SupplierId
                WHERE Id = :supplier_contactsId
            ;";
            $database->query($query);
            $database->bind(':Title', $Title);
            $database->bind(':Name', $Name);
            $database->bind(':Position', $Position);
            $database->bind(':Department', $Department);
            $database->bind(':Mobile', $Mobile);
            $database->bind(':Email', $Email);
            $database->bind(':SupplierId', $SupplierId);
            $database->bind(':supplier_contactsId', $var1);
            if ($database->execute()) {
                header("location: edit_supplier_contact.php?supplier_contactsId=$var1");
            }
            break;

        default:
            // code...
            break;
    }
}

//function to use the table vehicle
function table_vehicles ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {

        case 'check_before_insert':
            $License = trim($_REQUEST['License']);

            $query = "SELECT Id FROM vehicles WHERE License = :License ;";
            $database->query($query);
            $database->bind(':License', $License);
            return $r = $database->rowCount();
            break;

        case 'insert':
            $Type = trim($_REQUEST['Type']);
            $Seats = $_REQUEST['Seats'];
            $License = trim($_REQUEST['License']);
            $SupplierId = $_REQUEST['SupplierId'];

            $query = "INSERT INTO vehicles (
                Type,
                Seats,
                License,
                SupplierId
                ) VALUES (
                :Type,
                :Seats,
                :License,
                :SupplierId
                )
            ;";
            $database->query($query);
            $database->bind(':Type', $Type);
            $database->bind(':Seats', $Seats);
            $database->bind(':License', $License);
            $database->bind(':SupplierId', $SupplierId);
            if ($database->execute()) {
                header("location: vehicles.php");
            }
            break;

        case 'select_all':
            $query = "SELECT
                vehicles.Id,
                vehicles.Type,
                vehicles.Seats,
                vehicles.License,
                vehicles.SupplierId,
                suppliers.Name AS suppliersName
                FROM vehicles
                LEFT OUTER JOIN suppliers
                ON suppliers.Id = vehicles.SupplierId
            ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'select_one':
            // $var1 = vehiclesId
            $query = "SELECT
                vehicles.Id,
                vehicles.Type,
                vehicles.Seats,
                vehicles.License,
                vehicles.SupplierId,
                suppliers.Name AS suppliersName
                FROM vehicles
                LEFT OUTER JOIN suppliers
                ON suppliers.Id = vehicles.SupplierId
                WHERE vehicles.Id = :vehiclesId
            ;";
            $database->query($query);
            $database->bind(':vehiclesId', $var1);
            return $r = $database->resultset();
            break;

        case 'search':
            //$var1 = search
            $search = '%'.$var1.'%';

            $query = "SELECT
                vehicles.Id,
                vehicles.Type,
                vehicles.Seats,
                vehicles.License,
                vehicles.SupplierId,
                suppliers.name AS suppliersName
                FROM vehicles
                LEFT OUTER JOIN suppliers
                ON suppliers.Id = vehicles.SupplierId
                WHERE CONCAT(
                vehicles.Type,
                vehicles.Seats,
                vehicles.License,
                suppliers.Name
                ) LIKE :search
            ;";
            $database->query($query);
            $database->bind(':search', $search);
            return $r = $database->resultset();
            break;

        case 'check_before_update':
            // $var1 = $vehiclesId
            $License = trim($_REQUEST['License']);
            $query = "SELECT * FROM vehicles
                WHERE License = :License
                AND Id != :vehiclesId
            ;";
            $database->query($query);
            $database->bind(':License', $License);
            $database->bind(':vehiclesId', $var1);
            return $r = $database->rowCount();
            break;

        case 'update':
            //$var1 = $vehiclesId
            $License = trim($_REQUEST['License']);
            $Type = trim($_REQUEST['Type']);
            $Seats = trim($_REQUEST['Seats']);
            $SupplierId = $_REQUEST['SupplierId'];

            $query = "UPDATE vehicles SET
                License = :License,
                Type = :Type,
                Seats = :Seats,
                SupplierId = :SupplierId
                WHERE Id = :vehiclesId
            ;";
            $database->query($query);
            $database->bind(':License', $License);
            $database->bind(':Type', $Type);
            $database->bind(':Seats', $Seats);
            $database->bind(':SupplierId', $SupplierId);
            $database->bind(':vehiclesId', $var1);
            if ($database->execute()) {
                header("location: edit_vehicle.php?vehiclesId=$var1");
            }
            break;

        default:
            // code...
            break;
    }
}

//function to use data from the table drivers
function table_drivers ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {

        case 'check_before_insert':
            $Name = trim($_REQUEST['Name']);
            $License = trim($_REQUEST['License']);

            $query = "SELECT Id FROM drivers
                WHERE Name = :Name
                AND License = :License
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':License', $License);
            return $r = $database->rowCount();
            break;

        case 'insert':
            $Title = $_REQUEST['Title'];
            $Name = trim($_REQUEST['Name']);
            $Mobile = trim($_REQUEST['Mobile']);
            $License = trim($_REQUEST['License']);
            $SupplierId = $_REQUEST['SupplierId'];

            $query = "INSERT INTO drivers (
                Title,
                Name,
                Mobile,
                License,
                SupplierId
                ) VALUES(
                :Title,
                :Name,
                :Mobile,
                :License,
                :SupplierId
                )
            ;";
            $database->query($query);
            $database->bind(':Title', $Title);
            $database->bind(':Name', $Name);
            $database->bind(':Mobile', $Mobile);
            $database->bind(':License', $License);
            $database->bind('SupplierId', $SupplierId);
            if ($database->execute()) {
                header("location: drivers.php");
            }
            break;

        case 'select_all':
            $query = "SELECT
                drivers.Id,
                drivers.Title,
                drivers.Name,
                drivers.Mobile,
                drivers.License,
                drivers.Class,
                drivers.SupplierId,
                suppliers.Name AS suppliersName
                FROM drivers LEFT OUTER JOIN suppliers
                ON drivers.SupplierId = suppliers.Id
            ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'select_one':
            // $var1 = $driversId
            $query = "SELECT
                drivers.Id,
                drivers.Title,
                drivers.Name,
                drivers.Mobile,
                drivers.License,
                drivers.Class,
                drivers.SupplierId,
                suppliers.Name AS suppliersName
                FROM drivers LEFT OUTER JOIN suppliers
                ON drivers.SupplierId = suppliers.Id
                WHERE drivers.Id = :driversId
            ;";
            $database->query($query);
            $database->bind(':driversId', $var1);
            return $r = $database->resultset();
            break;

        case 'search':
            // $var1 = search
            $search = '%'.$var1.'%';
            $query = "SELECT
                drivers.Id,
                drivers.Title,
                drivers.Name,
                drivers.Mobile,
                drivers.License,
                drivers.Class,
                drivers.SupplierId,
                suppliers.Name AS suppliersName
                FROM drivers LEFT OUTER JOIN suppliers
                ON drivers.SupplierId = suppliers.Id
                WHERE CONCAT(
                drivers.Title,
                drivers.Name,
                drivers.Mobile,
                drivers.License,
                drivers.Class,
                suppliers.Name
                ) LIKE :search
            ;";
            $database->query($query);
            $database->bind(':search', $search);
            return $r = $database->resultset();
            break;

        case 'check_before_update':
            // $var1 = $driversId
            $Name = trim($_REQUEST['Name']);
            $Mobile = trim($_REQUEST['Mobile']);
            $License = trim($_REQUEST['License']);

            $query = "SELECT * FROM drivers
                WHERE Name = :Name
                AND Mobile = :Mobile
                AND License = :License
                AND Id != :driversId
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':Mobile', $Mobile);
            $database->bind(':License', $License);
            $database->bind(':driversId', $var1);
            return $r = $database->rowCount();
            break;

        case 'update':
            //$var1 = $driversId
            $Title = $_REQUEST['Title'];
            $Name = trim($_REQUEST['Name']);
            $Mobile = trim($_REQUEST['Mobile']);
            $License = trim($_REQUEST['License']);
            $Class = trim($_REQUEST['Class']);
            $SupplierId = $_REQUEST['SupplierId'];

            $query = "UPDATE drivers SET
                Title = :Title,
                Name = :Name,
                Mobile = :Mobile,
                License = :License,
                Class = :Class,
                SupplierId = :SupplierId
                WHERE Id = :driversId
            ;";
            $database->query($query);
            $database->bind(':Title', $Title);
            $database->bind(':Name', $Name);
            $database->bind(':Mobile', $Mobile);
            $database->bind(':License', $License);
            $database->bind(':Class', $Class);
            $database->bind(':SupplierId', $SupplierId);
            $database->bind(':driversId', $var1);
            if ($database->execute()) {
                header("location: edit_driver.php?driversId=$var1");
            }
            break;

        default:
            // code...
            break;
    }
}

//function to use the table service_types
function table_service_types ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {

        case 'check_before_insert':
            $Code = strtoupper($_REQUEST['Code']);
            $Name = trim($_REQUEST['Name']);

            $query = "SELECT Id FROM service_types WHERE Code = :Code ;";
            $database->query($query);
            $database->bind(':Code', $Code);
            return $r = $database->rowCount();
            break;

        case 'insert':
            $Code = strtoupper($_REQUEST['Code']);
            $Name = trim($_REQUEST['Name']);
            $query = "INSERT INTO service_types (
                Code,
                Name
                ) VALUES(
                :Code,
                :Name
                )
            ;";
            $database->query($query);
            $database->bind(':Code', $Code);
            $database->bind(':Name', $Name);
            if ($database->execute()) {
                header("location: service_types.php");
            }

            break;

        case 'select_all':
            $query = "SELECT * FROM service_types ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'select_one':
            // $var1 = $service_typesId
            $query = "SELECT * FROM service_types WHERE Id = :service_typesId ;";
            $database->query($query);
            $database->bind(':service_typesId', $var1);
            return $r = $database->resultset();
            break;

        case 'check_before_update':
            // $var1 = $service_typesId
            $Code = strtoupper($_REQUEST['Code']);
            $query = "SELECT * FROM service_types
                WHERE Code = :Code
                AND Id != :service_typesId
            ;";
            $database->query($query);
            $database->bind(':Code', $Code);
            $database->bind(':service_typesId', $var1);
            return $r = $database->rowCount();
            break;

        case 'update':
            // $var1 = $service_typesId
            $Code = strtoupper($_REQUEST['Code']);
            $Name = trim($_REQUEST['Name']);

            $query = "UPDATE service_types SET
                Code = :Code,
                Name = :Name
                WHERE Id = :service_typesId
            ;";
            $database->query($query);
            $database->bind(':Code', $Code);
            $database->bind(':Name', $Name);
            $database->bind(':service_typesId', $var1);
            if ($database->execute()) {
                header("location: edit_service_type.php?service_typesId=$var1");
            }
            break;

        default:
            // code...
            break;
    }
}

//function to use the table service_statuses
function table_service_statuses ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {

        case 'check_before_insert':
            $Code = strtoupper($_REQUEST['Code']);
            $Description = trim($_REQUEST['Description']);

            $query = "SELECT Id FROM service_statuses WHERE Code = :Code ;";
            $database->query($query);
            $database->bind(':Code', $Code);
            return $r = $database->rowCount();
            break;

        case 'insert':
            $Code = strtoupper($_REQUEST['Code']);
            $Description = trim($_REQUEST['Description']);

            $query = "INSERT INTO service_statuses (
                Code,
                Description
                ) VALUES(
                :Code,
                :Description
                )
            ;";
            $database->query($query);
            $database->bind(':Code', $Code);
            $database->bind(':Description', $Description);
            if ($database->execute()) {
                header("location: service_statuses.php");
            }

            break;

        case 'select_all':
            $query = "SELECT * FROM service_statuses ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'select_one':
            // $var1 = service_statusesId
            $query = "SELECT * FROM service_statuses WHERE Id = :service_statusesId ;";
            $database->query($query);
            $database->bind(':service_statusesId', $var1);
            return $r = $database->resultset();
            break;

        case 'check_before_update':
            // $var1 = service_statusesId
            $Code = strtoupper($_REQUEST['Code']);

            $query = "SELECT * FROM service_statuses
                WHERE Code = :Code
                AND Id != :service_statusesId
            ;";
            $database->query($query);
            $database->bind(':Code', $Code);
            $database->bind(':service_statusesId', $var1);
            return $r = $database->rowCount();
            break;

        case 'update':
                // $var1 = service_statusesId
                $Code = strtoupper($_REQUEST['Code']);
                $Description = trim($_REQUEST['Description']);

                $query = "UPDATE service_statuses SET
                    Code = :Code,
                    Description = :Description
                    WHERE Id = :service_statusesId
                ;";
                $database->query($query);
                $database->bind(':Code', $Code);
                $database->bind(':Description', $Description);
                $database->bind(':service_statusesId', $var1);
                if ($database->execute()) {
                    header("location: edit_service_statuses.php?service_statusesId=$var1");
                }
            break;

        default:
            # code...
            break;
    }
}

// function to use the table services
function table_services ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {

        case 'check_before_insert':
            $SupplierId = $_REQUEST['SupplierId'];
            $Service_TypeId = $_REQUEST['Service_TypeId'];
            $Service = trim($_REQUEST['Service']);
            $Additional = trim($_REQUEST['Additional']);

            $query = "SELECT Id FROM services WHERE
                SupplierId = :SupplierId AND
                Service_TypeId = :Service_TypeId AND
                Service = :Service AND
                Additional = :Additional
            ;";
            $database->query($query);
            $database->bind(':SupplierId', $SupplierId);
            $database->bind(':Service_TypeId', $Service_TypeId);
            $database->bind(':Service', $Service);
            $database->bind(':Additional', $Additional);
            return $r = $database->rowCount();
            break;

        case 'insert':
            $SupplierId = $_REQUEST['SupplierId'];
            $Service_TypeId = $_REQUEST['Service_TypeId'];
            $Service = trim($_REQUEST['Service']);
            $Additional = trim($_REQUEST['Additional']);
            $Remark = trim($_REQUEST['Remark']);
            $Status = $_REQUEST['Status'];

            $query = "INSERT INTO services (
                SupplierId,
                Service_TypeId,
                Service,
                Additional,
                Remark,
                Status
                ) VALUES(
                :SupplierId,
                :Service_TypeId,
                :Service,
                :Additional,
                :Remark,
                :Status
                )
            ;";
            $database->query($query);
            $database->bind(':SupplierId', $SupplierId);
            $database->bind(':Service_TypeId', $Service_TypeId);
            $database->bind(':Service', $Service);
            $database->bind(':Additional', $Additional);
            $database->bind(':Remark', $Remark);
            $database->bind(':Status', $Status);
            if ($database->execute()) {
                header("location: services.php");
            }
            break;

        case 'select_all':
            $query = "SELECT
                services.Id,
                services.SupplierId,
                suppliers.Name,
                services.Service_TypeId,
                service_types.Code,
                service_types.Name AS service_typesName,
                services.Service,
                services.Additional,
                services.Remark,
                services.Status
                FROM services LEFT JOIN suppliers
                ON services.SupplierId = suppliers.Id
                LEFT JOIN service_types
                ON services.Service_TypeId = service_types.Id
            ;";
            $database->query($query);
            return $database->resultset();
            break;

        case 'select_one':
            // $var1 = $servicesId
            $query = "SELECT
                services.Id,
                services.SupplierId,
                suppliers.Name,
                services.Service_TypeId,
                service_types.Code,
                service_types.Name AS service_typesName,
                services.Service,
                services.Additional,
                services.Remark,
                services.Status
                FROM services LEFT JOIN suppliers
                ON services.SupplierId = suppliers.Id
                LEFT JOIN service_types
                ON services.Service_TypeId = service_types.Id
                WHERE services.Id = :servicesId
            ;";
            $database->query($query);
            $database->bind(':servicesId', $var1);
            return $r = $database->resultset();
            break;

        case 'search':
            //$var1 = $servicesId
            $search = '%'.$var1.'%';
            $query = "SELECT
                services.Id,
                services.SupplierId,
                suppliers.Name,
                services.Service_TypeId,
                service_types.Code,
                services.Service,
                services.Additional,
                services.Remark,
                services.Status
                FROM services LEFT JOIN suppliers
                ON services.SupplierId = suppliers.Id
                LEFT JOIN service_types
                ON services.Service_TypeId = service_types.Id WHERE
                CONCAT (
                suppliers.Name,
                service_types.Code,
                services.service,
                services.Additional,
                services.Remark,
                services.Status
                ) LIKE :search
            ;";
            $database->query($query);
            $database->bind(':search', $search);
            return $r = $database->resultset();
            break;

        case 'check_before_update':
            // $var1 = $servicesId
            $SupplierId = $_REQUEST['SupplierId'];
            $Service = trim($_REQUEST['Service']);
            $Additional = trim($_REQUEST['Additional']);
            $query = "SELECT * FROM services
                WHERE SupplierId = :SupplierId
                AND Service = :Service
                AND Additional = :Additional
                AND Id != :servicesId
            ;";
            $database->query($query);
            $database->bind(':SupplierId', $SupplierId);
            $database->bind(':Service', $Service);
            $database->bind(':Additional', $Additional);
            $database->bind(':servicesId', $var1);
            return $r = $database->rowCount();
            break;

        case 'update':
            // $var1 = $servicesId
            $SupplierId = $_REQUEST['SupplierId'];
            $Service = trim($_REQUEST['Service']);
            $Additional = trim($_REQUEST['Additional']);
            $Remark = trim($_REQUEST['Remark']);
            $Status = trim($_REQUEST['Status']);

            $query = "UPDATE services SET
                SupplierId = :SupplierId,
                Service = :Service,
                Additional = :Additional,
                Remark = :Remark,
                Status = :Status
                WHERE Id = :servicesId
            ;";
            $database->query($query);
            $database->bind(':SupplierId', $SupplierId);
            $database->bind(':Service', $Service);
            $database->bind(':Additional', $Additional);
            $database->bind(':Remark', $Remark);
            $database->bind(':Status', $Status);
            $database->bind(':servicesId', $var1);
            if ($database->execute()) {
                header("location: edit_service.php?servicesId=$var1");
            }
            break;

        default:
            // code...
            break;
    }
}

//function to use the table guide_requests
function table_guide_requests ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {

        case 'check_before_insert':
            $Request = trim($_REQUEST['Request']);
            $query = "SELECT Id FROM guide_requests WHERE Request = :Request ;";
            $database->query($query);
            $database->bind(':Request', $Request);
            return $r = $database->rowCount();
            break;

        case 'insert':
            $Request = trim($_REQUEST['Request']);
            $query = "INSERT INTO guide_requests (
                Request
                ) VALUES(
                :Request
                )
            ;";
            $database->query($query);
            $database->bind(':Request', $Request);
            if ($database->execute()) {
                header("location: guide_requests.php");
            }
            break;

        case 'select_all':
            $query = "SELECT * FROM guide_requests ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'select_one':
            // $var1 = $guide_requestsId
            $query = "SELECT * FROM guide_requests
                WHERE Id = :guide_requestsId
            ;";
            $database->query($query);
            $database->bind(':guide_requestsId', $var1);
            return $r = $database->resultset();
            break;

        case 'check_before_update':
            // $var1 = $guide_requestsId
            $Request = trim($_REQUEST['Request']);
            $query = "SELECT * FROM guide_requests
                WHERE Request = :Request
                AND Id != :guide_requestsId
            ;";
            $database->query($query);
            $database->bind(':Request', $Request);
            $database->bind(':guide_requestsId', $var1);
            return $r = $database->rowCount();
            break;

        case 'update':
            // $var1 = $guide_requestsId
            $Request = trim($_REQUEST['Request']);
            $query = "UPDATE guide_requests SET
                Request = :Request
                WHERE Id = :guide_requestsId
            ;";
            $database->query($query);
            $database->bind(':Request', $Request);
            $database->bind(':guide_requestsId', $var1);
             if ($database->execute()) {
                header("location: edit_guide_request.php?guide_requestsId=$var1");
             }
            break;

        default:
            // code...
            break;
    }
}

// function to use the table booking_statuses
function table_booking_statuses ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'check_before_insert':
                $Status = trim($_REQUEST['Status']);
                $query = "SELECT Id FROM booking_statuses WHERE Status = :Status ;";
                $database->query($query);
                $database->bind(':Status', $Status);
                return $r = $database->rowCount();
                break;

        case 'insert':
            $Status = trim($_REQUEST['Status']);

            $query = "INSERT INTO booking_statuses (
                Status
                ) VALUES (
                :Status
                )
            ;";
            $database->query($query);
            $database->bind(':Status', $Status);
            $database->execute();
            break;

        case 'select_all':
            $query = "SELECT * FROM booking_statuses ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'select_one':
            // $var1 = $booking_statusesId
            $query = "SELECT * FROM booking_statuses
                WHERE Id = :booking_statusesId
            ;";
            $database->query($query);
            $database->bind(':booking_statusesId', $var1);
            return $r = $database->resultset();
            break;

        case 'check_before_update':
            // $var1 = $booking_statusesId
            $Status = trim($_REQUEST['Status']);
            $query = "SELECT * FROM booking_statuses
                WHERE Status = :Status
                AND Id != :booking_statusesId
            ;";
            $database->query($query);
            $database->bind(':Status', $Status);
            $database->bind(':booking_statusesId', $var1);
            return $r = $database->rowCount();
            break;

        case 'update':
            $Status = trim($_REQUEST['Status']);
            $query = "UPDATE booking_statuses SET
                Status = :Status
                WHERE Id = :booking_statusesId
            ;";
            $database->query($query);
            $database->bind(':Status', $Status);
            $database->bind(':booking_statusesId', $booking_statusesId);
            if ($database->execute()) {
                header("location: edit_booking_status.php?booking_statusesId=$var1");
            }
            break;

        default:
            # code...
            break;
    }
}

// function to use table bookings
function table_bookings ($job, $var1, $var2) {
    $database = new Database();
    // Getting the departmentsId
    $rows_users = table_users('select_one', $_SESSION['usersId'], NULL);
    foreach ($rows_users as $row_users) {
        $DepartmentId = $row_users->DepartmentId;
    }

    switch ($job) {

        case 'check_before_insert':
            $Reference = trim($_REQUEST['Reference']);
            $Name = trim($_REQUEST['Name']);
            $AgentId = $_REQUEST['AgentId'];
            $Arrival_Date = $_REQUEST['Arrival_Date'];

            $query = "SELECT Id FROM bookings WHERE
                Reference = :Reference AND
                Name = :Name AND
                AgentId = :AgentId AND
                Arrival_Date = :Arrival_Date
            ;";
            $database->query($query);
            $database->bind(':Reference', $Reference);
            $database->bind(':Name', $Name);
            $database->bind(':AgentId', $AgentId);
            $database->bind(':Arrival_Date', $Arrival_Date);
            return $r = $database->rowCount();
            break;

        case 'insert':
            $Reference = trim($_REQUEST['Reference']);
            $Name = trim($_REQUEST['Name']);
            $Pax = $_REQUEST['Pax'];
            $AgentId = $_REQUEST['AgentId'];
            $Guide_RequestId = $_REQUEST['Guide_RequestId'];
            $Tour_GuideId = $_REQUEST['Tour_GuideId'];
            $Arrival_Date = $_REQUEST['Arrival_Date'];
            $Remark = trim($_REQUEST['Remark']);
            $StatusId = $_REQUEST['StatusId'];

            $query = "INSERT INTO bookings (
                Reference,
                Name,
                Pax,
                AgentId,
                Guide_RequestId,
                Tour_GuideId,
                Arrival_Date,
                Remark,
                StatusId,
                UserId
                ) VALUES(
                :Reference,
                :Name,
                :Pax,
                :AgentId,
                :Guide_RequestId,
                :Tour_GuideId,
                :Arrival_Date,
                :Remark,
                :StatusId,
                :UserId
                )
            ;";
            $database->query($query);
            $database->bind(':Reference', $Reference);
            $database->bind(':Name', $Name);
            $database->bind(':Pax', $Pax);
            $database->bind(':AgentId', $AgentId);
            $database->bind(':Guide_RequestId', $Guide_RequestId);
            $database->bind(':Tour_GuideId', $Tour_GuideId);
            $database->bind(':Arrival_Date', $Arrival_Date);
            $database->bind(':Remark', $Remark);
            $database->bind(':StatusId', $StatusId);
            $database->bind(':UserId', $_SESSION['usersId']);
            if ($database->execute()) {
                header("location: bookings.php");
            }
            break;

        case 'select_all':
            $query = "SELECT
                bookings.Id AS bookingsId,
                bookings.Reference AS Reference,
                bookings.Name AS bookingsName,
                bookings.Pax AS bookingsPax,
                bookings.AgentId AS AgentId,
                agents.Name AS agentsName,
                bookings.Guide_RequestId AS Guide_RequestId,
                guide_requests.Request AS guide_requestsRequest,
                bookings.Tour_GuideId AS Tour_GuideId,
                tour_guides.Title AS tour_guidesTitle,
                tour_guides.Name AS tour_guidesName,
                bookings.Arrival_Date AS Arrival_Date,
                bookings.Remark AS Remark,
                bookings.StatusId AS StatusId,
                booking_statuses.Status AS booking_statusesStatus,
                users.Fullname AS Fullname
                FROM bookings LEFT JOIN agents
                ON bookings.AgentId = agents.Id
                LEFT JOIN guide_requests
                ON bookings.Guide_RequestId = guide_requests.Id
                LEFT JOIN booking_statuses
                ON bookings.StatusId = booking_statuses.Id
                LEFT JOIN users
                ON bookings.UserId = users.Id
                LEFT JOIN tour_guides
                ON bookings.Tour_GuideId = tour_guides.Id ";

            switch ($DepartmentId) {
                case '5':
                    //Exo Travel Only!
                    $query .= "WHERE agents.Name = 'Exo Travel';";
                    break;
                case '6':
                    // Tour Mandalay Only!
                    $query .= " WHERE agents.Name = 'Tour Mandalay';";
                    break;

                case '7':
                    // All except Exo Travel and Tour Mandalay
                    $query .= "WHERE agents.Name NOT IN ('Exo Travel', 'Tour Mandalay') ;";
                    break;

                default:
                    // All
                    $query .= ";";
                    break;
            }
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'select_one':
            //$var1 = $bookingsId
            $query = "SELECT
                bookings.Id AS bookingsId,
                bookings.Reference AS Reference,
                bookings.Name AS bookingsName,
                bookings.Pax AS bookingsPax,
                bookings.AgentId AS AgentId,
                agents.Name AS agentsName,
                bookings.Guide_RequestId AS Guide_RequestId,
                guide_requests.Request AS guide_requestsRequest,
                bookings.Tour_GuideId AS Tour_GuideId,
                tour_guides.Title AS tour_guidesTitle,
                tour_guides.Name AS tour_guidesName,
                bookings.Arrival_Date AS Arrival_Date,
                bookings.Remark AS Remark,
                bookings.StatusId AS StatusId,
                booking_statuses.Status AS booking_statusesStatus,
                users.Fullname AS Fullname
                FROM bookings LEFT JOIN agents
                ON bookings.AgentId = agents.Id
                LEFT JOIN guide_requests
                ON bookings.Guide_RequestId = guide_requests.Id
                LEFT JOIN booking_statuses
                ON bookings.StatusId = booking_statuses.Id
                LEFT JOIN users
                ON bookings.UserId = users.Id
                LEFT JOIN tour_guides
                ON bookings.Tour_GuideId = tour_guides.Id ";

            switch ($DepartmentId) {
                case '5':
                    // Exo travel only
                    $query .= "WHERE agents.Name = 'Exo Travel' AND bookings.Id = :bookingsId ;";
                    break;

                case '6':
                    // Tour Mandalay Only
                    $query .= "WHERE agents.Name = 'Tour Mandalay' AND bookings.Id = :bookingsId ;";
                    break;

                case '7':
                    // All except Exo and Tour Mandalay
                    $query .= "WHERE agents.Name NOT IN ('Exo Travel', 'Tour Mandalay') AND bookings.Id = :bookingsId ;";
                    break;

                default:
                    // All
                    $query .= "WHERE bookings.Id = :bookingsId ;";
                    break;
            }
            $database->query($query);
            $database->bind(':bookingsId', $var1);
            return $r = $database->resultset();
            break;

        case 'search':
            // $var1 = search
            $search = '%'.$var1.'%';
            $query = "SELECT
                bookings.Id AS bookingsId,
                bookings.Reference AS Reference,
                bookings.Name AS bookingsName,
                bookings.Pax AS bookingsPax,
                bookings.AgentId AS AgentId,
                agents.Name AS agentsName,
                bookings.Guide_RequestId AS Guide_RequestId,
                guide_requests.Request AS guide_requestsRequest,
                bookings.Tour_GuideId AS Tour_GuideId,
                tour_guides.Title AS tour_guidesTitle,
                tour_guides.Name AS tour_guidesName,
                bookings.Arrival_Date AS Arrival_Date,
                bookings.Remark AS Remark,
                bookings.StatusId AS StatusId,
                booking_statuses.Status AS booking_statusesStatus,
                users.Fullname AS Fullname
                FROM bookings LEFT JOIN agents
                ON bookings.AgentId = agents.Id
                LEFT JOIN guide_requests
                ON bookings.Guide_RequestId = guide_requests.Id
                LEFT JOIN booking_statuses
                ON bookings.StatusId = booking_statuses.Id
                LEFT JOIN users
                ON bookings.UserId = users.Id
                LEFT JOIN tour_guides
                ON bookings.Tour_GuideId = tour_guides.Id ";

            switch ($DepartmentId) {
                case '5':
                    // Exo only
                    $query .= "WHERE agents.Name = 'Exo Travel'
                        AND CONCAT (
                        bookings.Reference,
                        bookings.Name,
                        agents.Name,
                        guide_requests.Request,
                        bookings.Remark,
                        booking_statuses.Status,
                        users.Fullname
                        ) LIKE :search ;";
                    break;

                case '6':
                    // Tour Mandalay only
                    $query .= "WHERE agents.Name = 'Tour Mandalay'
                        AND CONCAT (
                        bookings.Reference,
                        bookings.Name,
                        agents.Name,
                        guide_requests.Request,
                        bookings.Remark,
                        booking_statuses.Status,
                        users.Fullname
                        ) LIKE :search ;";
                    break;

                case '7':
                    // All except Exo and Tour Mandalay
                    $query .= "WHERE agents.Name NOT IN ('Exo Travel', 'Tour Mandalay')
                        AND CONCAT (
                        bookings.Reference,
                        bookings.Name,
                        agents.Name,
                        guide_requests.Request,
                        bookings.Remark,
                        booking_statuses.Status,
                        users.Fullname
                        ) LIKE :search ;";
                    break;

                default:
                    // all
                    $query .= "WHERE CONCAT (
                        bookings.Reference,
                        bookings.Name,
                        agents.Name,
                        guide_requests.Request,
                        bookings.Remark,
                        booking_statuses.Status,
                        users.Fullname
                        ) LIKE :search ;";
                    break;
            }
            $database->query($query);
            $database->bind(':search', $search);
            return $r = $database->resultset();
            break;

        case 'check_before_update':
            // $var1 = $bookingsId
            $Reference = trim($_REQUEST['Reference']);
            $query = "SELECT * FROM ";
            break;

        case 'update':
            // $var1 = $bookingsId
            $Reference = trim($_REQUEST['Reference']);
            $Name = trim($_REQUEST['Name']);
            $Pax = $_REQUEST['Pax'];
            $AgentId = $_REQUEST['AgentId'];
            $Guide_RequestId = $_REQUEST['Guide_RequestId'];
            $Tour_GuideId = $_REQUEST['Tour_GuideId'];
            $Arrival_Date = $_REQUEST['Arrival_Date'];
            $Remark = trim($_REQUEST['Remark']);
            $StatusId = $_REQUEST['StatusId'];

            $query = "UPDATE bookings SET
                Reference = :Reference,
                Name = :Name,
                Pax = :Pax,
                AgentId = :AgentId,
                Guide_RequestId = :Guide_RequestId,
                Tour_GuideId = :Tour_GuideId,
                Arrival_Date = :Arrival_Date,
                Remark = :Remark,
                StatusId = :StatusId,
                UserId = :UserId
                WHERE Id = :bookingsId
            ;";
            $database->query($query);
            $database->bind(':Reference', $Reference);
            $database->bind(':Name', $Name);
            $database->bind(':Pax', $Pax);
            $database->bind(':AgentId', $AgentId);
            $database->bind(':Guide_RequestId', $Guide_RequestId);
            $database->bind(':Tour_GuideId', $Tour_GuideId);
            $database->bind(':Arrival_Date', $Arrival_Date);
            $database->bind(':Remark', $Remark);
            $database->bind(':StatusId', $StatusId);
            $database->bind(':UserId', $_SESSION['usersId']);
            $database->bind(':bookingsId', $bookingsId);
            if ($database->execute()) {
                header("location: edit_booking.php?bookingsId=$var1");
            }
            break;

        default:
            // code...
            break;
    }
}

//function to filter search services to be added in services_booking
function search_services ($Service_TypeId) {
    $database = new Database();
    $query = "SELECT
        services.Id,
        services.SupplierId,
        suppliers.Name AS suppliersName,
        services.Service_TypeId,
        service_types.Code,
        service_types.Name AS service_typesName,
        services.Service,
        services.Additional,
        services.Remark,
        services.Status
        FROM services LEFT JOIN suppliers
        ON services.SupplierId = suppliers.Id
        LEFT JOIN service_types
        ON services.Service_TypeId = service_types.Id
        WHERE services.Service_TypeId = :Service_TypeId
    ;";
    $database->query($query);
    $database->bind(':Service_TypeId', $Service_TypeId);
    return $r = $database->resultset();
}

//function to insert data to the table services_booking
function table_services_booking ($job, $var1, $var2) {
    $database = new Database();
    $UserId = $_SESSION['usersId'];

    switch ($job) {
        case 'check_before_insert':
            $servicesId = $_REQUEST['servicesId'];
            $Service_Date = $_REQUEST['Service_Date'];
            $query = "SELECT * FROM services_booking
                WHERE BookingsId = :BookingsId
                AND ServiceId = :servicesId
                AND Service_Date = :Service_Date
            ;";
            $database->query($query);
            $database->bind(':BookingsId', $bookingsId);
            $database->bind(':servicesId', $servicesId);
            $database->bind(':Service_Date', $Service_Date);
            return $r = $database->rowCount();
            break;

        case 'insert':
            $servicesId = $_REQUEST['servicesId'];
            $Service_Date = $_REQUEST['Service_Date'];
            $query = "INSERT INTO services_booking (
                BookingsId,
                ServiceId,
                Service_Date,
                UserId
                ) VALUES(
                :BookingsId,
                :ServiceId,
                :Service_Date,
                :UserId
                )
            ;";
            $database->query($query);
            $database->bind(':BookingsId', $var1);
            $database->bind(':ServiceId', $servicesId);
            $database->bind(':Service_Date', $Service_Date);
            $database->bind(':UserId', $UserId);
            if ($database->execute()) {
                header("location:booking_summary.php?bookingsId=$var1");
            }
            break;

        case 'select_for_one_booking':
            // $var1 = $bookingsId
            $query = "SELECT
                services_booking.Id,
                services_booking.ServiceId,
                services.Service_TypeId,
                services_booking.Service_Date,
                services_booking.Pickup,
                services_booking.Pickup_Time,
                services_booking.Dropoff,
                services_booking.Dropoff_Time,
                services_booking.VehicleId,
                services_booking.DriverId,
                services_booking.Tour_GuideId,
                services_booking.Special_RQ,
                services_booking.Remark AS services_bookingRemark,
                services_booking.StatusId,
                services_booking.UserId,
                bookings.Reference AS Reference,
                bookings.Name AS bookingsName,
                bookings.Pax AS Pax,
                bookings.AgentId AS AgentId,
                agents.Name AS agentsName,
                service_types.Code AS service_typesCode,
                services.Service,
                services.Additional,
                services.Remark,
                suppliers.Name AS suppliersName,
                suppliers.Address,
                suppliers.City,
                suppliers.Phone,
                suppliers.Email,
                vehicles.License AS vehiclesLicense,
                vehicles.Type AS vehiclesType,
                vehicles.Seats AS vehicleSeat,
                drivers.Title AS driversTitle,
                drivers.Name AS driversName,
                drivers.Mobile AS driversMobile,
                drivers.License AS driversLicense,
                drivers.Class AS driversClass,
                tour_guides.Id AS tour_guidesId,
                tour_guides.Title AS tour_guidesTitle,
                tour_guides.Name AS tour_guidesName,
                tour_guides.Mobile AS tour_guidesMobile,
                tour_guides.Language AS tour_guidesLanguage,
                tour_guides.Email AS tour_guidesEmail,
                service_statuses.Code AS service_statusesCode
                FROM services_booking
                LEFT OUTER JOIN bookings
                ON services_booking.BookingsId = bookings.Id
                LEFT OUTER JOIN agents
                ON bookings.AgentId = agents.Id
                LEFT OUTER JOIN services
                ON services_booking.ServiceId = services.Id
                LEFT OUTER JOIN service_types
                ON services.Service_TypeId = service_types.Id
                LEFT OUTER JOIN suppliers
                ON services.SupplierId = suppliers.Id
                LEFT OUTER JOIN vehicles
                ON services_booking.VehicleId = vehicles.Id
                LEFT OUTER JOIN drivers
                ON services_booking.DriverId = drivers.Id
                LEFT OUTER JOIN tour_guides
                ON services_booking.Tour_GuideId = tour_guides.Id
                LEFT OUTER JOIN service_statuses
                ON services_booking.StatusId = service_statuses.Id
                WHERE bookings.Id = :bookingsId
                AND services_booking.Visible = TRUE
            ;";
            $database->query($query);
            $database->bind('bookingsId', $var1);
            return $r = $database->resultset();
            break;

        case 'select_one':
            $query = "SELECT
                services_booking.Id,
                services_booking.BookingsId,
                services_booking.ServiceId,
                services.Service_TypeId,
                services_booking.Service_Date,
                services_booking.Pickup,
                services_booking.Pickup_Time,
                services_booking.Dropoff,
                services_booking.Dropoff_Time,
                services_booking.VehicleId,
                services_booking.DriverId,
                services_booking.Tour_GuideId,
                services_booking.Special_RQ,
                services_booking.Remark AS services_bookingRemark,
                services_booking.StatusId,
                services_booking.UserId,
                bookings.Reference AS Reference,
                bookings.Name AS bookingsName,
                bookings.Pax AS Pax,
                bookings.AgentId AS AgentId,
                agents.Name AS agentsName,
                service_types.Code AS service_typesCode,
                services.Service,
                services.Additional,
                services.Remark,
                suppliers.Name AS suppliersName,
                suppliers.Address,
                suppliers.City,
                suppliers.Phone,
                suppliers.Email,
                vehicles.License AS vehiclesLicense,
                vehicles.Type AS vehiclesType,
                vehicles.Seats AS vehicleSeat,
                drivers.Title AS driversTitle,
                drivers.Name AS driversName,
                drivers.Mobile AS driversMobile,
                drivers.License AS driversLicense,
                drivers.Class AS driversClass,
                tour_guides.Id AS tour_guidesId,
                tour_guides.Title AS tour_guidesTitle,
                tour_guides.Name AS tour_guidesName,
                tour_guides.Mobile AS tour_guidesMobile,
                tour_guides.Language AS tour_guidesLanguage,
                tour_guides.Email AS tour_guidesEmail,
                service_statuses.Code AS service_statusesCode
                FROM services_booking
                LEFT OUTER JOIN bookings
                ON services_booking.BookingsId = bookings.Id
                LEFT OUTER JOIN agents
                ON bookings.AgentId = agents.Id
                LEFT OUTER JOIN services
                ON services_booking.ServiceId = services.Id
                LEFT OUTER JOIN service_types
                ON services.Service_TypeId = service_types.Id
                LEFT OUTER JOIN suppliers
                ON services.SupplierId = suppliers.Id
                LEFT OUTER JOIN vehicles
                ON services_booking.VehicleId = vehicles.Id
                LEFT OUTER JOIN drivers
                ON services_booking.DriverId = drivers.Id
                LEFT OUTER JOIN tour_guides
                ON services_booking.Tour_GuideId = tour_guides.Id
                LEFT OUTER JOIN service_statuses
                ON services_booking.StatusId = service_statuses.Id
                WHERE services_booking.Id = :Id
            ;";
            $database->query($query);
            $database->bind(':Id', $var1);
            return $r = $database->resultset();
            break;

        case 'update':
            // $var1 = $services_bookingId
            $Service_Date = $_REQUEST['Service_Date'];
            $Pickup = trim($_REQUEST['Pickup']);
            $Pickup_Time = $_REQUEST['Pickup_Time'];
            $Dropoff = trim($_REQUEST['Dropoff']);
            $Dropoff_Time = $_REQUEST['Dropoff_Time'];
            $Tour_GuideId = $_REQUEST['Tour_GuideId'];
            $VehicleId = $_REQUEST['VehicleId'];
            $DriverId = $_REQUEST['DriverId'];
            $Remark = trim($_REQUEST['Remark']);
            $StatusId = $_REQUEST['StatusId'];

            $query = "UPDATE services_booking SET
                Service_Date = :Service_Date,
                Pickup = :Pickup,
                Pickup_Time = :Pickup_Time,
                Dropoff = :Dropoff,
                Dropoff_Time = :Dropoff_Time,
                Tour_GuideId = :Tour_GuideId,
                VehicleId = :VehicleId,
                DriverId = :DriverId,
                StatusId = :StatusId,
                Remark = :Remark
                WHERE Id = :services_bookingId
            ;";
            $database->query($query);
            $database->bind(':Service_Date', $Service_Date);
            $database->bind(':Pickup', $Pickup);
            $database->bind(':Pickup_Time', $Pickup_Time);
            $database->bind(':Dropoff', $Dropoff);
            $database->bind(':Dropoff_Time', $Dropoff_Time);
            $database->bind(':Tour_GuideId', $Tour_GuideId);
            $database->bind(':VehicleId', $VehicleId);
            $database->bind(':DriverId', $DriverId);
            $database->bind(':StatusId', $StatusId);
            $database->bind(':Remark', $Remark);
            $database->bind(':services_bookingId', $var1);
            if ($database->execute()) {
                header("location: edit_services_booking.php?services_bookingId=$var1");
            }
            break;

        case 'guide_job':
            $query = "SELECT
                services_booking.Id,
                services_booking.ServiceId,
                services.Service_TypeId,
                services_booking.Service_Date,
                services_booking.Pickup,
                services_booking.Pickup_Time,
                services_booking.Dropoff,
                services_booking.Dropoff_Time,
                services_booking.VehicleId,
                services_booking.DriverId,
                services_booking.Tour_GuideId,
                services_booking.Special_RQ,
                services_booking.Remark AS services_bookingRemark,
                services_booking.StatusId,
                services_booking.UserId,
                bookings.Reference AS Reference,
                bookings.Name AS bookingsName,
                bookings.Pax AS Pax,
                bookings.AgentId AS AgentId,
                agents.Name AS agentsName,
                service_types.Code AS service_typesCode,
                services.Service,
                services.Additional,
                services.Remark,
                suppliers.Name AS suppliersName,
                suppliers.Address,
                suppliers.City,
                suppliers.Phone,
                suppliers.Email,
                vehicles.License AS vehiclesLicense,
                vehicles.Type AS vehiclesType,
                vehicles.Seats AS vehicleSeat,
                drivers.Title AS driversTitle,
                drivers.Name AS driversName,
                drivers.Mobile AS driversMobile,
                drivers.License AS driversLicense,
                drivers.Class AS driversClass,
                tour_guides.Title AS tour_guidesTitle,
                tour_guides.Name AS tour_guidesName,
                tour_guides.Mobile AS tour_guidesMobile,
                tour_guides.Language AS tour_guidesLanguage,
                tour_guides.Email AS tour_guidesEmail,
                service_statuses.Code AS service_statusesCode
                FROM services_booking
                LEFT OUTER JOIN bookings
                ON services_booking.BookingsId = bookings.Id
                LEFT OUTER JOIN agents
                ON bookings.AgentId = agents.Id
                LEFT OUTER JOIN services
                ON services_booking.ServiceId = services.Id
                LEFT OUTER JOIN service_types
                ON services.Service_TypeId = service_types.Id
                LEFT OUTER JOIN suppliers
                ON services.SupplierId = suppliers.Id
                LEFT OUTER JOIN vehicles
                ON services_booking.VehicleId = vehicles.Id
                LEFT OUTER JOIN drivers
                ON services_booking.DriverId = drivers.Id
                LEFT OUTER JOIN tour_guides
                ON services_booking.Tour_GuideId = tour_guides.Id
                LEFT OUTER JOIN service_statuses
                ON services_booking.StatusId = service_statuses.Id
                WHERE bookings.Id = :bookingsId
                AND service_types.Id = '4'
                AND services_booking.Visible = TRUE
            ";
            $database->query($query);
            $database->bind(':bookingsId', $var1);
            return $r = $database->resultset();
            break;

            case 'driver_job':
                //$var1 = $bookingsId
                $query = "SELECT
                    services_booking.Id,
                    services_booking.ServiceId,
                    services.Service_TypeId,
                    services_booking.Service_Date,
                    services_booking.Pickup,
                    services_booking.Pickup_Time,
                    services_booking.Dropoff,
                    services_booking.Dropoff_Time,
                    services_booking.VehicleId,
                    services_booking.DriverId,
                    services_booking.Tour_GuideId,
                    services_booking.Special_RQ,
                    services_booking.Remark AS services_bookingRemark,
                    services_booking.StatusId,
                    services_booking.UserId,
                    bookings.Reference AS Reference,
                    bookings.Name AS bookingsName,
                    bookings.Pax AS Pax,
                    bookings.AgentId AS AgentId,
                    agents.Name AS agentsName,
                    service_types.Code AS service_typesCode,
                    services.Service,
                    services.Additional,
                    services.Remark,
                    suppliers.Name AS suppliersName,
                    suppliers.Address,
                    suppliers.City,
                    suppliers.Phone,
                    suppliers.Email,
                    vehicles.License AS vehiclesLicense,
                    vehicles.Type AS vehiclesType,
                    vehicles.Seats AS vehicleSeat,
                    drivers.Title AS driversTitle,
                    drivers.Name AS driversName,
                    drivers.Mobile AS driversMobile,
                    drivers.License AS driversLicense,
                    drivers.Class AS driversClass,
                    tour_guides.Title AS tour_guidesTitle,
                    tour_guides.Name AS tour_guidesName,
                    tour_guides.Mobile AS tour_guidesMobile,
                    tour_guides.Language AS tour_guidesLanguage,
                    tour_guides.Email AS tour_guidesEmail,
                    service_statuses.Code AS service_statusesCode
                    FROM services_booking
                    LEFT OUTER JOIN bookings
                    ON services_booking.BookingsId = bookings.Id
                    LEFT OUTER JOIN agents
                    ON bookings.AgentId = agents.Id
                    LEFT OUTER JOIN services
                    ON services_booking.ServiceId = services.Id
                    LEFT OUTER JOIN service_types
                    ON services.Service_TypeId = service_types.Id
                    LEFT OUTER JOIN suppliers
                    ON services.SupplierId = suppliers.Id
                    LEFT OUTER JOIN vehicles
                    ON services_booking.VehicleId = vehicles.Id
                    LEFT OUTER JOIN drivers
                    ON services_booking.DriverId = drivers.Id
                    LEFT OUTER JOIN tour_guides
                    ON services_booking.Tour_GuideId = tour_guides.Id
                    LEFT OUTER JOIN service_statuses
                    ON services_booking.StatusId = service_statuses.Id
                    WHERE bookings.Id = :bookingsId
                    AND service_types.Id = '1'
                    AND services_booking.Visible = TRUE
                ";
                $database->query($query);
                $database->bind(':bookingsId', $var1);
                return $r = $database->resultset();
                break;

        default:
            // code...
            break;
    }
}

//function to generate vouchers
function generate_voucher ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'guide_voucher':
            $tour_guidesId = $_REQUEST['tour_guidesId'];
            $Service_Date1 = $_REQUEST['Service_Date1'];
            $Service_Date2 = $_REQUEST['Service_Date2'];
            if ($Service_Date2 == NULL) {
                $Service_Date2 = $Service_Date1;
            }
            $query = "SELECT
                services_booking.Service_Date,
                bookings.Reference,
                bookings.Name,
                services.Service
                FROM services_booking
            ;";
            break;

        default:
            // code...
            break;
    }

}

?>
