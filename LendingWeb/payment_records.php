<?php
$conn = new mysqli('localhost', 'root', '', 'lending');

// Fetch all payments with loan details
$all_payments = $conn->query("SELECT p.*, l.amortization, l.balance, c.surname, c.first_name, l.loan_type 
                              FROM payments p
                              INNER JOIN loans l ON p.loan_id = l.loan_id
                              INNER JOIN clients c ON l.client_id = c.client_id");

// Fetch late payments
$late_payments = $conn->query("SELECT p.*, l.amortization, l.balance, c.surname, c.first_name, l.loan_type, l.late_payment_penalty 
                               FROM payments p
                               INNER JOIN loans l ON p.loan_id = l.loan_id
                               INNER JOIN clients c ON l.client_id = c.client_id
                               WHERE l.late_payment_penalty > 0");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Records</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function openTab(tabName) {
            document.getElementById("allPayments").classList.add("hidden");
            document.getElementById("latePayments").classList.add("hidden");

            document.getElementById(tabName).classList.remove("hidden");

            document.getElementById("tabAll").classList.remove("border-blue-500", "text-blue-600");
            document.getElementById("tabLate").classList.remove("border-blue-500", "text-blue-600");

            document.getElementById(tabName === "allPayments" ? "tabAll" : "tabLate")
                .classList.add("border-blue-500", "text-blue-600");
        }

        function filterTable() {
            let searchInput = document.getElementById("search").value.toLowerCase();
            let rows = document.querySelectorAll("#allPayments tbody tr, #latePayments tbody tr");

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(searchInput) ? "" : "none";
            });
        }

        function updateEntries() {
            let entries = document.getElementById("entries").value;
            let rows = document.querySelectorAll("#allPayments tbody tr, #latePayments tbody tr");

            rows.forEach((row, index) => {
                row.style.display = index < entries ? "" : "none";
            });
        }
    </script>
</head>

<body class="bg-gray-100 flex flex-col md:flex-row">

    <?php include 'component/sidebar.php'; ?>

    <div class="flex-1 p-6 md:ml-64">
        <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Payment Records</h2>

            <div class="flex justify-between mb-4">
                <select id="entries" onchange="updateEntries()" class="p-2 border rounded-md">
                    <option value="10">Show 10</option>
                    <option value="20">Show 20</option>
                    <option value="50">Show 50</option>
                </select>

                <input type="text" id="search" onkeyup="filterTable()" placeholder="Search..."
                    class="p-2 border rounded-md w-1/4">

            </div>

            <div class="flex space-x-2 border-b mb-4">
                <button id="tabAll" onclick="openTab('allPayments')" class="flex-1 text-center py-2 border-b-2 border-blue-500 text-blue-600 font-medium">
                    All Payments
                </button>
                <button id="tabLate" onclick="openTab('latePayments')" class="flex-1 text-center py-2 text-gray-600 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-300">
                    Late Payments
                </button>
            </div>

            <!-- All Payments Table -->
            <div id="allPayments">
                <div class="w-full overflow-x-auto">
                    <table class="w-full border border-gray-300 rounded-lg">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="border p-2">Payment ID</th>
                                <th class="border p-2">Client Name</th>
                                <th class="border p-2">Loan Type</th>
                                <th class="border p-2">Amortization</th>
                                <th class="border p-2">Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($payment = $all_payments->fetch_assoc()) {
                                $status = $payment['balance'] == 0 ? "Paid" : "Unpaid";
                                $statusClass = $status == "Paid" ? "text-green-500" : "text-red-500";
                            ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="border p-2"><?php echo $payment['payment_id']; ?></td>
                                    <td class="border p-2"><?php echo $payment['surname'] . ', ' . $payment['first_name']; ?></td>
                                    <td class="border p-2"><?php echo $payment['loan_type']; ?></td>
                                    <td class="border p-2">₱<?php echo number_format($payment['amortization'], 2); ?></td>
                                    <td class="border p-2 font-semibold <?php echo $statusClass; ?>"><?php echo $status; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Late Payments Table -->
            <div id="latePayments" class="hidden">
                <div class="w-full overflow-x-auto">
                    <table class="w-full border border-gray-300 rounded-lg">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="border p-2">Payment ID</th>
                                <th class="border p-2">Client Name</th>
                                <th class="border p-2">Loan Type</th>
                                <th class="border p-2">Amortization</th>
                                <th class="border p-2">Late Payment Penalty</th>
                                <th class="border p-2">Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($payment = $late_payments->fetch_assoc()) {
                                $status = $payment['balance'] == 0 ? "Paid" : "Unpaid";
                                $statusClass = $status == "Paid" ? "text-green-500" : "text-red-500";
                            ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="border p-2"><?php echo $payment['payment_id']; ?></td>
                                    <td class="border p-2"><?php echo $payment['surname'] . ', ' . $payment['first_name']; ?></td>
                                    <td class="border p-2"><?php echo $payment['loan_type']; ?></td>
                                    <td class="border p-2">₱<?php echo number_format($payment['amortization'], 2); ?></td>
                                    <td class="border p-2 text-red-500">₱<?php echo number_format($payment['late_payment_penalty'], 2); ?></td>
                                    <td class="border p-2 font-semibold <?php echo $statusClass; ?>"><?php echo $status; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        openTab('allPayments');
        updateEntries();
    </script>

</body>

</html>