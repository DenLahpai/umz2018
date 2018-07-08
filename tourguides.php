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
    $rows_tour_guides = table_tour_guides('select', NULL);
}
else {
    $rows_tour_guides = table_tour_guides('search', $search);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Tour Guides";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Tour Guides";
            include "includes/header.html";
            include "includes/main_menu.html";
            ?>
            <!-- sub-menu -->
            <div class="sub-menu">
                <form action="#" method="post">
                    <ul>
                        <li>
                            <a href="new_tourguide.php">
                                <button type="button" class="button medium" name="button">Create New Guide</button></a>
                        </li>
                        <li>
                            <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search Tour Guides">
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
                    foreach ($rows_tour_guides as $row_tour_guides) {
                        echo "<!-- grid-item -->";
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        echo "<li style=\"font-weight: bold;\">".$row_tour_guides->Title.". ".$row_tour_guides->Name."</li>";
                        echo "<li>".$row_tour_guides->Mobile."</li>";
                        echo "<li>".$row_tour_guides->License.", ".$row_tour_guides->Type."</li>";
                        echo "<li>".$row_tour_guides->Language."</li>";
                        echo "<li><a href=\"mailto: $row_tour_guides->Email\">".$row_tour_guides->Email."</a></li>";
                        echo "<li style=\"text-align: center;\"><a href=\"edit_tourguide.php?tour_guidesId=$row_tour_guides->Id\"><button>Edit</button></a></li>";
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
