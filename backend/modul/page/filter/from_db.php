<?php
include "../../inc/config.php";
$table = $db->query("show table status");
?>

  From <select name="from[]" class="form-control from">
  <option value="">Select Table</option>
  <?php foreach ($table as $tab) {
    echo "<option value='$tab->Name'>$tab->Name</option>";
  }
  ?>
</select>
<div class="isi_on"></div>
