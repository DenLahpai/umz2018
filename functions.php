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
        // TODO
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
            Email,
            Website
            ) LIKE :search
        ;";
        $database->query($query);
        $database->bind(':search', $search);
        return $r = $database->resultset();
    }
}

?>
