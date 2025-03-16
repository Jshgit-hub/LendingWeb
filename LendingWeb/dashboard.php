<?php
$conn = new mysqli('localhost', 'root', '', 'lending');

// Get total client count
$total_clients = $conn->query("SELECT COUNT(*) as count FROM clients")->fetch_assoc()['count'];

// Customer Count by Gender
$gender_count = $conn->query("SELECT gender, COUNT(*) as count FROM clients GROUP BY gender")->fetch_all(MYSQLI_ASSOC);

// Payment Status Count
$payment_status = $conn->query("
    SELECT 
        COUNT(CASE WHEN balance = 0 THEN 1 END) AS paid,
        COUNT(CASE WHEN balance > 0 THEN 1 END) AS unpaid
    FROM loans
")->fetch_assoc();

// Total Payment Summary
$payment_summary = $conn->query("
    SELECT 
        IFNULL(SUM(amount_paid), 0) AS total_paid, 
        IFNULL(SUM(l.balance), 0) AS total_due
    FROM loans l
    LEFT JOIN payments p ON l.loan_id = p.loan_id
")->fetch_assoc();

$months = [];
for ($i = 0; $i < 12; $i++) {
    $months[date('M-Y', strtotime("+$i months"))] = ['paid' => 0, 'unpaid' => 0];
}

// Query to get the number of clients who paid or not each month
$monthly_payments = $conn->query("
    SELECT 
        DATE_FORMAT(p.payment_date, '%b-%Y') AS month, 
        COUNT(DISTINCT CASE WHEN p.amount_paid > 0 THEN l.client_id END) AS paid,
        COUNT(DISTINCT CASE WHEN p.amount_paid = 0 OR p.amount_paid IS NULL THEN l.client_id END) AS unpaid
    FROM loans l
    LEFT JOIN payments p ON l.loan_id = p.loan_id
    WHERE p.payment_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
    GROUP BY month
    ORDER BY STR_TO_DATE(month, '%b-%Y')
");

// Store results in an array
while ($row = $monthly_payments->fetch_assoc()) {
    $months[$row['month']] = ['paid' => $row['paid'], 'unpaid' => $row['unpaid']];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <?php include 'component/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="ml-64 p-8 w-full">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Admin Dashboard</h2>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-gray-600">Total Clients</h3>
                    <p class="text-3xl font-bold text-blue-600"><?= $total_clients ?></p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-gray-600">Total Paid Loans</h3>
                    <p class="text-3xl font-bold text-green-600"><?= $payment_status['paid'] ?></p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-gray-600">Total Unpaid Loans</h3>
                    <p class="text-3xl font-bold text-red-600"><?= $payment_status['unpaid'] ?></p>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-gray-600">Total Payments Received</h3>
                    <p class="text-3xl font-bold text-green-500">₱<?= number_format($payment_summary['total_paid'], 2) ?></p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-gray-600">Total Outstanding Balance</h3>
                    <p class="text-3xl font-bold text-red-500">₱<?= number_format($payment_summary['total_due'], 2) ?></p>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-gray-600 mb-4">Client Gender Distribution</h3>
                    <canvas id="genderChart"></canvas>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md ">
                    <h3 class="text-gray-600 mb-4 text-lg font-semibold">Monthly Payment Monitoring</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border border-gray-300 px-4 py-2">Month</th>
                                    <th class="border border-gray-300 px-4 py-2">Paid</th>
                                    <th class="border border-gray-300 px-4 py-2">Unpaid</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_reverse($months) as $month => $data): ?>
                                    <tr class="text-center">
                                        <td class="border border-gray-300 px-4 py-2"><?= $month ?></td>
                                        <td class="border border-gray-300 px-4 py-2"><?= $data['paid'] ?></td>
                                        <td class="border border-gray-300 px-4 py-2"><?= $data['unpaid'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>



            </div>
        </div>
    </div>

    <script>
        // Gender Chart Data
        const genderData = {
            labels: <?= json_encode(array_column($gender_count, 'gender')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($gender_count, 'count')) ?>,
                backgroundColor: ['#3b82f6', '#f43f5e']
            }]
        };

        // Gender Chart
        new Chart(document.getElementById('genderChart'), {
            type: 'pie',
            data: genderData
        });
    </script>

</body>

</html>