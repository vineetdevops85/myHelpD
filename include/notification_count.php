<?php
// Fetch count of new open tickets
$sql_new_open = "SELECT COUNT(*) as new_open_count FROM tickets WHERE status = 'open' AND is_new = 1";
$result_new_open = $conn->query($sql_new_open);
$new_open_count = $result_new_open->fetch_assoc()['new_open_count'];
if ($new_open_count > 0) : ?>
    <span class="badge badge-danger badge-counter"><?php echo $new_open_count; ?></span>
<?php endif;

?>