<?php
require_once "functions.php";

//getting posts Id
$postsId = trim($_REQUEST['postsId']);

if (!is_numeric ($postsId)) {
    echo "There has been an error! Please go back and try again!";
    die();
}

$rows_posts = table_posts ('select_one', $postsId, NULL);
foreach ($rows_posts as $row_posts) {
    // code...
}

//checking if the current user is the owner of the post 
if ($_SESSION['usersId'] != $row_posts->UserId) {
	echo "Only the owner of this post can edit it!";
	die();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Post";
    include "includes/head.html";
    ?>
    <body>
		<!-- content -->
		<div class="content">
			<?php
			$header = "Edit Post";
			include "includes/header.html";
			include "includes/main_menu.html";
			?>
			<main>
				<form id="theform" action="#" method="post">
					
				
					
				</form>	
			</main>	
		</div>		
		<!-- end of content -->
    </body>
</html>
