<?php
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

?>
