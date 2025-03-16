<?php
$conn = new mysqli('localhost', 'root', '', 'lending');

// Fetch all loans with client details
$result = $conn->query("SELECT l.*, c.surname, c.first_name, c.middle_name 
                        FROM loans l
                        INNER JOIN clients c ON l.client_id = c.client_id");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex">


    <?php include 'component/sidebar.php'; ?>


    <!-- Main Content -->
    <div class="flex-1 ml-64 p-8">
        <div class="max-w-6xl mx-auto bg-white p-8 rounded shadow-md">
            <h2 class="text-2xl font-semibold mb-6">Client Loan Records</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-blue-800 text-white">
                            <th class="border p-3">Client Name</th>
                            <th class="border p-3">Loan Type</th>
                            <th class="border p-3">Loan Amount</th>
                            <th class="border p-3">Loan Term</th>
                            <th class="border p-3">Interest Rate</th>
                            <th class="border p-3">Total Due</th>
                            <th class="border p-3">Amortization</th>
                            <th class="border p-3">Balance</th>
                            <th class="border p-3">Loan Status</th>
                            <th class="border p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($loan = $result->fetch_assoc()) {
                            // Determine loan status
                            $status = 'Ongoing';
                            if ($loan['balance'] == 0) {
                                $status = 'Fully Paid';
                            } elseif (strtotime($loan['last_payment']) < strtotime(date('Y-m-d')) && $loan['balance'] > 0) {
                                $status = 'Late Payment';
                            }
                        ?>
                            <tr class="hover:bg-gray-100">
                                <td class="border p-3"><?php echo $loan['surname'] . ', ' . $loan['first_name'] . ' ' . $loan['middle_name']; ?></td>
                                <td class="border p-3"><?php echo $loan['loan_type']; ?></td>
                                <td class="border p-3">₱<?php echo number_format($loan['loan_amount'], 2); ?></td>
                                <td class="border p-3"><?php echo $loan['loan_term']; ?> months</td>
                                <td class="border p-3"><?php echo $loan['interest_rate']; ?>%</td>
                                <td class="border p-3">₱<?php echo number_format($loan['total_due'], 2); ?></td>
                                <td class="border p-3">₱<?php echo number_format($loan['amortization'], 2); ?></td>
                                <td class="border p-3">₱<?php echo number_format($loan['balance'], 2); ?></td>
                                <td class="border p-3">
                                    <span class="<?php echo ($status === 'Late Payment') ? 'text-red-500 font-semibold' : (($status === 'Fully Paid') ? 'text-green-500 font-semibold' : 'text-blue-500 font-semibold'); ?>">
                                        <?php echo $status; ?>
                                    </span>
                                </td>
                                <td class="border p-3">
                                    <a href="loan_summary.php?loan_id=<?php echo $loan['loan_id']; ?>" class="text-blue-500 hover:underline">View Details</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>