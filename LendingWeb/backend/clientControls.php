<?php

$conn = new mysqli('localhost', 'root', '', 'lending');
// Handle Edit Request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_client'])) {
    $client_id = $_POST['edit_client_id'];
    $name = $_POST['edit_full_name'];
    $contact = $_POST['edit_contact_no'];

    $conn->query("UPDATE clients SET surname = '$name', contact_no = '$contact' WHERE client_id = $client_id");
    header("Location:../customer_records.php
    ");
}

// Handle Delete Request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    $client_id = $_POST['delete_client_id'];

    $conn->query("DELETE FROM clients WHERE client_id = $client_id");
    header("Location: ../customer_records.php
    ");
}