
<!-- modal -->
<div class="modal" id="modal">
    <!-- modal-content -->
    <div class="modal-content">
        <!-- modal-header -->
        <div class="modal-header">
            <h3>
                Select a Guide!
                <span id="modalClose">&times;</span>
            </h3>
        </div>
        <!-- end of modal-header -->
        <!-- modal-body -->
        <div class="modal-body">
            <?php
            $rows_tour_guides_modal = table_tour_guides('select', NULL);
            foreach ($rows_tour_guides_modal as $row_tour_guides_modal) {
                echo "<button value=\"$row_tour_guides_modal->Id\" id=\"$row_tour_guides_modal->Id\" onclick=\"selectGuide($row_tour_guides_modal->Id)\">".$row_tour_guides_modal->Name." - ".$row_tour_guides_modal->Language."</button>";
            }
            ?>
        </div>
        <!-- end of modal-body -->
    </div>
    <!-- end of modal-content -->
</div>
<!-- end of modal -->
