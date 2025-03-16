<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'lending');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Store client information
$insertClient = $conn->prepare("
    INSERT INTO clients (surname, first_name, middle_name, gender, age, birthdate, civil_status, living_arrangement, religion, contact_no, email, id_number)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$insertClient->bind_param(
    "ssssissssssi",
    $_POST['surname'],
    $_POST['first_name'],
    $_POST['middle_name'],
    $_POST['gender'],
    $_POST['age'],
    $_POST['birthdate'],
    $_POST['civil_status'],
    $_POST['living_arrangement'],
    $_POST['religion'],
    $_POST['contact_no'],
    $_POST['email'],
    $_POST['IdNum']
);
$insertClient->execute();

// Get the last inserted client_id
$client_id = $conn->insert_id;

// Insert Permanent Address
$insertAddress = $conn->prepare("
    INSERT INTO addresses (client_id, type, house_no, street, barangay, municipality, province, zip_code)
    VALUES (?, 'Permanent', ?, ?, ?, ?, ?, ?)
");
$insertAddress->bind_param(
    "issssss",
    $client_id,
    $_POST['perm_house_no'],
    $_POST['perm_street'],
    $_POST['perm_barangay'],
    $_POST['perm_municipality'],
    $_POST['perm_province'],
    $_POST['perm_zip']
);
$insertAddress->execute();

// Insert Present Address
$insertAddress = $conn->prepare("
    INSERT INTO addresses (client_id, type, house_no, street, barangay, municipality, province, zip_code)
    VALUES (?, 'Present', ?, ?, ?, ?, ?, ?)
");
$insertAddress->bind_param(
    "issssss",
    $client_id,
    $_POST['pres_house_no'],
    $_POST['pres_street'],
    $_POST['pres_barangay'],
    $_POST['pres_municipality'],
    $_POST['pres_province'],
    $_POST['pres_zip'],

);
$insertAddress->execute();

// Insert Source of Income and Remittance
$insertIncome = $conn->prepare("
    INSERT INTO income_sources (client_id, company_name, position, salary, years_in_job, sender_name, sender_relationship, monthly_remittance)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");
$insertIncome->bind_param(
    "ississsi",
    $client_id,
    $_POST['company'],
    $_POST['position'],
    $_POST['salary'],
    $_POST['years_in_job'],
    $_POST['sender_name'],
    $_POST['sender_relationship'],
    $_POST['monthly_remittance']
);
$insertIncome->execute();

// Insert Reference
$insertReference = $conn->prepare("
    INSERT INTO client_references (client_id, ref_name, ref_contact, ref_relationship)
    VALUES (?, ?, ?, ?)
");
$insertReference->bind_param(
    "isss",
    $client_id,
    $_POST['ref_name'],
    $_POST['ref_contact'],
    $_POST['ref_relationship']
);
$insertReference->execute();

// Close all prepared statements
$insertClient->close();
$insertAddress->close();
$insertIncome->close();
$insertReference->close();

// Close database connection
$conn->close();

// Redirect to success page
header("Location: ../Loanform.php");
exit;
