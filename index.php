<?php
require "../conn.php";
?>
<!DOCTYPE html>
<html>
    <head>
    <?php
    $title = "Welcome";
    include_once "./includes/head.html";
    ?>
    </head>
    <body>
        <div class="login"><!-- login -->
            <form class="" action="login.php" method="post">
                <ul>
                    <li>
                        <h3>Please Login!</h3>
                    </li>
                    <li class="notice error">
                        <?php
                        if (isset($_REQUEST['error'])) {
                            if($_REQUEST['error'] == 1) {
                                echo "Wrong Username or Password!";
                            }
                            elseif($_REQUEST['error'] == 2) {
                                echo "Session Timed Out! Please login again!";
                            }
                        }
                        ?>
                    </li>
                    <li>
                        <input type="text" name="Username" id="Username" placeholder="Username" required>
                    </li>
                    <li>
                        <input type="password" name="Password" id="Password" placeholder="Password" required>
                    </li>
                    <li>
                        <button type="submit" name="buttonSubmit" class="button big" id="loginButton">Login</button>
                    </li>
                </ul>
            </form>
        </div><!-- end of login -->
    </body>
    <?php
    include "includes/footer.html"
    ?>
    <script type="text/javascript" src="./js/scripts.js">

    </script>
</html>
