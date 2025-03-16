<?php
$conn = new mysqli('localhost', 'root', '', 'lending');

// Fetch all loans with client details
$result = $conn->query("SELECT l.*, c.surname, c.first_name, c.middle_name 
                        FROM loans l
                        INNER JOIN clients c ON l.client_id = c.client_id");
$loans = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Records</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex">

    <?php include 'component/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 ml-64 p-8">
        <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Client Loan Records</h2>



            <!-- Search and Entries Selector -->
            <div class="flex justify-between items-center mb-4">
                <!-- Entries Selector -->
                <div>
                    <label for="entries" class="text-gray-700">Show</label>
                    <select id="entries" class="border p-2 rounded text-gray-700">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                    <span class="text-gray-700">entries</span>
                </div>

                <!-- Search Bar -->
                <input type="text" id="search" placeholder="Search loans..." class="border p-2 rounded text-gray-700">
            </div>

            <div class="flex justify-start items-center mb-4">
                <a href="add_client.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                    + Add Client
                </a>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table id="loanTable" class="w-full border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                    <thead>
                        <tr class="bg-blue-900 text-white">
                            <th class="p-3 text-left">Client Name</th>
                            <th class="p-3 text-left">Loan Type</th>
                            <th class="p-3 text-right">Loan Amount</th>
                            <th class="p-3 text-center">Loan Term</th>
                            <th class="p-3 text-right">Interest Rate</th>
                            <th class="p-3 text-right">Total Due</th>
                            <th class="p-3 text-right">Amortization</th>
                            <th class="p-3 text-right">Balance</th>
                            <th class="p-3 text-center">Loan Status</th>
                            <th class="p-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="loanBody">
                        <?php foreach ($loans as $loan) {
                            // Determine loan status
                            $status = 'Ongoing';
                            $statusClass = 'text-blue-500';

                            if ($loan['balance'] == 0) {
                                $status = 'Fully Paid';
                                $statusClass = 'text-green-500';
                            } elseif (strtotime($loan['last_payment']) < strtotime(date('Y-m-d')) && $loan['balance'] > 0) {
                                $status = 'Late Payment';
                                $statusClass = 'text-red-500';
                            }
                        ?>
                            <tr class="hover:bg-gray-50 even:bg-gray-100">
                                <td class="p-3 border"><?php echo $loan['surname'] . ', ' . $loan['first_name'] . ' ' . $loan['middle_name']; ?></td>
                                <td class="p-3 border"><?php echo $loan['loan_type']; ?></td>
                                <td class="p-3 border text-right">₱<?php echo number_format($loan['loan_amount'], 2); ?></td>
                                <td class="p-3 border text-center"><?php echo $loan['loan_term']; ?> months</td>
                                <td class="p-3 border text-right"><?php echo $loan['interest_rate']; ?>%</td>
                                <td class="p-3 border text-right">₱<?php echo number_format($loan['total_due'], 2); ?></td>
                                <td class="p-3 border text-right">₱<?php echo number_format($loan['amortization'], 2); ?></td>
                                <td class="p-3 border text-right">₱<?php echo number_format($loan['balance'], 2); ?></td>
                                <td class="p-3 border text-center font-semibold <?php echo $statusClass; ?>">
                                    <?php echo $status; ?>
                                </td>
                                <td class="p-3 border text-center">
                                    <a href="loan_summary.php?loan_id=<?php echo $loan['loan_id']; ?>"
                                        class="text-blue-600 hover:text-blue-800 font-medium">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-between items-center mt-4">
                <span id="showingInfo" class="text-gray-700"></span>
                <div class="space-x-2">
                    <button id="prevPage" class="border px-4 py-2 rounded bg-gray-200 text-gray-700 disabled:opacity-50">Previous</button>
                    <button id="nextPage" class="border px-4 py-2 rounded bg-gray-200 text-gray-700 disabled:opacity-50">Next</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let loans = [...document.querySelectorAll("#loanBody tr")];
        let currentPage = 1;
        let entriesPerPage = parseInt(document.getElementById("entries").value);

        function showLoans() {
            let start = (currentPage - 1) * entriesPerPage;
            let end = start + entriesPerPage;
            document.querySelectorAll("#loanBody tr").forEach(row => row.classList.add("hidden"));
            loans.slice(start, end).forEach(row => row.classList.remove("hidden"));

            document.getElementById("showingInfo").textContent = `Showing ${start + 1}-${Math.min(end, loans.length)} of ${loans.length} entries`;
            document.getElementById("prevPage").disabled = currentPage === 1;
            document.getElementById("nextPage").disabled = end >= loans.length;
        }

        document.getElementById("entries").addEventListener("change", function() {
            entriesPerPage = parseInt(this.value);
            currentPage = 1;
            showLoans();
        });

        document.getElementById("prevPage").addEventListener("click", function() {
            if (currentPage > 1) {
                currentPage--;
                showLoans();
            }
        });

        document.getElementById("nextPage").addEventListener("click", function() {
            if (currentPage * entriesPerPage < loans.length) {
                currentPage++;
                showLoans();
            }
        });

        document.getElementById("search").addEventListener("keyup", function() {
            let query = this.value.toLowerCase();
            loans.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(query) ? "" : "none";
            });
        });

        showLoans();
    </script>
</body>

</html>