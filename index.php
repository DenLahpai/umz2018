<!DOCTYPE html>
<html>
    <head>
    <?php
    $title = "Welcome";
    include_once "./includes/head.html";
    ?>
    </head>
    <body>
        <div class="login"><!-- form login -->
            <form class="" action="login.php" method="post">
                <ul>
                    <li>
                        <input type="text" name="Username" id="Username" placeholder="Username">
                    </li>
                    <li>
                        <input type="password" name="Password" id="Password" placeholder="Password">
                    </li>
                    <li>
                        <button type="submit" name="buttonSubmit" id="loginButton">Login</button>
                    </li>
                </ul>
            </form>
        </div><!-- form login -->
    </body>
</html>
