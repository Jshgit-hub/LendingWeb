<?php
$conn = new mysqli('localhost', 'root', '', 'lending');

$loan_id = $_POST['loan_id'];
$amount_paid = $_POST['amount_paid'];

// Get Current Loan Balance
$loan = $conn->query("SELECT balance FROM loans WHERE loan_id = $loan_id")->fetch_assoc();
$current_balance = $loan['balance'];

// Prevent Overpayment
if ($amount_paid > $current_balance) {
    $amount_paid = $current_balance;
}

// Deduct Payment from Current Balance
$new_balance = $current_balance - $amount_paid;

// Insert Payment Record
$conn->query("INSERT INTO payments (loan_id, amount_paid, payment_date, remaining_balance) 
VALUES ('$loan_id', '$amount_paid', NOW(), '$new_balance')");

// Update Loan Balance
$conn->query("UPDATE loans SET balance = '$new_balance' WHERE loan_id = '$loan_id'");

// Automatically Update Loan Status to Fully Paid
if ($new_balance == 0) {
    $conn->query("UPDATE loans SET status = 'Fully Paid' WHERE loan_id = '$loan_id'");
}

header("Location: ../loan_summary.php?loan_id=$loan_id");
