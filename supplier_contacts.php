<?php
require "functions.php";

//getting data from the table
if (isset($_REQUEST['buttonSearch'])) {
    $search = $_REQUEST['search'];
}
else {
    $search = NULL;
}
//
// if(empty($search) || $search == NULL || $search == "") {
//     $rows_suppliers = table_suppliers('select', NULL);
// }
// else {
//     $rows_suppliers = table_suppliers('search', $search);
// }
?>
<!DOCTYPE html>
<html>
	<?php
	$page_title = "Supplier Contacts";
	include "includes/head.html";
	?>
	<body>
		<!-- content -->
		<div class="content">
			<?php
			$header = "Supplier Contacts";
			include "includes/header.html";
			include "includes/main_menu.html";
			?>
			<!-- sub-menu -->
			<div class="sub-menu">
				<form action="#" method="post">
                <ul>
                    <li>
                        <a href="new_supplier_contact.php">
                            <button type="button" class="button medium" name="button">Create New Supplier Contact</button></a>
                    </li>
                    <li>
                        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search Supplier Contacts">
                        <button type="submit" class="button search" name="buttonSearch">Search</button>
                    </li>
                </ul>
                </form>
			</div>
            <!-- end of sub-menu -->
		</div>
		<!-- end of content -->
	</body>
</html>
