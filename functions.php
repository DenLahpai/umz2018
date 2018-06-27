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

//function to use the table users
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
    elseif ($job == 'check') {
        $Username = trim($_REQUEST['Username']);

        $query = "SELECT Id FROM users WHERE Username = :Username ;";
        $database->query($query);
        $database->bind(':Username', $Username);
        return $r = $database->rowCount();
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
        if ($database->execute()) {
            header("location:edit_user.php?Id=$Id");
        }
    }
}

//function to use the table posts
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

// function to get the table departments
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


//function to use the table agents
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

        $query = "SELECT Id FROM agents WHERE
            Name = :Name
        ;";
        $database->query($query);
        $database->bind(':Name', $Name);
        $database->execute();
        return $r = $database->rowCount();
    }
}

//function to use the table agent_contacts
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

//function to use the table tour_guides
function table_tour_guides($job, $tour_guidesId) {
    $database = new Database();

    switch ($job) {
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
        case 'select':
            if ($tour_guidesId == "" ||$tour_guidesId == NULL || empty($tour_guidesId)) {
                $query = "SELECT * FROM tour_guides ;";
                $database->query($query);
            }
            else {
                $query = "SELECT * FROM tour_guides WHERE Id = :Id ;";
                $database->query($query);
                $database->bind(':Id', $tour_guidesId);
            }
            return $r = $database->resultset();
            break;

        case 'search':
            $search = '%'.$tour_guidesId.'%';
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
            $database->bind(':tour_guidesId', $tour_guidesId);
            if ($database->execute()) {
                header("location: edit_tourguide.php?tour_guidesId=$tour_guidesId");
            }
            break;
        case 'check':
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
        default:
            // code...
            break;
    }
}

//function to use the table table_suppliers
function table_suppliers($job, $suppliersId) {
    $database = new Database();

    switch ($job) {
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
        case 'select':
            if ($suppliersId == NULL || $suppliersId == "" || empty($suppliersId)) {
                $query = "SELECT * FROM suppliers ;";
                $database->query($query);
            }
            else  {
                $query = "SELECT * FROM suppliers WHERE Id = :suppliersId ;";
                $database->query($query);
                $database->bind(':suppliersId', $suppliersId);
            }
            return $r = $database->resultset();
            break;
        case 'search':
            $search = '%'.$suppliersId.'%';
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
        case 'update':
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
            $database->bind(':suppliersId', $suppliersId);
            if ($database->execute()) {
                header("location: edit_supplier.php?suppliersId=$suppliersId");
            }
            break;
        case 'check':
            $Name = trim($_REQUEST['Name']);

            $query = "SELECT Id FROM suppliers WHERE
                Name = :Name
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            return $r = $database->rowCount();
            break;
        default:
            # code...
            break;
    }
}

//function to use data from the table supplier_contacts
function table_supplier_contacts($job, $supplier_contactsId) {
    $database = new Database();

    switch ($job) {
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
        case 'select':
            if ($supplier_contactsId == NULL || $supplier_contactsId == "" || empty($supplier_contactsId)) {
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
            }
            else {
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
                $database->bind(':supplier_contactsId', $supplier_contactsId);
            }
            return $r = $database->resultset();
            break;
        case 'search':
            $search = '%'.$supplier_contactsId.'%';

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

        case 'update':
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
            $database->bind(':supplier_contactsId', $supplier_contactsId);
            if ($database->execute()) {
                header("location: edit_supplier_contact.php?supplier_contactsId=$supplier_contactsId");
            }
            break;

        case 'check':
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

        default:
            // code...
            break;
    }
}

//function to use the table vehicle
function table_vehicles($job, $vehiclesId) {
    $database = new Database();

    switch ($job) {
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

        case 'select':
            if ($vehiclesId == NULL || $vehiclesId == "" || empty($vehiclesId)) {
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
                ;";
                $database->query($query);
            }
            else {
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
                    WHERE vehicles.Id = :vehiclesId
                ;";
                $database->query($query);
                $database->bind(':vehiclesId', $vehiclesId);
            }
            return $r = $database->resultset();
            break;

        case 'search':
            $search = '%'.$vehiclesId.'%';

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

        case 'update':
            $License = trim($_REQUEST['License']);
            $Type = trim($_REQUEST['Type']);
            $Seats = trim($_REQUEST['Seats']);
            $SupplierId = trim($_REQUEST['Supplierid']);

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
            $database->bind(':vehiclesId', $vehiclesId);
            if ($database->execute()) {
                header("location: edit_vehicle.php?vehiclesId=$vehiclesId");
            }
            break;

        case 'check':
            $License = trim($_REQUEST['License']);

            $query = "SELECT Id FROM vehicles WHERE License = :License ;";
            $database->query($query);
            $database->bind(':License', $License);
            return $r = $database->rowCount();
            break;

        default:
            // code...
            break;
    }
}

//function to use data from the table drivers
function table_drivers ($job, $driversId) {
    $database = new Database();

    switch ($job) {
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

        case 'select':
            if ($driversId == NULL || $driversId == "" ||empty($driversId)) {
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
            }
            else {
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
                $database->bind(':driversId', $driversId);
            }
            return $r = $database->resultset();
            break;

        case 'search':
            $search = '%'.$driversId.'%';
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

        case 'update':
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
            $database->bind(':driversId', $driversId);
            if ($database->execute()) {
                header("location: edit_driver.php?driversId=$driversId");
            }
            break;

        case 'check':
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

        default:
            // code...
            break;
    }
}

//function to use the table service_types
function table_service_types($job, $service_typesId) {
    $database = new Database();

    switch ($job) {

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

        case 'select':
            if ($service_typesId == NULL || $service_typesId == "" ||empty($service_typesId)) {
                $query = "SELECT * FROM service_types ;";
                $database->query($query);
            }
            else {
                $query = "SELECT * FROM service_types WHERE Id = :service_typesId ;";
                $database->query($query);
                $database->bind(':service_typesId', $service_typesId);
            }
            return $r = $database->resultset();
            break;

        case 'update':
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
            $database->bind(':service_typesId', $service_typesId);
            if ($database->execute()) {
                header("location: edit_service_type.php?service_typesId=$service_typesId");
            }
            break;

        case 'check':
            $Code = strtoupper($_REQUEST['Code']);
            $Name = trim($_REQUEST['Name']);

            $query = "SELECT Id FROM service_types WHERE Code = :Code ;";
            $database->query($query);
            $database->bind(':Code', $Code);
            return $r = $database->rowCount();
            break;

        default:
            // code...
            break;
    }
}

//function to use the table service_statuses
function table_service_statuses($job, $service_statusesId) {
    $database = new Database();

    switch ($job) {

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

        case 'select':
            if ($service_statusesId == NULL || $service_statusesId == "" || empty($service_statusesId)) {
                $query = "SELECT * FROM service_statuses ;";
                $database->query($query);
            }
            else {
                $query = "SELECT * FROM service_statuses WHERE Id = :service_statusesId ;";
                $database->query($query);
                $database->bind(':service_statusesId' , $service_statusesId);
            }
            return $r = $database->resultset();

            break;

        case 'update':
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
                $database->bind(':service_statusesId', $service_typesId);
            break;

        case 'check':
            $Code = strtoupper($_REQUEST['Code']);
            $Description = trim($_REQUEST['Description']);

            $query = "SELECT Id FROM service_statuses WHERE Code = :Code ;";
            $database->query($query);
            $database->bind(':Code', $Code);
            return $r = $database->rowCount();
            break;

        default:
            # code...
            break;
    }
}

?>
