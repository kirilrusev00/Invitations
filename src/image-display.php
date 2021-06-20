<?php
// Include the database configuration file
require_once(realpath(dirname(__FILE__) . '/backend/db/config.php'));

// Get resources from the database
$db = new Database();
$query = $db->getConnection()->query("SELECT * FROM resources ORDER BY id DESC");

if ($query->num_rows > 0) {
  while ($row = $query->fetch_assoc()) {
    $imageURL = 'uploads/' . $row["file_name"];
?>
    <img src="<?php echo $imageURL; ?>" alt="" />
  <?php }
} else { ?>
  <p>No image(s) found...</p>
<?php } ?>