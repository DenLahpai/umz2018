<?php
require "functions.php";

//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

//getting data from the table
if (isset($_REQUEST['buttonSearch'])) {
    $search = $_REQUEST['search'];
}
else {
    $search = NULL;
}

if(empty($search) || $search == NULL || $search == "") {
    $rows_suppliers = table_suppliers('select', NULL);
}
else {
    $rows_suppliers = table_suppliers('search', $search);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<?php
	$page_title = "Suppliers";
	include "includes/head.html";
	?>
	<body>
		<!-- content -->
		<div class="content">
			<?php
			$header = "Suppliers";
			include "includes/header.html";
			include "includes/main_menu.html";
			?>
            <!-- sub-menu -->
			<div class="sub-menu">
				<form action="#" method="post">
                <ul>
                    <li>
                        <a href="new_supplier.php">
                            <button type="button" class="button medium" name="button">Create New Supplier</button></a>
                    </li>
                    <li>
                        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search Suppliers">
                        <button type="submit" class="button search" name="buttonSearch">Search</button>
                    </li>
                </ul>
                </form>
			</div>
            <!-- end of sub-menu -->
            <main>
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    foreach ($rows_suppliers as $row_suppliers) {
                        echo "<!-- grid-item -->";
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        echo "<li style=\"font-weight: bold;\">".$row_suppliers->Name."</li>";
                        echo "<li>".$row_suppliers->Address."</li>";
                        echo "<li>".$row_suppliers->City."</li>";
                        echo "<li>".$row_suppliers->Phone."</li>";
                        echo "<li>".$row_suppliers->Email."</li>";
                        echo "<li style=\"text-align: center;\"><a href=\"edit_supplier.php?suppliersId=$row_suppliers->Id\"><button class=\"button link\">Edit</button></a></li>";
                        echo "</ul>";
                        echo "</div>";
                        echo "<!-- end of grid-item -->";
                    }
                     ?>
                </div>
                <!-- end of grid-div -->
            </main>
		</div>
		<!-- end of content -->
		<?php include "includes/footer.html"; ?>
	</body>
</html>
