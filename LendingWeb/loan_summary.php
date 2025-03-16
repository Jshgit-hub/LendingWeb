<?php
$conn = new mysqli('localhost', 'root', '', 'lending');

$loan_id = $_GET['loan_id'];

// Get Loan Details
$loan = $conn->query("SELECT l.*, c.surname, c.first_name 
    FROM loans l
    INNER JOIN clients c ON l.client_id = c.client_id
    WHERE l.loan_id = $loan_id")->fetch_assoc();

// Get Payment History
$payments = $conn->query("SELECT * FROM payments WHERE loan_id = $loan_id ORDER BY payment_date ASC");

// Calculate Late Payment Penalty
$current_date = date('Y-m-d');

if ($current_date > $loan['last_payment']) {
    $penalty_amount = ($loan['total_due'] * ($loan['late_payment_penalty'] / 100));
    $new_balance = $loan['balance'] + $penalty_amount;

    // Add late payment penalty to the balance
    $conn->query("UPDATE loans SET balance = '$new_balance' WHERE loan_id = '$loan_id'");

    // Update the loan array to reflect the new balance
    $loan['balance'] = $new_balance;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Summary</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-6">

    <div class="w-full max-w-4xl bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 border-b pb-4 mb-6">Loan Summary</h2>

        <!-- Loan Information -->
        <div class="grid grid-cols-2 gap-4 mb-6 text-gray-700">
            <div><strong>Client Name:</strong> <?= $loan['surname'] . ', ' . $loan['first_name'] ?></div>
            <div><strong>Loan Type:</strong> <?= $loan['loan_type'] ?></div>
            <div><strong>Loan Amount:</strong> ₱<?= number_format($loan['loan_amount'], 2) ?></div>
            <div><strong>Loan Term:</strong> <?= $loan['loan_term'] ?> Months</div>
            <div><strong>Interest Rate:</strong> <?= $loan['interest_rate'] ?>%</div>
            <div><strong>Total Due:</strong> ₱<?= number_format($loan['total_due'], 2) ?></div>
            <div><strong>Monthly Payment:</strong> ₱<?= number_format($loan['amortization'], 2) ?></div>
            <div><strong>First Payment:</strong> <?= $loan['first_payment'] ?></div>
            <div><strong>Last Payment:</strong> <?= $loan['last_payment'] ?></div>
            <div class="text-red-500"><strong>Late Payment Penalty:</strong> <?= $loan['late_payment_penalty'] ?>%</div>
            <div class="text-blue-600 text-lg font-semibold"><strong>Remaining Balance:</strong> ₱<?= number_format($loan['balance'], 2) ?></div>
        </div>

        <!-- Payment History -->
        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Payment History</h3>
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                <thead>
                    <tr class="bg-blue-900 text-white text-left text-sm">
                        <th class="p-3">Date</th>
                        <th class="p-3 text-right">Amount Paid</th>
                        <th class="p-3 text-right">Remaining Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($payment = $payments->fetch_assoc()): ?>
                        <tr class="even:bg-gray-100 hover:bg-gray-50 text-sm">
                            <td class="p-3 border"><?= $payment['payment_date'] ?></td>
                            <td class="p-3 border text-right">₱<?= number_format($payment['amount_paid'], 2) ?></td>
                            <td class="p-3 border text-right">₱<?= number_format($payment['remaining_balance'], 2) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Payment Form -->
        <h3 class="text-lg font-semibold mb-4">Make Payment</h3>

        <?php if ($loan['status'] === 'Fully Paid'): ?>
            <p class="text-green-500 mb-4">This loan is fully paid.</p>
        <?php else: ?>
            <form action="../backend/process_payment.php" method="POST">
                <input type="hidden" name="loan_id" value="<?= $loan_id ?>">
                <input class="border p-2 w-full rounded mb-4" type="number" step="0.01" name="amount_paid"
                    placeholder="Amount to Pay" max="<?= $loan['balance'] ?>" required>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">Submit Payment</button>
            </form>
        <?php endif; ?>

    </div>

</body>

</html>