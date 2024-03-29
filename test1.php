<?php
// Include your database connection
include 'db_config.php';

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Define an array to hold ticket data for all months of the year
$ticketData = array_fill(1, 12, ['Month' => '', 'TotalTickets' => 0, 'ClosedTickets' => 0]);

// Populate the array with month names
$monthNames = [
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
];

// Query the database to get the ticket data (status and count) for each month of the current year
$currentYear = date('Y');
$sql = "SELECT MONTH(created_at) AS Month, COUNT(*) AS TotalTickets, SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) AS ClosedTickets
        FROM tickets
        WHERE YEAR(created_at) = $currentYear
        GROUP BY MONTH(created_at)";
$result = $conn->query($sql);

// Process the query result and update the ticketData array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $monthNumber = (int)$row['Month'];
        $ticketData[$monthNumber] = [
            'Month' => $monthNames[$monthNumber],
            'TotalTickets' => (int)$row['TotalTickets'],
            'ClosedTickets' => (int)$row['ClosedTickets']
        ];
    }
}

// Convert the PHP array to JSON for JavaScript consumption
$ticketDataJSON = json_encode(array_values($ticketData));
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Statistics</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Ticket Count vs Closed Tickets (Current Year)</h1>
    <!-- Chart canvas -->
    <canvas id="myAreaChart" width="800" height="400"></canvas>

    <script>
        // JavaScript code to create the area chart
        document.addEventListener('DOMContentLoaded', function () {
            // Parse the PHP JSON data
            const ticketData = <?php echo $ticketDataJSON; ?>;

            // Extract month names, total tickets, and closed tickets data
            const months = ticketData.map(data => data.Month);
            const totalTickets = ticketData.map(data => data.TotalTickets);
            const closedTickets = ticketData.map(data => data.ClosedTickets);

            // Chart.js configuration
            const config = {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Total Tickets',
                            data: totalTickets,
                            fill: false,
                            borderColor: 'blue',
                            tension: 0.4
                        },
                        {
                            label: 'Closed Tickets',
                            data: closedTickets,
                            fill: false,
                            borderColor: 'green',
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Ticket Count'
                            }
                        }
                    }
                }
            };

            // Create the chart
            const ctx = document.getElementById('myAreaChart').getContext('2d');
            new Chart(ctx, config);
        });
    </script>
</body>
</html>
