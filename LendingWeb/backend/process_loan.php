<?php
$conn = new mysqli('localhost', 'root', '', 'lending');

// Fetch the latest client_id from clients table
$result = $conn->query("SELECT client_id FROM clients ORDER BY client_id DESC LIMIT 1");
$row = $result->fetch_assoc();
$client_id = $row['client_id'];

// Get loan details from the form
$loan_type = $_POST['loan_type'];
$loan_amount = $_POST['loan_amount'];
$loan_term = $_POST['loan_term'];
$interest_rate = $_POST['interest_rate'];
$first_payment = $_POST['first_payment'];
$last_payment = $_POST['last_payment'];
$late_penalty = $_POST['late_payment_penalty']; // New field

$monthly_interest = ($interest_rate / 100) / 12;
$amortization = $loan_amount * $monthly_interest / (1 - pow(1 + $monthly_interest, -$loan_term));
$total_due = $amortization * $loan_term;
$balance = $total_due;

// Insert Loan Details into Database
$conn->query("INSERT INTO loans 
    (client_id, loan_type, loan_amount, loan_term, interest_rate, total_due, amortization, first_payment, late_payment_penalty, last_payment, balance) 
    VALUES ('$client_id', '$loan_type', '$loan_amount', '$loan_term', '$interest_rate', '$total_due', '$amortization', '$first_payment', '$late_penalty', '$last_payment', '$balance')");

// ✅ Get the last inserted loan_id
$loan_id = $conn->insert_id;

// ✅ Redirect to loan summary
header("Location: ../loan_summary.php?loan_id=$loan_id");
