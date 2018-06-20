<?php
require "functions.php";

//getting data from the table
if (isset($_REQUEST['buttonSearch'])) {
    $search = $_REQUEST['search'];
}
else {
    $search = NULL;
}

if(empty($search) || $search == NULL || $search == "") {
    $rows_supplier_contacts = table_supplier_contacts('select', NULL);
}
else {
    $rows_supplier_contacts = table_supplier_contacts('search', $search);
}
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
            <main>
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    foreach ($rows_supplier_contacts as $row_supplier_contacts) {
                        echo "<!-- grid-item -->";
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        echo "<li>".$row_supplier_contacts->Title.". ".$row_supplier_contacts->Name."</li>";
                        echo "<li>".$row_supplier_contacts->Position."</li>";
                        echo "<li>".$row_supplier_contacts->Department."</li>";
                        echo "<li style=\"font-weight: bold;\">".$row_supplier_contacts->suppliersName."</li>";
                        echo "<li>".$row_supplier_contacts->Mobile."</li>";
                        echo "<li><a href=\"mailto:$row_supplier_contacts->Email\">".$row_supplier_contacts->Email."</a></li>";
                        echo "<li style=\"text-align: center;\"><a href=\"edit_supplier_contact.php?supplier_contactsId=$row_supplier_contacts->supplier_contactsId\">Edit</a></li>";
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
