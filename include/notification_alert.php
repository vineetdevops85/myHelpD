<?php
// Check if there are new tickets
$sql_new_tickets = "SELECT t.*, u.username 
                    FROM tickets t 
                    INNER JOIN users u ON t.user_id = u.user_id
                    WHERE t.status = 'open' AND t.is_new = 1";
$result_new_tickets = $conn->query($sql_new_tickets);

if ($result_new_tickets->num_rows > 0) {
    while ($new_ticket = $result_new_tickets->fetch_assoc()) {
        $ticket_id = $new_ticket['ticket_id'];
        $user_name = $new_ticket['username'];
        $created_at = $new_ticket['created_at'];

        echo '<a class="dropdown-item d-flex align-items-center" href="view_ticket.php?ticket_id=' . $ticket_id . '" onclick="removeAlert(this)">
                <div class="mr-3">
                    <div class="icon-circle bg-danger">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">' . $created_at . '</div>
                    <span class="font-weight-bold">A New Ticket ' . $ticket_id . ' has been created by ' . $user_name . '</span>
                </div>
            </a>';
    }
} else {
    // Display a message if no new tickets
    echo '<a class="dropdown-item d-flex align-items-center" href="#">
            <div class="mr-3">
                <div class="icon-circle bg-success">
                    <i class="fas fa-check text-white"></i>
                </div>
            </div>
            <div>
                <div class="small text-gray-500">No new tickets</div>
            </div>
        </a>';
}
?>

<script>
    function removeAlert(element) {
        element.parentNode.removeChild(element); // Remove the clicked alert from the list
    }
</script>
